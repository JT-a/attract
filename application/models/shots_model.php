<?php
class Shots_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function get_shots($id = FALSE)
	{
		$this->load->model('settings_model');
		$current_show = $this->settings_model->get_settings('current_show');
			
		if ($id === FALSE)
		{
					
			$this->db->select('shots.shot_id, shots.shot_name, shots.shot_description, shots.shot_duration'); 
			$this->db->select('statuses.status_name, statuses.status_color, shots.shot_notes, attachments.attachment_path'); 
			$this->db->select('GROUP_CONCAT(DISTINCT shots_users.user_id SEPARATOR ",") as user_id', FALSE); 
			$this->db->select('GROUP_CONCAT(tasks.task_name SEPARATOR ",") as task_names', FALSE);
		    $this->db->from('shots');
		   	$this->db->join('shots_users', 'shots_users.shot_id = shots.shot_id', 'left');
			$this->db->join('statuses', 'statuses.status_id = shots.status_id', 'left');
			$this->db->join('shots_tasks', 'shots_tasks.shot_id = shots.shot_id', 'left');
			$this->db->join('tasks', 'tasks.task_id = shots_tasks.task_id', 'left');
			$this->db->join('scenes', 'scenes.scene_id = shots.scene_id', 'left');
			$this->db->join('sequences', 'sequences.sequence_id = scenes.sequence_id', 'left');
			$this->db->join('shots_attachments', 'shots_attachments.shot_id = shots.shot_id', 'left');
			$this->db->join('attachments', 'attachments.attachment_id = shots_attachments.attachment_id', 'left');
			$this->db->group_by('shots.shot_id'); 
			$this->db->order_by('shots.shot_order', 'asc');
			$this->db->where('show_id', $current_show['setting_value']); 
		    $query = $this->db->get(); 
				
			//print_r ($query->result_array());

			return $query->result_array();
		}
		
		// TODO: look into this http://stackoverflow.com/questions/13753739/mysql-query-group-concat-over-multiple-rows
		$this->db->select('*'); 
	    $this->db->from('shots');
		$this->db->join('scenes', 'scenes.scene_id = shots.scene_id', 'left');		
		$this->db->join('statuses', 'statuses.status_id = shots.status_id', 'left');
		$this->db->where('shots.shot_id', $id); 
		$query = $this->db->get();
		
		//print_r($query->row_array());
		return $query->row_array();
		
		
	}

	function set_shots($id = FALSE)
	{
		if ($id === FALSE) 
		{
			$data = array(
				'shot_name' => $this->input->post('shot_name'),
				'shot_description' =>  $this->input->post('shot_description'),
				'scene_id' => $this->input->post('scene_id'),
				'shot_duration' => $this->input->post('shot_duration'),
				'status_id' => $this->input->post('shot_status_id'),
				'shot_order' => $this->input->post('shot_order')
			);
			
			$this->db->insert('shots', $data);
			
			$ownership_data = array(
				'shot_id' => $this->db->insert_id(),
				'shot_name' => $this->input->post('shot_name')
			);
			
			return $ownership_data;
		} 
		else 
		{
			$shot_id = $this->input->post('shot_id');
			$data = array(
				'scene_id' => $this->input->post('scene_id'),
				'shot_name' => $this->input->post('shot_name'),
				'shot_description' =>  $this->input->post('shot_description'),
				'status_id' => $this->input->post('shot_status_id'),
				'shot_notes' =>  $this->input->post('shot_notes'),
				'shot_duration' => $this->input->post('shot_duration')
			);
			$this->db->where('shot_id', $shot_id);
			return $this->db->update('shots', $data);
		}
	}

	function set_shot_property($shot_id, $property, $value)
	{	
		$data = array(
			$property => $value
		);
		$this->db->where('shot_id', $shot_id);
		return $this->db->update('shots', $data);
	}


	function get_shots_order()
	{
		$this->db->select('shots.shot_name, shots.shot_order'); 
	    $this->db->from('shots');
		$query = $this->db->get();
		
		//print_r($query->row_array());
		return $query->row_array();

	}
	
	function set_shot_order($shot_id)
	{
		$this->db->select('shots.shot_name, shots.shot_order'); 
	    $this->db->from('shots');
		$query = $this->db->get();
		
		//print_r($query->row_array());
		return $query->row_array();

	}
	
	function get_last_shot_position()
	{
		$this->db->select_max('shots.shot_order');
		$query = $this->db->get('shots');
				
		//print_r($query->row_array());
		return $query->row_array();
	}
	
	function delete_shot($shot_id)
	{
		
		$this->load->model('shots_tasks_model');
		
		$this->db->select('*'); 
		$this->db->where('shot_id', $shot_id);
	    $this->db->from('shots_tasks');
	    $query = $this->db->get();	
		$shots_tasks = $query->result_array();
		
		if (isset($shots_tasks))
		{
			foreach ($shots_tasks as $shot_task) 
			{
				$this->shots_tasks_model->delete_shot_task($shot_task['shot_task_id']);
			}
		}

		$tables = array('shots', 'shots_users');
		$this->db->where('shot_id', $shot_id);
		$this->db->delete($tables);
		return;
	}
	
	function get_shots_sum_duration($status = FALSE)
	{
		if ($status == FALSE)
		{
			$this->db->select_sum('shot_duration');
			$query = $this->db->get('shots');
			$result = $query->row_array();
			return $result['shot_duration'];
		}
		else if ($status)
		{
			$this->db->select_sum('shot_duration');
			$this->db->from('shots');
			$this->db->join('statuses', 'statuses.status_id = shots.status_id', 'left');
			$this->db->where('status_name', $status);
			$query = $this->db->get();
			$result = $query->row_array();
			return $result['shot_duration'];
		}
		
	}
	
	function get_statuses_and_stages()
	{
		$this->db->select('shots.shot_id, shots.shot_name, shots.shot_duration'); 
		$this->db->select('statuses.status_name, tasks.task_name'); 
	    $this->db->from('shots');
		$this->db->join('statuses', 'statuses.status_id = shots.status_id', 'left');
		$this->db->join('tasks', 'tasks.task_id = shots.stage_id', 'left');
		//$this->db->group_by('shots.shot_id'); 
		//$this->db->order_by('shots.shot_order', 'asc');
	    $query = $this->db->get(); 
		return $query->result_array();
	}
	
	function delete_preview($attachment_id)
	{
		$this->load->model('attachments_model');
		$this->attachments_model->delete_attachment($attachment_id);
		
		$this->db->where('attachment_id', $attachment_id);
		$this->db->delete('shots_attachments');
		
	}

}

