$(document).ready(function () {
  $('#country_search_value').selectize({
  });





});

$('#country_search_button').on("click",function(e)
{
  $('button[type=submit], input[type=submit]').prop('disabled',true);
  $('#country_search_button').html('<span class="spinner-border spinner-border-sm align-middle mr-1" role="status" aria-hidden="true" ></span>  Searching... ');
  var country_search = $("#country_search_value").val();
  get_corona_coutry(country_search);
  $('button[type=submit], input[type=submit]').prop('disabled',false);
  $('#country_search_button').html('Search Now !');
});

function get_corona_coutry(country='')
{
  var country_search,country_name;
  if (country=="" || country == 'all')
  {
    country_search="all";
    country_name = "World";
  }
  else{
    country_search ="countries/"+country;
    country_name = country;
  }

  $.ajax({
    url: "https://corona.lmao.ninja/"+country_search,
    cache: false
  })
  .done(function( data ) {
    if (!data.hasOwnProperty('message'))
    {
      $(".country-name").html(country_name);
      animate_number("#confirmTotal",0,data.cases);
      animate_number("#deathTotal",0,data.deaths);
      animate_number("#healTotal",0,data.recovered);

      if (country_name=='World')
      {
        $(".country-row").removeClass('animated fadeInUp');
        $(".country-row").addClass('animated fadeOutUp').one('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function(e) {
          $(this).css({'display':'none'});
        });
      }
      else
      {
        if( $('.country-row').css('display') == 'none' )
        {
          $(".country-row").removeClass('animated fadeOutUp').one('animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd', function(e) {
            $(this).css({'display':'flex'});
          });
          $(".country-row").addClass('animated fadeInUp').css({'display':'flex'});
        }
      }
      animate_number("#confirmToday",0,data.todayCases);
      animate_number("#deathToday",0,data.todayDeaths);
      animate_number("#healToday",0,data.todayRecovered);
    }
  });
  return true;
}
get_corona_coutry();
