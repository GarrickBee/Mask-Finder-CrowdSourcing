<?php defined('BASEPATH') OR exit('No direct script access allowed');
// header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

class  User extends CI_Controller
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

  public function logout()
  {
    // Check Google or Facebook
    // General Session Destroy
    // GOOLGE LOGOUT
    $this->session->sess_destroy();
    return redirect('dashboard');
  }
}
