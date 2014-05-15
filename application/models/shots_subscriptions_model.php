<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Shots Subscriptions Model
*
* Manages the relation between between shots and the users who want to be
* notified about any changes (comments or edits)
*
* @author Francesco Siddi
* @package Attract
*/
class Shots_subscriptions_model extends CI_Model {

	public function __construct()
	{
		$this->load->library('ion_auth');
		$this->load->database();	
	}
	
	function get_shots_subscriptions($user_id = FALSE)
	{
		if ($id === FALSE)
		{				
			$this->db->select('*'); 
		    $this->db->from('statuses');
		    $query = $this->db->get();
			return $query->result_array();
		}
		else 
		{
			$this->db->select('*');
			$this->db->where('user_id', $user_id); 
		    $this->db->from('shots_subscriptions');
		    $query = $this->db->get();	
			return $query->row_array();
		}
	}
	
	function get_shot_subscriptions($shot_id)
	{
		$user_id = $this->ion_auth->user()->row()->id;
		
		$this->db->select('*');
		$this->db->where('user_id', $user_id); 
		$this->db->where('shot_id', $shot_id); 
	    $this->db->from('shots_subscriptions');
	    $query = $this->db->get();	
		return $query->result_array();
	}
	
	function get_users_subscribed_to_comments($shot_id)
	{
		$this->db->select('shots_subscriptions.user_id');
		$this->db->where('shot_id', $shot_id); 
		$this->db->where('subscription_type', 'comments'); 
	    $this->db->from('shots_subscriptions');
	    $query = $this->db->get();	
		return $query->result_array();
	}
	
	function create_shot_subscription()
	{
		$data = array(
			'shot_id' => $this->input->post('shot_id'),
			'user_id' => $this->ion_auth->user()->row()->id,
			'subscription_type' => $this->input->post('subscription_type')
		);
		$this->db->insert('shots_subscriptions', $data);
		return;
	}

	function delete_shot_subscription()
	{
		$user_id = $this->ion_auth->user()->row()->id;
		
		$this->db->where('shot_id', $this->input->post('shot_id'));
		$this->db->where('user_id', $user_id);
		$this->db->where('subscription_type', $this->input->post('subscription_type'));		
		$this->db->delete('shots_subscriptions');
		return;	
	}

}

/* End of file shot_subscriptions_model.php */
/* Location: ./application/models/shot_subscriptions_model.php */
