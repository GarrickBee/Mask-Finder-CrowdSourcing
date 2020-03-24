<?php defined('BASEPATH') OR exit('No direct script access allowed');
class About extends CI_Controller
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
  public function privacy()
  {
    $page = $this->load->view('pages/privacy',$this->view_data,TRUE);
    BEERO::load_page($page,$this->head_custom,$this->script_custom);
  }
  
  public function terms()
  {
    $page = $this->load->view('pages/terms',$this->view_data,TRUE);
    BEERO::load_page($page,$this->head_custom,$this->script_custom);
  }
}
