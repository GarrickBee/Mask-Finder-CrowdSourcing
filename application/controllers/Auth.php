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
    $fb = new Facebook\Facebook([
      'app_id' => FACBEOOK_APP_ID,
      'app_secret' => FACBEOOK_APP_SECRET,
      'default_graph_version' => 'v2.2',
    ]);

    $helper = $fb->getJavaScriptHelper();

    try {
      $accessToken = $helper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    if (! isset($accessToken)) {
      echo 'No cookie set or no OAuth data could be obtained from cookie.';
      exit;
    }

    // Get User Profile
    try {
      // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me', $accessToken);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    $facebook_user = $response->getGraphUser();
    // CHECK USER
    // $user_data = array(
    //   'google_id'     => $facebook_user['id'],
    //   'first_name'    => $facebook_user['first_name'],
    //   'last_name'     => $facebook_user['last_name'],
    //   'profile_image' => $facebook_user['picture']['url'],
    //   'email'         => $facebook_user['email'],
    //   'full_name'     => $facebook_user['name'],
    // );
    $user = $response->getGraphUser();
    print_r($user);
  }


}

//Facebook\GraphNodes\GraphUser Object
// (
//     [items:protected] => Array
//         (
//             [id] => 3434530096563290
//             [first_name] => Garrick
//             [last_name] => Ng
//             [picture] => Facebook\GraphNodes\GraphPicture Object
//                 (
//                     [items:protected] => Array
//                         (
//                             [height] => 50
//                             [is_silhouette] =>
//                             [url] => https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=3434530096563290&height=50&width=50&ext=1587624304&hash=AeQnkmd7V2eQ9zar
//                             [width] => 50
//                         )
//
//                 )
//
//         )
//
// )
