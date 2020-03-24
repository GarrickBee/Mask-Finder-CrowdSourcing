<?php defined('BASEPATH') or die('Unauthorized Access');

class User_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db->reset_query();
	}

	public function create_user_session($user_data='',$login_method ='web')
	{
		$user_session = array(
			'user_id'       => $user_data['id'],
			'email'         => $user_data['email'],
			'date_login'    => date('Y M d H:s:i'),
			'first_name'    => $user_data['first_name'],
			'last_name'     => $user_data['last_name'],
			'full_name'     => $user_data['full_name'],
			'profile_image' => $user_data['profile_image'],
			'login_method'  => $login_method,
		);
		$this->session->set_userdata('maskfinder_user',$user_session);
		return true;
	}

	public function create_user ($data ='')
	{
		$this->db->insert('user',$data);
		return $this->db->insert_id();
	}

	public function update_user($data='')
	{
		$this->db->limit(1);
		$this->db->where('user_id',$data['user_id']);
		$this->db->update('user',$data);
		return true;
	}

	public function get_user_by_email($email='')
	{
		$this->db->where('email',$email);
		$query = $this->db->get('user');
		return $query->row_array();
	}

	public function insert_subscribe_email($email='')
	{
		// Check Email in the list
		$this->db->where('email',$email);
		$this->db->limit('1');
		$subscribe_email_query = $this->db->get('subscriber');
		if ($subscribe_email_query->num_rows() > 0 )
		{
			return array(
				'success'   => true,
				'title'     => "Email Existed",
				'message'     => "Your email is in our subscriber list.",
			);
		}
		// INSERT EMAIL
		$insert_subscriber_data = array(
			'email' => $this->input->post('email'),
			'ip'    => $this->input->ip_address(),
		);
		$this->db->insert('subscriber',$insert_subscriber_data);
		return array(
			'success' => true,
			'title'   => "Subscribe Success",
			'message' => "You have subscribe our email successfully.",
			'id'      => $this->db->insert_id(),
		);
	}

	public function update_subscribe_email($where='',$param='')
	{
		if (!empty($where))
		{
			$this->db->where($where);
		}
		$this->db->limit('1');
		$this->db->update('subscribe_email',$param);

	}
}// END CLASS
