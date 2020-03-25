<?php defined('BASEPATH') OR exit('No direct script access allowed');
// header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

class Auth extends CI_Controller
{
  public $view_data = array();
  public $head_data = array();
  public $return = array();
  /// Constructor
  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    return false;
  }

  public function google_login()
  {
    // Loading Dependencies
    $user_model = BEERO::load_model('user');
    $this->form_validation->set_rules('google_token','Google Token','required');
    if (!$this->form_validation->run())
    {
      $this->return = array(
        'success' => false,
        'title' => "Google Token Missing",
        'message' => "Sign In with Google Attempt Failed. Kindly re-login again or contact admin.",
      );
      exit(json_encode($this->return));
    }

    $id_token = $this->input->post("google_token");
    $client = new Google_Client(['client_id' => GOOGLE_SIGNIN_CLIENT_ID ]);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($id_token);
    if (!$payload)
    {
      $this->return = array(
        'success' => false,
        'title' => "Google Verification Failed",
        'message' => "Sign In with Google Attempt Failed. Kindly re-login again or contact admin.",
      );
      exit (json_encode($this->return));
    }

    // Merge Data with User Table Key
    $user_data = array(
      'google_id'     => $payload['sub'],
      'first_name'    => $payload['given_name'],
      'last_name'     => $payload['family_name'],
      'profile_image' => $payload['picture'],
      'email'         => $payload['email'],
      'full_name'     => $payload['name'],
    );
    // Check User Exist
    $maskfinder_user = $user_model->get_user_by_email($payload['email']);
    if (!empty($maskfinder_user))
    {
      // Check Google ID
      if ($maskfinder_user['google_id'] !== $user_data['google_id'])
      {
        $update_user_data = array();
        // Update User
        foreach ($maskfinder_user as $maskfinder_user_key => $maskfinder_user_value)
        {
          if (empty($value))
          {
            $update_user_data[$maskfinder_user_key] = empty($user_data[$key])?'':$user_data[$key];
            $maskfinder_user[$maskfinder_user_key]  = $update_user_data[$maskfinder_user_key];
          }
        }
        $user_model->update_user($update_user_data);
      }
    }
    else
    {
      // Create User
      $user_id = $user_model->create_user($user_data);
      if (!$user_id)
      {
        $this->return = array(
          'success' => false,
          'title' => "User Sign Up Failed",
          'message' => "User Sign Up Failed.",
        );
        exit (json_encode($this->return));
      }
      $maskfinder_user            = $user_data;
      $maskfinder_user['id'] = $user_id;
    }

    // Create Login Session
    $user_model->create_user_session($maskfinder_user,'google');
    // Success Return
    $this->return = array(
      'success' => true,
      'title' => "User Login Successfully",
      'message' => "You have just login with your google account.",
    );
    exit (json_encode($this->return));
  }

  public function check_user_login()
  {
    if (!check_user_login())
    {
      // Success Return
      $this->return = array(
        'success' => false,
        'title'   => "User are not login.",
      );
    }
    else
    {
      $this->return = array(
        'success' => true,
        'title'   => "User Logined ",
      );
    }
    exit (json_encode($this->return));
  }

  public function facebook_login()
  {
    $user_model = BEERO::load_model('user');
    $access_token = $this->input->post('facebook_token');

    $fb = new Facebook\Facebook([
      'app_id' => FACBEOOK_APP_ID,
      'app_secret' => FACBEOOK_APP_SECRET,
      'default_graph_version' => 'v3.2',
    ]);

    if (empty($access_token))
    {
      $helper = $fb->getJavaScriptHelper();
      try {
        $access_token = $helper->getAccessToken();
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }
      if (! isset($access_token)) {
        echo 'No cookie set or no OAuth data could be obtained from cookie.';
        exit;
      }
    }
    // Get User Profile
    try {
      // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,first_name,last_name,email,link,gender,picture', $access_token);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    $facebook_user = $response->getGraphUser();
    $first_name    = !empty($facebook_user['first_name'])?$facebook_user['first_name']:'';
    $last_name     = !empty($facebook_user['last_name'])?$facebook_user['last_name']:'';
    // Merge Data with User Table Key
    $user_data = array(
      'facebook_id'   => !empty($facebook_user['id'])?$facebook_user['id']:'',
      'first_name'    => $first_name,
      'last_name'     => $last_name ,
      'profile_image' => !empty($facebook_user['picture']['url'])?$facebook_user['picture']['url']:'',
      'email'         => !empty($facebook_user->getProperty("email"))?$facebook_user->getProperty("email"):'',
      'full_name'     => $first_name." ".$last_name,
    );

    // Check User Exist
    $maskfinder_user = $user_model->get_user_by_email($user_data['email']);
    if (!empty($maskfinder_user))
    {
      // Check Google ID
      if ($maskfinder_user['facebook_id'] !== $user_data['facebook_id'])
      {
        $update_user_data = array();
        // Update User
        foreach ($maskfinder_user as $maskfinder_user_key => $maskfinder_user_value)
        {
          if (empty($value))
          {
            $update_user_data[$maskfinder_user_key] = empty($user_data[$key])?'':$user_data[$key];
            $maskfinder_user[$maskfinder_user_key]  = $update_user_data[$maskfinder_user_key];
          }
        }
        $user_model->update_user($update_user_data);
      }
    }
    else
    {
      // Create User
      $user_id = $user_model->create_user($user_data);
      if (!$user_id)
      {
        $this->return = array(
          'success' => false,
          'title' => "User Sign Up Failed",
          'message' => "User Sign Up Failed.",
        );
        exit (json_encode($this->return));
      }
      $maskfinder_user       = $user_data;
      $maskfinder_user['id'] = $user_id;
    }
    // Create Login Session
    $user_model->create_user_session($maskfinder_user,'facebook');
    // Success Return
    $this->return = array(
      'success' => true,
      'title'   => "User Login Successfully",
      'message' => "You have just login with your facebook account.",
    );
    exit (json_encode($this->return));
  }
}
