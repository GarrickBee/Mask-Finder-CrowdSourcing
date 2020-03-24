<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
  public $view_data = array();
  public $head_data = array();
  /// Constructor
  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->dashboard();
  }

  public function dashboard()
  {
    $page = $this->load->view('pages/dashboard',$this->view_data,TRUE);
    BEERO::load_page($page,$this->head_data);
  }

  public function _delete_dashboard ()
  {
    $dashboard_survey_query = $this->db->query
    (
      "SELECT `survey_id`,`survey_title`,`survey_headline`,`survey_backgroundimage`,`survey_lastupdate`,`survey_online`
      FROM survey
      WHERE `user_id`= {$this->db->escape($_SESSION['user_id'])} AND `hide`='0'
      "
    );

    $data['survey']                           = $dashboard_survey_query->result_array();
    $survey_id_array                          = array_column($data['survey'],'survey_id');
    if (empty($survey_id_array))
    {
      $data['analysis']['total_respondent']     = '0';
      $data['analysis']['total_survey_online']  = '0';
      $data['analysis']['total_survey_offline'] = '0';
    }
    else
    {
      $this->db->select('respondent_id');
      $this->db->where_in('survey_id',$survey_id_array);
      $data['analysis']['total_respondent']     = $this->db->get('respondent_survey')->num_rows();
      $data['analysis']['total_survey_online']  = array_count_values(array_column($data['survey'],'survey_online'))['online'];
      $data['analysis']['total_survey_offline'] = array_count_values(array_column($data['survey'],'survey_online'))['offline'];
    }
    $data['analysis']['total_survey']         = $dashboard_survey_query->num_rows();
    $page                                     = $this->load->view( 'templates/layout/dashboard',$data,true);
    BEERO::loadPage($page);
  }
}
