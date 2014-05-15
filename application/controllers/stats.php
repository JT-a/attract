<?php

class Stats extends Common_Auth_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('shots_tasks_model');
		$this->load->model('shots_model');
		$this->load->model('statuses_model');
	}


	function index()
	{
		// helper function to calculate percentage
		// at the moment we use it only here
		function percentage($val1, $val2, $precision = 1) 
		{
			if ($val1 == 0) {
				return 0;
			}
			$division = $val1 / $val2;
			$res = $division * 100;
			$res = round($res, $precision);	
			return $res;
		}
		
		// the idea for this set of functions is: we get the tasks definitions from the database,
		// build and array using them as indexes for other arrays containing specific information
		
		// we get the tasks
		$this->load->model('tasks_model');
		$tasks = $this->tasks_model->get_tasks();
		
		// echo "<br>";
		// print_r($tasks);
		// echo "<br>";
		
		// we get the statuses
		$this->load->model('statuses_model');
		$statuses = $this->statuses_model->get_statuses();
		
		// echo "<br>";
		// print_r($statuses);
		// echo "<br>";
		
		// we get the total duration of the show (to expose in UI and use for percent calculation)
		$total_show_duration = $this->shots_model->get_shots_sum_duration();
		$in_progress_show_duration = $this->shots_model->get_shots_sum_duration('in_progress');
		
		// echo "<br>";
		// print_r($total_show_duration);
		// echo "<br>";
		
		// initialize an auxiliary array to extract some indexes from $tasks and $statuses
		$tasks_names = array();
		$statuses_names = array();
		
		// this further auxiliary array is used later to bring back the actual task id into
		// the main tasks container (is used to reply jQuery POST requests from the frontend)
		$tasks_names_ids = array();
		
		// in particular we extract the task_name and build an array only with those values
		foreach ($tasks as $task)
		{
			array_push($tasks_names, $task['task_name']);
			$tasks_names_ids[$task['task_name']] = $task['task_id'];
		}
		
		foreach ($statuses as $status)
		{
			array_push($statuses_names, $status['status_name']);
		}
		
		// echo "<br>";
		// print_r($tasks_names);
		// echo "<br>";
		
				
		// we assign the values of $shot_statuses_names as keys for the main array that we create.
		// this array will contain all the info (shot count and total durations)
		$statuses_container = array_fill_keys(
			$statuses_names, 0
		);
		
		// we define a big array that will group tasks by task name
		$tasks_container = array_fill_keys(
			$tasks_names, 
			array('tasks_count' => 0, 'shots_duration_frames' => 0, 'statuses' => $statuses_container)
		);	
		
		// we append to all the task arrays the id (from the $task_names_id array defined earlier)
		foreach ($tasks_container as $task => $value)
		{
			$tasks_container[$task]['task_id'] = $tasks_names_ids[$task];
		}
		
		// echo "<br>";
		// print_r($tasks_container);
		// echo "<br>";
		
		
		// only now we actually need to retrieve the shots from the database, and we get only a few
		// info, such as the duration and the status. Then we use the value of the status fo the $shot
		// array as a key for the main array, in order to place the shot count and shot duration values
		// in the right array
		$shots_tasks = $this->shots_tasks_model->get_tasks();
		
		// echo "<br> TASKS: ";
		// print_r($shots_tasks);
		// echo "<br>";
		
		foreach ($shots_tasks as $task)
		{
			$tasks_container[$task['task_name']]['tasks_count']++;
			$tasks_container[$task['task_name']]['statuses'][$task['status_name']]++;
			//$tasks_container[$task]
			//$tasks_container[$task['task_name']]['shots_duration_frames'] += $task['shot_duration'];
			
			// here we fill the tasks array, only with shots that are in progress for the moment
			
			// if ($shot['shot_status_name'] == 'in_progress')
			// {
				// $tasks_container[$shot['shot_stage_name']]['shots_count']++;
				// $tasks_container[$shot['shot_stage_name']]['shots_duration_frames'] += $shot['shot_duration'];
			// }
		}
		
		// echo "<br> TASKS CONTAINER: ";
		// print_r($tasks_container);
		// echo "<br>";
		
		// from the actual task count we now generate percentages (this can be muted if we want to output
		// the original numbers in the interface)
		
		foreach ($tasks_container as $task_name => $value)
		{
			foreach ($value['statuses'] as $status_name => $status_count)
			{
				$status_count = percentage($status_count, $value['tasks_count']);
				$tasks_container[$task_name]['statuses'][$status_name] = $status_count;
			}
		}
		
		// echo "<br> TASKS CONTAINER: ";
		// print_r($tasks_container);
		// echo "<br>";
		
		
		//return;
		
		$data['tasks'] = $tasks_container;
		
		/*
		// we create the array to expose these values in the view
		$data['statuses'] = array();
		$data['stages'] = array();
		
		// we add to that array the actual percentages
		foreach ($statuses_container as $shots_group => $value) {
			$data['statuses'][$shots_group] = percentage($value['shots_duration_frames'], $total_show_duration );
		}
		
		foreach ($tasks_container as $shots_group => $value) {
			$data['shots_stages'][$shots_group] = percentage($value['shots_duration_frames'], $in_progress_show_duration );
		}
		*/
		
		$data['total_duration_frames'] = $total_show_duration;
		$data['total_duration_time'] = gmdate("i:s", ($total_show_duration/24));;
		$data['title'] = 'Stats';
		$data['statuses'] = $this->statuses_model->get_statuses();
		$data['use_sidebar'] = TRUE;
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('stats', $data);
		$this->load->view('templates/footer');
	}
	
}
