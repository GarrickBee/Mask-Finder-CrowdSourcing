<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Empty extends CI_Controller
{
  public $view_data     = array();
  public $head_custom     = array();
  public $script_custom = array();
  public $return        = array();
  /// Constructor
  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    return;
  }
}
