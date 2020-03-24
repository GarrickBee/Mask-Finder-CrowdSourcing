var info,map ;

$(document).ready(function()
{
  initMap();
  // Auto Complete form
  var autocomplete = new google.maps.places.Autocomplete(
    (document.getElementById('google_location')),
    {types: ['geocode']}
  );
  // On Submitting Form
  var mask_form = $('#mask_form');
  mask_form.on("submit",function(e)
  {
    e.preventDefault();
    mask_form_submit();
  });
});

function mask_form_submit()
{
  // Disbale FOrm Submit
  mask_form_processing = true;
  var mask_form = $('#mask_form');
  var location_input = $("#google_location").val();
  const geo = new google.maps.Geocoder();
  // Loading Button
  $('#mask_form_submit').html('<span class="spinner-border spinner-border-sm align-middle" role="status" aria-hidden="true" ></span>  Submitting... ');
  // Disable Submit Button
  $('button[type=submit], input[type=submit]').prop('disabled',true);
  geo.geocode({"address" : location_input }, function(result, status)
  {
    if (status == google.maps.GeocoderStatus.OK)
    {
      var lat = result[0].geometry.location.lat();
      var lng = result[0].geometry.location.lng();
      if (isNaN(lat) || isNaN(lng))
      {
        // Enable Submit BUtton
        $('button[type=submit], input[type=submit]').prop('disabled',false);
        beero_alert('Error Submiting Form',"Something's gone wrong. Try entering a different location.",'danger','10000');
        return;
      }
      // Input Location
      $("#location_longitude").val(lng);
      $("#location_latitude").val(lat);
      var form_values = mask_form.serialize();
      // Check Login
      var user_login_status = check_user_login();
      if (user_login_status == false)
      {
        // Prompt Login
        $("#login_modal").modal("show");
        return false;
      }
      // Ajax Submit
      $.ajax({
        url: base_url+"api/mask_submit",
        type: "post",
        data: form_values ,
        success: function (data)
        {
          var result = jQuery.parseJSON(data);
          if (result.success == true)
          {
            beero_alert('Submitted',result.message,'success','10000');
            return location.reload();
          }
          return beero_alert('Error Submiting Form',result.message,'danger','10000');
        },
        error: function(xhr, status, error)
        {
          // Return default submit button
          $('#mask_form_submit').html('SUBMIT');
          beero_alert('Error Submiting Form',"Please try again later",'danger','10000');
          console.log(xhr.responseText);
        }
      });
    }
    else {
      // Return default submit button
      $('#mask_form_submit').html('SUBMIT');
      beero_alert('Error Submiting Form',"Something's gone wrong. Try entering a different location.",'danger','10000');
      return false;
    }
  });
}

/**
* Initialize Google Map
*/
function initMap()
{
  info = new google.maps.InfoWindow();
  map  = new google.maps.Map(document.getElementById('google_map_mask'), {
    // center: new google.maps.LatLng(1.3521, 103.8198),
    zoom: 12,
    maxZoom: 30,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    styles: [
      {
        featureType: "poi",
        elementType: "labels",
        stylers: [
          { visibility: "off" }
        ]
      },
      {
        featureType: "road",
        elementType: "labels",
        stylers: [
          { visibility: "off" }
        ]
      },
      {
        featureType: 'road',
        elementType: 'labels.text.fill',
        stylers: [{visibility: 'off'}]
      },
      {
        featureType: 'road.highway',
        stylers: [{visibility: 'off'}]
      },
      {
        featureType: 'transit',
        stylers: [{visibility: 'off'}]
      },
    ],
  });

  if (navigator.geolocation)
  {
    navigator.geolocation.getCurrentPosition(function (position)
    {
      initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
      map.setCenter(initialLocation);
    },function()
    {
      default_map_center();
    });
  }
  else
  {
    default_map_center();
  }

  // Get Mask Data
  $.ajax({
    url: base_url+"api/get_mask_data",
    type: "post",
    success: function (data)
    {
      var result = jQuery.parseJSON(data);
      if (result.success == true)
      {
        result.data.forEach(function(item, index)
        {
          var lat = parseFloat(item.latitude);
          var lng = parseFloat(item.longitude);

          if (!isNaN(lat) && !isNaN(lng))
          {
            add_marker(lat ,lng,item);
          }
        });
      }
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText);
    }
  });

}

function  default_map_center()
{
  // default: Singapore
  initialLocation = new google.maps.LatLng(1.3521, 103.8198);
  map.setCenter(initialLocation);
}
/**
* Add info to marker
* @param {object} marker Google Marker Object
* @param {array} data   Mask Data
*/
function add_info(marker, data)
{
  var stock_color;
  switch (data.stock)
  {
    case 'available':
    stock_color = 'text-primary';
    break;
    case 'critical':
    stock_color = 'text-warning';
    break;
    case 'sold out':
    stock_color = 'text-danger';
    break;
    default:
  }
  var d= new Date(data.created);

  var content = `<table>
  <tr>
  <td  colspan='3'  class='text-capitalize  font-weight-bold'>`+data.shop+`</td>
  </tr>`;
  // Item type
  content +=`<tr>
  <td class='text-capitalize'>Item Type</td>
  <td class='px-1'>:</td>
  <td class='text-capitalize'>`+data.item+`</td>
  </tr>`;
  // Date Posted
  content +=`<tr>
  <td class='text-capitalize'>Date Updated</td>
  <td class='px-1'>:</td>
  <td class='text-capitalize'>`+formatDate(d)+`</td>
  </tr>`;
  content +=`<tr>
  <td class='text-capitalize'>Stock Balance</td>
  <td class='px-1'>:</td>
  <td class='text-capitalize font-weight-bold `+stock_color+`'>`+data.stock+`</td>
  </tr>`;
  content +=`<tr>
  <td class='text-capitalize'>Price</td>
  <td class='px-1'>:</td>
  <td class='text-capitalize'>`+data.currency+` `+data.price+`</td>
  </tr>`;
  content +=`<tr>
  <td class='text-capitalize'>Remark</td>
  <td class='px-1'>:</td>
  <td class='text-capitalize'>`+data.remark+`</td>
  </tr>`;
  content +=`</table>`;
  info.setContent(content);
  info.open(map, marker);
}

/**
* Fomat a Date
* @param  {Object} date [description]
* @return {String}      [description]
*/
function formatDate(date)
{
  var monthNames = [
    "January", "February", "March",
    "April", "May", "June", "July",
    "August", "September", "October",
    "November", "December"
  ];
  var day = date.getDate();
  var monthIndex = date.getMonth();
  var year = date.getFullYear();
  return day + ' ' + monthNames[monthIndex] + ' ' + year;
}

/**
* Add Marker
* @param {String} [lat='']  Latitude
* @param {String} [lng='']  Longitude
* @param {String} [data=''] Mask Data
*/
function add_marker(lat='',lng='',data='')
{
  var latLng = new google.maps.LatLng(lat, lng);
  if (!latLng) {
    return;
  }
  var marker = new google.maps.Marker({
    animation: google.maps.Animation.DROP,
    map: map,
    position: latLng,
  });

  google.maps.event.addListener(marker, 'click', function(){
    add_info(marker, data);
  });
  return marker;
}
/**
* Check User Login
* @return {Boolean} [description]
*/
function check_user_login()
{
  var user_login_status = false;
  $.ajax({
    'async': false,
    'type': "POST",
    'global': false,
    'url': base_url+"api/check_user_login",
    'success': function (data) {
      var result = jQuery.parseJSON(data);
      if (result.success == true)
      {
        return user_login_status = true;
      }
      return;
    }
  });
  return user_login_status;
}
