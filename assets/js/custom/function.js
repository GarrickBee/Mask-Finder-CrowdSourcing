$(document).ready(function()
{
  $("#email_subscribe_form").on("submit",function(e)
  {
    e.preventDefault();
    var user_email = $("#subscriber_email").val();
    $.post(base_url+"api/subscribe_email",
    {
      email:   user_email,
    }).done(
      function (data)
      {
        var response = jQuery.parseJSON(data);
        if (response.success)
        {
          beero_alert(response.title,response.message,'success','5000')
          return true;
        }
        beero_alert(response.title,response.message,'danger','5000')
        return false;
      }
    );
  });
});

// User logout
function user_logout()
{
  google_logout();
  FB.logout();
  return   location.href=base_url+"user/logout";
}

//----- Google Auth
function google_login(googleUser)
{
  // Useful data for your client-side scripts:
  var profile = googleUser.getBasicProfile();
  // User Token
  var id_token = googleUser.getAuthResponse().id_token;
  console.log("ID Token: " + id_token);
  // Post User Data
  $.post(base_url+"auth/google_login",
  {
    oauth_provider: 'google',
    google_token:   id_token,
  }).done(
    function (data)
    {
      var response = jQuery.parseJSON(data);
      if (response.success)
      {
        // Disconnect user from google
        gapi.auth2.getAuthInstance().disconnect();
        // Check is in the middle of form submitting
        if (mask_form_processing)
        {
          return mask_form_submit();
        }
        return location.href = base_url;
        // return true;
      }
      else
      {
        return false;
      }
      return;
    }
  );
}

function google_login_failed()
{
  return beero_alert('Google Login Error','Please try again later','danger','');
}

function google_render_button() {
  gapi.signin2.render('google_login_button', {
    'scope': 'profile email',
    'width': 240,
    'height': 50,
    'longtitle': true,
    'theme': 'dark',
    'onsuccess': google_login,
    'onfailure': google_login_failed
  });
}
google_render_button();

function google_logout()
{
  var auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {
    console.log('User signed out.');
  });
}

// -------- Facebook Auth
function login_with_facebook()
{
  FB.getLoginStatus(function(response)
  {
    // User is logined
    if (response.status === 'connected')
    {
      var uid = response.authResponse.userID;
      var accessToken = response.authResponse.accessToken;
      // Check Facebook Access Token
      $.post(base_url+"auth/facebook_login",
      {
        oauth_provider: 'facebook',
        facebook_token: accessToken,
      }).done(function (data)
      {
        var response = jQuery.parseJSON(data);
        if (response.success)
        {
          // Check is in the middle of form submitting
          if (mask_form_processing)
          {
            return mask_form_submit();
          }
          return location.href = base_url;
        }
        else
        {
          return false;
        }
        return;
      });
    }
    else
    {
      // Prompt Facebook Login
      FB.login(function(response)
      {
        if (response.authResponse) {
          $.post(base_url+"auth/facebook_login",).done(
            function (data)
            {
              var response = jQuery.parseJSON(data);
              if (response.success)
              {
                // Check is in the middle of form submitting
                if (mask_form_processing)
                {
                  return mask_form_submit();
                }
                return location.href = base_url;
                // return true;
              }
              else
              {
                return false;
              }
              return;
            }
          );
        }
        else {
          alert('User cancelled login or did not fully authorize.');
        }
      },{scope: 'public_profile,email,gender,picture'});
    }
  });
}

// General ALert
function beero_alert(title='Information',message='No message',type='success',delay='5000')
{
  var beero_alert_icon,beero_alert_color ;
  switch(type)
  {
    case 'success':
    beer_alert_type = 'success';
    beero_alert_icon = 'fas fa-check';
    break;
    case 'danger':
    beer_alert_type = 'error';
    beero_alert_icon = 'fas fa-ban';
    break;
    case 'warning':
    beer_alert_type = 'warning';
    beero_alert_icon = 'fas fa-exclamation';
    break;
    default:
    case 'info':
    beer_alert_type = 'info';
    beero_alert_icon = 'fas fa-info';
    // code block
  }
  // Notify JS
  $.notify({
    // options
    icon: beero_alert_icon+" pt-0 pr-3",
    title:title,
    message: message,
  },{
    // settings
    position: null,
    type: type,
    allow_dismiss: true,
    newest_on_top: false,
    showProgressbar: false,
    placement:
    {
      from: "top",
      align: "right"
    },
    offset:
    {
      x:0,
      y:70,
    },
    spacing:10,
    mouse_over:'pause',
    z_index: 10000,
    delay:delay,
    timer: 1000,
    animate: {
      enter: 'animated fadeInUp',
      exit: 'animated fadeOutUp'
    },
    template: '<div data-notify="container" class="bootstrap-notify col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
    '<div class="d-flex flex-row">'+
    '<div class="my-auto" >'+
    '<h3 data-notify="icon" style="min-width:0 !important;min-height:0 !important" ></h3> ' +
    '</div>'+
    '<div class="">'+
    '<h3 data-notify="title">{1}</h3> ' +
    '<p data-notify="message">{2}</p>' +
    '</div>'+
    '</div>'+
    '<div class="progress" data-notify="progressbar">' +
    '<div class="p-progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
    '</div>' +
    '</div>',
  });
}

function isJson(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }
  return true;
}

function animate_number(target='',min='0',max='0')
{
  $({ countNum:min }).animate({ countNum: max }, {
    duration: 2000,
    easing: 'linear',
    step: function () {
      $(target).html(numberWithCommas( Math.ceil(this.countNum)) );
    }
  });
}

function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
