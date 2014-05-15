<?php
class Shot_tasks_users_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	function get_shots($user_id)
	{
					
		$this->db->select('shots.shot_name, shots.shot_id, shots.shot_description, tasks.task_name'); 
		//$this->db->select('GROUP_CONCAT(DISTINCT shot_tasks_users.user_id SEPARATOR ",") as user_id', FALSE); 
	    $this->db->from('shot_tasks_users');
		$this->db->join('shots_tasks', 'shots_tasks.shot_task_id = shot_tasks_users.shot_task_id', 'left');
		$this->db->join('tasks', 'tasks.task_id = shots_tasks.task_id', 'left');
		$this->db->join('shots', 'shots.shot_id = shots_tasks.shot_id', 'left');
		$this->db->join('users', 'users.id = shot_tasks_users.user_id', 'left');
		//$this->db->group_by('shots.shot_id'); 
		$this->db->where('shot_tasks_users.user_id', $user_id); 
	    $query = $this->db->get();
		
		//print_r($query->result_array());
		return $query->result_array();
	}

	
	function get_users($shot_id)
	{
					
		$this->db->select('shots_tasks.shot_task_id, shot_tasks_users.user_id, users.first_name, users.last_name'); 
	    $this->db->from('shots_tasks');
		$this->db->join('shot_tasks_users', 'shot_tasks_users.shot_task_id = shots_tasks.shot_task_id', 'left');
		$this->db->join('users', 'users.id = shot_tasks_users.user_id', 'left');
		$this->db->where('shots_tasks.shot_id', $shot_id); 
	    $query = $this->db->get();

		return $query->result_array();
	}
	
	function set_user($shot_task_id, $user_id)
	{	
		$data = array(
			'user_id' => $user_id,
			'shot_task_id' => $shot_task_id
		);

		$shot_exists = $this->db->get_where('shot_tasks_users', $data);
		$shot_exists = $shot_exists->row();
		
		if (empty($shot_exists)) {
			return $this->db->insert('shot_tasks_users', $data);
		}
		
		//$this->db->where('shot_id', $shot_id);
		//return $this->db->update('shots_users', $data);
		return;
	}
	
	function remove_users($shot_task_id, $user_id = FALSE)
	{
		if ($user_id)
		{
			$data = array(
				'user_id' => $user_id,
				'shot_task_id' => $shot_task_id
			);
		}
		else 
		{
			$data = array(
				'shot_task_id' => $shot_task_id
			);	
		}
		
		$shot_exists = $this->db->get_where('shot_tasks_users', $data);
		$shot_exists->row();
		
		if ($shot_exists) {
			return $this->db->delete('shot_tasks_users', $data);
		}
	}

	function remove_shot_task($shot_task_id) 
	{
		$data = array(
			'shot_task_id' => $shot_task_id
		);

		return $this->db->delete('shots_tasks', $data);
	}
	
	function set_users($shot_id)
	{
		
		$this->db->select('shots_tasks.shot_task_id'); 
	    $this->db->from('shots_tasks');
		$this->db->where('shot_id', $shot_id);
		$query = $this->db->get();
		
		$old_shot_tasks_id = $query->result_array();	
		
		
		$old_shot_tasks_id_clean = array();
		foreach ($old_shot_tasks_id as $item) {
			array_push($old_shot_tasks_id_clean, $item['shot_task_id']);
		}
		
		// echo "old id ";
		// print_r($old_shot_tasks_id_clean);
		// echo "<br>";
		
		
		// we collect a user set for each task (using a multidimensional array)
		$all_new_users_id = $this->input->post('task_owners');
		
		// if we don't provide users at all, it means that we want to get rid of
		// the task and the users connected to it
		
		if (empty($all_new_users_id))
		{
			$all_new_users_id = array();
		}
				
		$all_new_users_id_clean = array_keys($all_new_users_id);
		
		
		// echo "new shot_task id ";
		// print_r($all_new_users_id_clean);
		// echo "<br>";
		
		$removed_shot_tasks_id = array();	
		foreach ($old_shot_tasks_id_clean as $value) 
		{
			if (!in_array($value, $all_new_users_id_clean)) {
				array_push($removed_shot_tasks_id, $value);
			}
		}
		
		
		// echo "removed shot_task id ";
		// print_r($removed_shot_tasks_id);
		// echo "<br>";
		
		
		foreach ($removed_shot_tasks_id as $value) 
		{
			$this->remove_shot_task($value);
			$this->remove_users($value);
		}	
			
		foreach($all_new_users_id as $shot_task_id => $new_users_id)
		{
			if ($new_users_id == '')
			{
				$new_users_id = array();
			}
			
			$this->db->select('shot_tasks_users.user_id'); 
		    $this->db->from('shot_tasks_users');
			$this->db->where('shot_task_id', $shot_task_id);
			$query = $this->db->get();
			
			$old_users_id = $query->result_array();
			$old_users_id_clean = array();
			
			
			// print_r($shot_task_id);
			// echo " - ";
			// print_r($old_users_id);
			// echo "<br>";
			
			
			// we make a list of the old user ids (by pusing them in a temp array)
			foreach ($old_users_id as $entry)
			{
				array_push($old_users_id_clean, $entry['user_id']);			
			}
	
			$old_users_id = $old_users_id_clean;

			// we check which users id are actually new by comparing them with the current one
			$new_users_id_diff = array_diff($new_users_id, $old_users_id);
			
			
			// we assign those new users to the list
			foreach ($new_users_id_diff as $user_id) 
			{
				$this->set_user($shot_task_id, $user_id);
			}
			//print_r ($new_users_id);
			$removed_users_id = array();
			
			foreach ($old_users_id as $user_id) 
			{
				if (!in_array($user_id, $new_users_id)) {
					array_push($removed_users_id, $user_id);
				}
			}

			foreach ($removed_users_id as $user) 
			{
				$this->remove_users($shot_task_id, $user);
			}
			
		}
		return;
		
	}
	
	function delete_shot_task_user($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('shot_tasks_users');
		return;
	}

}

