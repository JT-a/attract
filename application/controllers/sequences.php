<?php

class Sequences extends Common_Auth_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sequences_model');
	}

	function index()
	{
		$data['sequences'] = $this->sequences_model->get_sequences();
		$data['title'] = 'Sequences';
		$data['use_sidebar'] = TRUE;
		
	
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('sequences/index', $data);
		$this->load->view('templates/footer');
	}
	
	function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$data['title'] = 'Create sequence';
		$data['use_sidebar'] = TRUE;
		
		$this->form_validation->set_rules('sequence_name', 'text', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('templates/header', $data);	
			$this->load->view('sequences/create', $data);
			$this->load->view('templates/footer');
			
		}
		else
		{
			// we create the sequence and get its name to expose it the next flash
			$sequence_name = $this->sequences_model->create_sequence();

			$this->session->set_flashdata('message', 'Sequence <strong>' . $sequence_name . '</strong> added to database!');

			redirect('/sequences/');
			
		}
	}
	
	function edit($sequence_id, $async = FALSE)
	{
		
		$data['sequence'] = $this->sequences_model->get_sequences($sequence_id);	
		$data['title'] = 'Edit Sequence';
		$data['use_sidebar'] = TRUE;
		
		if (empty($data['sequence']))
		{
			show_404();
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		
		$this->form_validation->set_rules('sequence_name', 'text', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			if ($async)
			{
				$this->load->view('sequences/edit_ajax', $data);
			}
			else 
			{
				$this->load->view('sequences/edit_modal', $data);
			}
		}
		else
		{
						
			// first we create the new tasks, which should be assigned to a user right after the page is reloaded
			$this->sequences_model->edit_sequence();
			
			$this->session->set_flashdata('message', 'Sequence <strong>' . $sequence_id . '</strong> has been updated!');
			redirect('/sequences/');
		}
	}


	function delete($sequence_id, $async = FALSE)
	{
		
		$data['sequence'] = $this->sequences_model->get_sequences($sequence_id);
				
		if (empty($data['sequence']))
		{
			show_404();
		}
						
		$this->sequences_model->delete_sequence($sequence_id);
		
		$this->session->set_flashdata('message', 'Sequence <strong>' . $sequence_id . '</strong> has been deleted, along with the relative data!');
		redirect('/sequences/');
	}

}


