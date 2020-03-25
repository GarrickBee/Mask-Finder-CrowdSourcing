<?php defined('BASEPATH') or die('Unauthorized Access');

/**
* Act as a customise backbone
* @author 			: Garrick NG < github.com/GarrickBee >
*/
class BEERO
{
  public static $CI;

  function __construct()
  {
    self::$CI  =& get_instance();
  }

  /**
  * Maind Website Loading Page
  * @param  string $content       Content View
  * @param  string $head_custom   default/head
  * @param  string[] $script_custom Custom Script Link
  * @return string               Generate Page
  */
  public static function load_page($content='',$head_custom='',$script_custom='')
  {
    $main_view_data = array(
      'head'    => self::$CI->load->view('default/head',$head_custom,TRUE),
      'header'  => self::$CI->load->view('default/header','',TRUE),
      'content' => $content,
      'footer'  => self::$CI->load->view('default/footer','',TRUE),
      'script'  => self::$CI->load->view('default/script',array('script_custom'=>$script_custom),TRUE),
    );
    // GENERATE PAGES
    $main_html  = self::$CI->load->view('main',$main_view_data);
    // RETURN AND GENERATE PAGE
    return $main_html;
  }
  
  // SYSTEM MESSAGE FUNCTION
  // PREPARE MESSAGE
  public static function prepare_message($system_alert_title='',$system_alert_message='',$system_alert_state='',$system_alert_delay='')
  {
    $flash_data = array
    (
      'system_alert_title'   => $system_alert_title,
      'system_alert_message' => $system_alert_message,
      'system_alert_state'   => $system_alert_state,
      'system_alert_delay'   => $system_alert_delay,
    );
    $flash_message   = self::$CI->session->flashdata('system_alert');
    $flash_message[] = $flash_data;
    self::$CI->session->set_flashdata('system_alert',$flash_message);
    return $flash_data;
  }

  // SWEET ALERT MESSAGE
  public static function system_sweet_alert($sweet_message= array())
  {
    self::$CI->session->set_flashdata('system_sweet_alert',$sweet_message);
  }

  // UPLOAD FILE
  public static function upload_file($upload_file='',$upload_path='',$upload_rename='',$upload_size='',$upload_minwidth='',$uplaod_minheight='')
  {
    // CONFIG
    $config['upload_path']      = XINNORA_IMAGE_PATH.$upload_path;
    $config['file_ext_tolower'] = TRUE;
    // $config['upload_path']   = '/xampp/htdocs/xinnora/assets/img/storage/';
    $config['allowed_types']    = XINNORA_IMAGE_TYPE;
    $config['max_size']         = $upload_size;
    $config['min_width']        = $upload_minwidth;
    $config['min_height']       = $uplaod_minheight;
    $config['file_name']        = $upload_rename;
    // Initialize
    self::$CI->load->library('upload', $config);
    self::$CI->upload->initialize($config);
    self::$CI->upload->do_upload($upload_file);

    $data['file_name']  = self::$CI->upload->data('file_name');
    $data['file_error'] = self::$CI->upload->display_errors('<p>','<p>');
    return $data;
  }

  public static function load_model( $name = '' )
  {
    $name = $name . '_model';
    self::$CI->load->model( $name );
    return new $name;
  }

  /**
  * For Debugging use - Print String or Array in a more nicer way replacing print_r
  */
  public static function print_array($array='')
  {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    exit();
  }


}
