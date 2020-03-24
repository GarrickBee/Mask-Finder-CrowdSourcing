<?php defined('BASEPATH') or die('Unauthorized Access');

class Mask_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db->reset_query();
	}

	/**
	* Insert mask data to table
	* @param POST
	* @return array
	*/
	public function insert_mask_data($user_id="")
	{
		// Input Validation
		$validate_rules = array(
			array(
				'field' => 'data[shop]',
				'label' => 'Shop Name',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a %s.',
				),
			),
			array(
				'field' => 'data[item]',
				'label' => 'Item Type',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a %s.',
				),
			),
			array(
				'field' => 'data[price][number]',
				'label' => 'Price',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a %s.',
				),
			),
			array(
				'field' => 'data[price][currency]',
				'label' => 'Currency',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a %s.',
				),
			),
			array(
				'field' => 'data[stock]',
				'label' => 'Stock',
				'rules' => 'required',
				'errors' => array(
					'required' => 'You must provide a %s.',
				),
			),
			array(
				'field' => 'data[latitude]',
				'label' => 'Latitude',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Invalid location input (%s)',
				),
			),
			array(
				'field' => 'data[longitude]',
				'label' => 'Longitude',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Invalid location input (%s)',
				),
			),
			array(
				'field' => 'data[location]',
				'label' => 'Location',
				'rules' => 'required',
				'errors' => array(
					'required' => 'Invalid location input (%s)',
				),
			),
		);
		$this->form_validation->set_rules($validate_rules);
		if (!$this->form_validation->run())
		{
			return array(
				'success' => false,
				'title' => "Error Submission",
				'message' => $this->form_validation->error_array(),
			);
		}

		// Insert Data
		$insert_mask_data = array(
			'user_id'   => $user_id,
			'shop'      => $this->input->post('data[shop]'),
			'item'      => $this->input->post('data[item]'),
			'currency'  => $this->input->post('data[price][currency]'),
			'price'     => $this->input->post('data[price][number]'),
			'stock'     => $this->input->post('data[stock]'),
			'remark'    => $this->input->post('data[remark]'),
			'location'  => $this->input->post('data[location]'),
			'longitude' => $this->input->post('data[longitude]'),
			'latitude'  => $this->input->post('data[latitude]'),
			'ip'        => $this->input->ip_address(),
		);

		$this->db->insert('mask',$insert_mask_data);
		// Success Return
		return array(
			'success'   => true,
			'title'     => "Data Insert Success",
			'message'   => "Mask data inserted successfully",
			'insert_id' => $this->db->insert_id(),
		);
	}

	public function get_mask_data()
	{
		$query = $this->db->get('mask');

		return $query->result_array();
	}
}
