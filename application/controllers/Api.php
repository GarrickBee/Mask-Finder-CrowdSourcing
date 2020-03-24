<?php defined('BASEPATH') OR exit('No direct script access allowed');
// header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

class  Api extends CI_Controller
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

  public function subscribe_email()
  {
    $user_model = BEERO::load_model('user');
    // Validate Input
    $validate_rules = array(
      array(
        'field' => 'email',
        'label' => 'Email',
        'rules' => 'required|valid_email',
        'errors' => array(
          'required'    => 'You must provide a %s',
          'valid_email' => 'Your email is not Valid',
        )
      )
    );
    $this->form_validation->set_rules($validate_rules);
    if (!$this->form_validation->run())
    {
      $this->return = array(
        'success'   => false,
        'title'     => "Subscribe Email Error",
        'message'   => implode($this->form_validation->error_array(),"."),
      );
      exit(json_encode($this->return));
    }
    // Register Email
    $this->result = $user_model->insert_subscribe_email( $this->input->post('email') );
    exit(json_encode($this->result));
  }

  public function mask_submit()
  {
    // Model
    $mask_model = BEERO::load_model('mask');
    $mask_insert = $mask_model->insert_mask_data();
    return print(json_encode($mask_insert));
  }

  public function get_mask_data()
  {
    $mask_model = $this->load->model('mask_model');
    $mask_model = $this->mask_model;
    $mask_data  = $mask_model->get_mask_data();

    $this->return['success'] = true;
    $this->return['data'] = $mask_data;
    return print(json_encode($this->return));
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
    $client = new Google_Client(['client_id' => GOOGLE_CLIENT_ID ]);  // Specify the CLIENT_ID of the app that accesses the backend
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
      'full_name'          => $payload['name'],
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
}
