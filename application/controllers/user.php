<?php

class User extends Common_Auth_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		
		$this->load->database();
		$this->load->model('users_model');
		$this->load->model('shot_comment_notifications_model');
	}
	

	function index()
	{
		$data['users'] = $this->users_model->get_users();
		$data['title'] = 'Shot';
		$data['use_sidebar'] = TRUE;
		
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('admin/users', $data);
		$this->load->view('templates/footer');
	}
	
	function activity()
	{
		
		$data['title'] = 'Activity';
		$data['use_sidebar'] = TRUE;
		$data['comment_notifications'] = $this->shot_comment_notifications_model->get_shot_comment_notifications();
	
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar_user', $data);
		$this->load->view('user/activity', $data);
		$this->load->view('templates/footer');
	}

	function tasks()
	{
		$this->load->model('tasks_model');
		$this->load->model('shot_tasks_users_model');
		
		$user = $this->ion_auth->user()->row();

		$data['shots'] = $this->shot_tasks_users_model->get_shots($user->id);
		$data['title'] = 'My tasks';
		$data['use_sidebar'] = TRUE;
		
	
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar_user', $data);
		$this->load->view('user/tasks', $data);
		$this->load->view('templates/footer');
	}
	
	function profile()
	{
		$data['title'] = 'Edit Profile';
		$data['use_sidebar'] = TRUE;


		$user = $this->ion_auth->user()->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups()->result();


		//validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required|xss_clean');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required|xss_clean');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?


			$data = array(
				'first_name'=> $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'company'   => $this->input->post('company'),
				'email'		=> $this->input->post('email')
			);


			//update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

				$data['password'] = $this->input->post('password');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$this->ion_auth->update($user->id, $data);

				//check to see if we are creating the user
				//redirect them back to the admin page
				$this->session->set_flashdata('message', "User Saved");
				//redirect("auth", 'refresh');
				redirect('user/profile/');
			}
		}

		$data['groups'] = $groups;
		
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		$data['user'] = array(
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'email' => $user->email,
			'company' => $user->company
		);
		
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar_user', $data);
		$this->load->view('user/profile', $data);
		$this->load->view('templates/footer');
	}

	function password()
	{
		$data['title'] = 'Password';
		$data['use_sidebar'] = TRUE;


		$user = $this->ion_auth->user()->row();


		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?


			$data = array();


			//update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');

				$data['password'] = $this->input->post('password');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$this->ion_auth->update($user->id, $data);

				//check to see if we are creating the user
				//redirect them back to the admin page
				$this->session->set_flashdata('message', "Password updated");
				//redirect("auth", 'refresh');
				redirect('user/profile/');
			}
		}

		
		$data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar_user', $data);
		$this->load->view('user/password', $data);
		$this->load->view('templates/footer');
	}
	
}
