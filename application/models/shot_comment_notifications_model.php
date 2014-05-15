<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Shots Comment Notifications Model
*
* Stores the comment notifications for every shot and every user
* subscribed to it
*
* @author Francesco Siddi
* @package Attract
*/
class Shot_comment_notifications_model extends CI_Model {

	public function __construct()
	{
		$this->load->library('ion_auth');
		$this->load->database();	
	}
	
	function get_shot_comment_notifications($shot_id = FALSE)
	{
		$user_id = $this->ion_auth->user()->row()->id;
		
		if ($shot_id == FALSE) 
		{
			$this->db->select('*');
			$this->db->join('shots', 'shots.shot_id = shot_comment_notifications.shot_id', 'left');
			$this->db->order_by('shot_comment_notification_id', 'desc'); 
			$this->db->where('user_id', $user_id); 
		    $this->db->from('shot_comment_notifications');
		    $query = $this->db->get();
			return $query->result_array();
		} 
		else
		{
			$this->db->select('*');
			$this->db->where('shot_id', $shot_id); 
			$this->db->where('user_id', $user_id); 
		    $this->db->from('shot_comment_notifications');
		    $query = $this->db->get();
			return $query->result_array();
		}	
	}
	
	function get_unread_shot_comment_notifications_count()
	{
		$user_id = $this->ion_auth->user()->row()->id;
		
		$this->db->select('*');
		$this->db->where('was_seen', FALSE); 
		$this->db->where('user_id', $user_id);
		$this->db->from('shot_comment_notifications'); 
		return $this->db->count_all_results();
	}
	

	function create_shot_comment_notification($shot_id, $comment_id, $user_id, $comment_description)
	{
		$data = array(
			'shot_id' => $shot_id,
			'user_id' => $user_id,
			'comment_id' => $comment_id,
			'shot_comment_description' => $comment_description,
			'was_seen' => FALSE
		);

		$this->db->insert('shot_comment_notifications', $data);
		return;
	}
	
	
	function mark_shot_comment_notifications_as_read($shot_id)
	{
		$user_id = $this->ion_auth->user()->row()->id;
		
		$data = array(
               'was_seen' => TRUE
            );

		$this->db->where('user_id', $user_id);
		$this->db->where('shot_id', $shot_id);
		$this->db->update('shot_comment_notifications', $data); 
	}


	function delete_shot_comment_notifications($shot_id)
	{
		$this->db->where('shot_id', $shot_id);		
		$this->db->delete('shot_comment_notifications');
		return;	
	}
	
}

/* End of file shot_comment_notifications_model.php */
/* Location: ./application/models/shot_comment_notifications_model.php */
