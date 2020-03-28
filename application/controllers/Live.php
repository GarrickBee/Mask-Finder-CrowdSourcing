<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Live extends CI_Controller
{
  public $view_data     = array();
  public $head_custom   = array();
  public $script_custom = array();
  public $return        = array();
  /// Constructor
  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    return $this->dashboard();
  }

  public function dashboard()
  {

    $this->script_custom[] = base_url("assets/plugin/selectize/dist/js/standalone/selectize.min.js");
    $this->script_custom[] = base_url("assets/js/custom/live_dashboard.js");

    $page = $this->load->view('pages/live/dashboard.php',$this->view_data,TRUE);
    BEERO::load_page($page,$this->head_custom,$this->script_custom);
  }

}
