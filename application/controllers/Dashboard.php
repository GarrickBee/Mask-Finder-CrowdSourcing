<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller
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
    $this->home();
  }

  public function home()
  {
    $this->script_custom = array(
      base_url("assets/js/custom/mask_dashboard.js")
    );
    $page = $this->load->view('pages/dashboard',$this->view_data,TRUE);
    BEERO::load_page($page,$this->head_custom,$this->script_custom);
  }

  public function subscribe_email()
  {
    // DEFINE VARIABLE
    $user_model = BEERO::load_model('user');
    $subscribe = $user_model->insert_subscribe_email();
    BEERO::prepare_message($subscribe['title'],$subscribe['message'],'info');
    return redirect("dashboard");
  }

}
