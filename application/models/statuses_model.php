<?php
class Statuses_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function get_statuses($id = FALSE)
	{
		if ($id === FALSE)
		{
					
			$this->db->select('*'); 
		    $this->db->from('statuses');
		    $query = $this->db->get();
				
			//print_r ($query->result_array());

			return $query->result_array();
		}
		else 
		{
			$this->db->select('*');
			$this->db->where('status_id', $id); 
		    $this->db->from('statuses');
		    $query = $this->db->get();
			
			return $query->row_array();
		}
	}
	
	function create_status()
	{
		$data = array(
			'status_name' => $this->input->post('status_name')
		);

		$this->db->insert('statuses', $data);
		return $this->input->post('status_name');
	}

	function edit_status()
	{
		$status_id = $this->input->post('status_id');
		
		$data = array(
			'status_name' => $this->input->post('status_name'),
			'status_color' => $this->input->post('status_color')
		);
		
		$this->db->where('status_id', $status_id);
		$this->db->update('statuses', $data);
		return;
	}

}

