<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statuses extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('statuses_model');
	}

	function index()
	{
		$this->load->model('statuses_model');
		$data['statuses'] = $this->statuses_model->get_statuses();
		$data['title'] = 'Statuses';
		$data['use_sidebar'] = TRUE;
		
	
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('statuses/index', $data);
		$this->load->view('templates/footer');
	}
	
	function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->load->model('statuses_model');
		$data['title'] = 'Create status';
		$data['use_sidebar'] = TRUE;
		
		$this->form_validation->set_rules('status_name', 'text', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);	
			$this->load->view('statuses/create', $data);
			$this->load->view('templates/footer');
			
		}
		else
		{
			// we create the status and get its name to expose it the next flash
			$status_name = $this->statuses_model->create_status();

			$this->session->set_flashdata('message', 'Status <strong>' . $status_name . '</strong> added to database!');

			redirect('/statuses');
			
		}
	}
	
	function edit($status_id, $async = FALSE)
	{
		$this->load->model('statuses_model');
		
		$data['status'] = $this->statuses_model->get_statuses($status_id);	
		$data['title'] = 'Edit Status';
		$data['use_sidebar'] = TRUE;
		
		if (empty($data['status']))
		{
			show_404();
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		
		$this->form_validation->set_rules('status_name', 'text', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			if ($async)
			{
				$this->load->view('tasks/edit_ajax', $data);
			}
			else 
			{
				//$this->load->view('templates/header', $data);	
				//$this->load->view('templates/sidebar', $data);
				$this->load->view('statuses/edit_modal', $data);
				//$this->load->view('templates/footer');	
			}
		}
		else
		{
						
			// first we create the new tasks, which should be assigned to a user right after the page is reloaded
			$this->statuses_model->edit_status();
			
			$this->session->set_flashdata('message', 'Status <strong>' . $status_id . '</strong> has been updated!');
			redirect('/statuses/');
		}
	}

}

/* End of file statuses.php */
/* Location: ./application/controllers/statuses.php */

