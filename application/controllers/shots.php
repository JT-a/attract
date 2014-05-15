<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Shots Controller
*
* Manages shots
*
* @author Francesco Siddi
* @package Attract
*/


class Shots extends Common_Auth_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('shots_model');
	}

	function index()
	{
		$this->load->model('statuses_model');
		$this->load->model('tasks_model');
		$this->load->model('users_model');
		$data['users'] = $this->users_model->get_users();
		$data['statuses'] = $this->statuses_model->get_statuses();
		$data['tasks'] = $this->tasks_model->get_tasks();
		$data['shots'] = $this->shots_model->get_shots();
		$data['title'] = 'Shots';
		$data['use_sidebar'] = TRUE;
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('shots/index', $data);
		$this->load->view('templates/footer');
	}

	function view($shot_id, $view_comments = FALSE)
	{
		// if we send a post variable 'view_comments' then we mark the unread notifications
		// as read
		
		$this->load->helper('form');
		$this->load->library('ion_auth');
		$this->load->library('gravatar');
		$this->load->model('comments_model');
		$this->load->model('shots_attachments_model');
		$this->load->model('shots_subscriptions_model');
		$this->load->model('shot_comment_notifications_model');
		
		$user = $this->ion_auth->user()->row();
		
		$data['shots'] = $this->shots_model->get_shots();
		$data['shot'] = $this->shots_model->get_shots($shot_id);
		$data['comments'] = $this->comments_model->get_shot_comments($shot_id);
		$data['previews'] = $this->shots_attachments_model->get_shot_attachments($shot_id);
		$data['gravatar'] = $this->gravatar->get_gravatar($user->email, NULL, 60);
		
		
		if ($view_comments == 'view_comments')
		{
			$this->shot_comment_notifications_model->mark_shot_comment_notifications_as_read($shot_id);
		}
		
		// we get the user subscriptions for the shot
		$shots_subscriptions = $this->shots_subscriptions_model->get_shot_subscriptions($shot_id);
			
		// this is the array we are going to check against to see which subscriptions are available
		$subscriptions = array(
			'comments' => FALSE,
			'edits' => FALSE);
		
		foreach ($shots_subscriptions as $subscription) 
		{
			if ($subscription['subscription_type'] == 'comments') 
			{
				$subscriptions['comments'] = TRUE;
			} 
			else if ($subscription['subscription_type'] == 'edits') 
			{
				$subscriptions['edits'] = TRUE;
			}
		}
		$data['subscriptions'] = $subscriptions;
		
		$data['title'] = 'Shot';
		$data['use_sidebar'] = TRUE;
		$data['error'] = '';
		
		if (empty($data['shot']))
		{
			show_404();
		}
	
		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar_shots', $data);
		$this->load->view('shots/view', $data);
		$this->load->view('templates/footer');
	}
	
	function create()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('scenes_model');
		$this->load->model('statuses_model');
		$this->load->model('tasks_model');
		$this->load->model('shots_users_model');
		$this->load->model('shots_tasks_model');
		$this->load->model('users_model');
		$this->load->model('shot_tasks_users_model');
		
		
		$data['scenes'] = $this->scenes_model->get_scenes();
		$data['statuses'] = $this->statuses_model->get_statuses();
		$data['tasks'] = $this->tasks_model->get_tasks();
		
		$data['title'] = 'Create a new shot';

		$last_shot_position = $this->shots_model->get_last_shot_position();
		$data['shot_order'] = $last_shot_position['shot_order'] + 1;
		
		$this->form_validation->set_rules('shot_name', 'text', 'required');
		$this->form_validation->set_rules('shot_description', 'text', 'required');
		$this->form_validation->set_rules('shot_duration', 'text', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			//$this->load->view('templates/header', $data);	
			//$this->load->view('shots/create', $data);
			//$this->load->view('templates/footer');
			$this->load->view('shots/create_modal', $data);
			
		}
		else
		{
			$shot_data = $this->shots_model->set_shots();
			// TODO at the moment we assign to one hardcoded user, should be changed
			// $this->shots_users_model->set_user($shot_data['shot_id'], $shot_data['user_id']);
			
			// we reload some data
			// $last_shot_position = $this->shots_model->get_last_shot_position();
			// $data['shot_order'] = $last_shot_position['shot_order'] + 1;
		
			// $this->load->view('templates/header', $data);	
			// $this->load->view('shots/create', $data);
			// $this->load->view('templates/footer');
			
			$this->session->set_flashdata('message', 'Shot <strong>'. $shot_data['shot_name'] .'</strong> added to database!');

			redirect('/shots/');
			
		}
	}
	
	function edit($shot_id, $async = FALSE)
	{
		$this->load->model('scenes_model');
		$this->load->model('statuses_model');
		$this->load->model('tasks_model');
		$this->load->model('shots_users_model');
		$this->load->model('shots_tasks_model');
		$this->load->model('users_model');
		$this->load->model('shot_tasks_users_model');
		
		$data['shots'] = $this->shots_model->get_shots();
		$data['shot'] = $this->shots_model->get_shots($shot_id);
		$data['scenes'] = $this->scenes_model->get_scenes();
		$data['statuses'] = $this->statuses_model->get_statuses();
		$data['tasks'] = $this->tasks_model->get_tasks();
		$data['users'] = $this->users_model->get_users();
		$data['shot_users'] = $this->shots_users_model->get_users($shot_id);
		$data['shot_tasks'] = $this->shots_tasks_model->get_tasks($shot_id);
		$data['shot_tasks_users'] = $this->shot_tasks_users_model->get_users($shot_id);
		$data['title'] = 'Edit Shot';
		$data['use_sidebar'] = TRUE;
		
		if (empty($data['shot']))
		{
			show_404();
		}
		
		$this->load->helper('form');
		$this->load->library('form_validation');

		
		$this->form_validation->set_rules('shot_name', 'text', 'required');
		$this->form_validation->set_rules('shot_description', 'text', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{
			if ($async)
			{
				$this->load->view('shots/edit_ajax', $data);
			}
			else 
			{
				$this->load->view('templates/header', $data);
				$this->load->view('templates/sidebar_shots', $data);	
				$this->load->view('shots/edit', $data);
				$this->load->view('templates/footer');	
			}
		}
		else
		{
							
			$this->shots_model->set_shots($shot_id);
			//$this->shots_users_model->set_users($shot_id);
			
			// first we create the new tasks, which should be assigned to a user right after the page is reloaded
			$this->shots_tasks_model->set_tasks($shot_id);
			
			// then we check if some tasks have been removed (and remove users associated with them)
			$this->shot_tasks_users_model->set_users($shot_id);
		
			$this->session->set_flashdata('message', 'Shot <strong>' . $shot_id . '</strong> has been updated!');
			redirect('/shots/edit/' . $shot_id);
		}
	}

	function delete($shot_id)
	{

		$this->shots_model->delete_shot($shot_id);
		
		$this->session->set_flashdata('message', 'Shot <strong>' . $shot_id . '</strong> has been deleted!');
		redirect('/shots/', 'refresh');
	}

	function edit_single($shot_id, $property, $value)
	{
		print($shot_id + $property + $value);
		$data['shot'] = $this->shots_model->get_shots($shot_id);
		if (empty($data['shot']))
		{
			show_404();
		}
		$this->shots_model->set_shot_property($shot_id, $property, $value);
		return;
	}
	
	function get_users_selector($shot_id)
	{
		$this->load->model('users_model');
		$this->load->model('shots_users_model');
		
		$data['active_users'] = $this->shots_users_model->get_users($shot_id);
		$data['users'] = $this->users_model->get_users();
	
		$this->load->view('users_selector', $data);
		
	}
	
	function post_add_shot_task($shot_id)
	{
		$task_id = $this->input->post('task_id');
		$status_id = $this->input->post('status_id');
						
		$this->load->model('shots_tasks_model');
		$shot_task_id = $this->shots_tasks_model->set_task($shot_id, $task_id, $status_id);
		print $shot_task_id;
		return;
	}
	
	function assign_users($shot_id)
	{
		$this->load->model('users_model');
		$this->load->model('shots_users_model');
		
		$this->shots_users_model->set_users($shot_id);
	
		return;
		
	}
	
	// Generic function to get shots based on any related property. The first implementation
	// uses tasks names and statuses (we enclose these properties in an array)
	
	function post_index() {
		$task_id = $this->input->post('task_id');
		$status_id = $this->input->post('status_id');
		$this->load->model('shots_tasks_model');
		$data['shots'] = $this->shots_tasks_model->get_shots_by_tasks($task_id, $status_id);
	
		$this->load->view('shots/index_ajax', $data);
	}
	
	
	function post_add_comment()
	{
		$shot_id = $this->input->post('shot_id');
		
		if (!$shot_id)
		{
			redirect('/shots');
		}
		
		$this->load->helper('form');
		$this->load->model('comments_model');
		$this->load->model('comments_attachments_model');
		$this->load->model('shots_subscriptions_model');
		$this->load->model('shot_comment_notifications_model');
		$this->load->library('form_validation');
		
		$data['shots'] = $this->shots_model->get_shots();
		$data['shot'] = $this->shots_model->get_shots($shot_id);
		$data['comments'] = $this->comments_model->get_shot_comments($shot_id);
		$data['title'] = 'Shot';
		$data['use_sidebar'] = TRUE;
		$data['error'] = '';
		

		$this->form_validation->set_rules('shot_id', 'comment_body');
		
		if ($this->form_validation->run() === FALSE)
		{
			redirect('/shots/view/'. $shot_id);	
		}
		else
		{
			$this->load->model('attachments_model');
		
			$config['upload_path'] = './uploads/originals/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '1000';
			$config['max_width']  = '2048';
			$config['max_height']  = '2048';
			$config['encrypt_name'] = true;

			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
				// we skip the error if a file is not uploaded	
				$data['error'] = $this->upload->display_errors();
				
				if ($data['error'] == '<p>You did not select a file to upload.</p>') {
					$data['error'] = '';
				}
				
				// in any other case we set the erro in a flashcard
				$this->session->set_flashdata('message', $data['error']);
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				// we create an attachment entry in the database
				$attachment_id = $this->attachments_model->create_attachment($data['upload_data']['orig_name'], $data['upload_data']['raw_name'] . $data['upload_data']['file_ext']);
				//$this->load->view('upload_success', $data);
				
				// we make a thumbnail for the uploaded image
				$this->load->library('image_lib');

				$source_path = "./uploads/originals/";
			    $thumbnail_path = "./uploads/thumbnails/";
			
			    $source_image = $data['upload_data']['raw_name'].$data['upload_data']['file_ext'];
			    $medium_image = '200_'.$data['upload_data']['raw_name'].$data['upload_data']['file_ext'];
			
			    // Resize to medium
			
			    $config['source_image'] = $source_path.$source_image;
			    $config['new_image'] = $thumbnail_path.$medium_image;
			    $config['width'] = 200;
			    $config['height'] = 200;

			    $this->image_lib->initialize($config); 

			    if ( ! $this->image_lib->resize())
			    {
			    	echo $config['source_image'];
			        echo $this->image_lib->display_errors();
			    }
			
				$this->session->set_flashdata('message', 'Comment added to database!');
			}
			// we create the comment (the model function will get all the data via post) and get its id
			$comment_id = $this->comments_model->create_comment();
			
			// if we have uploaded an attachment we match it with the comment in the dedicated table
			if (isset($attachment_id))
			{
				$this->comments_attachments_model->create_comment_attachment($attachment_id, $comment_id);
			}
			
			// we get the user subscribed to comments for the shot
			$users_subscribed_to_comments = $this->shots_subscriptions_model->get_users_subscribed_to_comments($shot_id);
					
			foreach ($users_subscribed_to_comments as $user) 
			{
				$this->shot_comment_notifications_model->create_shot_comment_notification($shot_id, $comment_id, $user['user_id'], 'New comment on shot');
			}

		}
		// we reload the page (will display flashcard if present)
		redirect('/shots/view/'. $shot_id);
	}

	function post_add_preview()
	{
		$shot_id = $this->input->post('shot_id');
		
		if (!$shot_id)
		{
			redirect('/shots');
		}
		
		$this->load->helper('form');
		$this->load->model('shots_attachments_model');
		$this->load->library('form_validation');
		
		// shot thumbnail creation
		$this->load->model('attachments_model');
	
		$config['upload_path'] = './uploads/originals/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '2048';
		$config['max_height']  = '2048';
		$config['encrypt_name'] = true;

		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload())
		{
			// we collect any error	
			$data['error'] = $this->upload->display_errors();
						
			// we set the error in a flashcard
			$this->session->set_flashdata('message', $data['error']);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			// we create an attachment entry in the database
			$attachment_id = $this->attachments_model->create_attachment($data['upload_data']['orig_name'], $data['upload_data']['raw_name'] . $data['upload_data']['file_ext']);
			//$this->load->view('upload_success', $data);
			
			// we make a thumbnail for the uploaded image
			$this->load->library('image_lib');

			$source_path = "./uploads/originals/";
		    $thumbnail_path = "./uploads/thumbnails/";
		
		    $source_image = $data['upload_data']['raw_name'].$data['upload_data']['file_ext'];
			
			// Resize to medium
			// We prepend the resolution value (400) so that in the frontend we can call any version
			// by just prepend the desired value
		    $medium_image = '400_'.$data['upload_data']['raw_name'].$data['upload_data']['file_ext'];
		
		    $config['source_image'] = $source_path.$source_image;
		    $config['new_image'] = $thumbnail_path.$medium_image;
		    $config['width'] = 400;
		    $config['height'] = 400;
		
		    $this->image_lib->initialize($config); 
		
		    if ( ! $this->image_lib->resize())
		    {
		    	echo $config['source_image'];
		        echo $this->image_lib->display_errors();
		        
		    }
			
			$upload_data = $this->upload->data();
			
			// Resize to small
			$medium_image = '80_'.$data['upload_data']['raw_name'].$data['upload_data']['file_ext'];
				
		    $config['source_image'] = $source_path.$source_image;
		    $config['new_image'] = $thumbnail_path.$medium_image;
		    $config['width'] = 80;
		    $config['height'] = 40;
			$dim = (intval($upload_data["image_width"]) / intval($upload_data["image_height"])) - ($config['width'] / $config['height']);
			$config['master_dim'] = ($dim > 0)? "height" : "width";
		
		    $this->image_lib->initialize($config); 
		
		    if ( ! $this->image_lib->resize())
		    {
		    	echo $config['source_image'];
		        echo $this->image_lib->display_errors();
		        
		    }
			
			$config['source_image']	= $thumbnail_path.$medium_image;
			$config['new_image'] = $thumbnail_path.$medium_image;
			$config['maintain_ratio'] = TRUE;
			$config['width'] = 80;
		    $config['height'] = 45;
			$config['x_axis'] = '0';
			$config['y_axis'] = '0';
			
			$this->image_lib->clear();
			$this->image_lib->initialize($config); 
			
			if ( ! $this->image_lib->crop())
			{
			    echo $this->image_lib->display_errors();
			}
		
		}
		
		// if we have uploaded an attachment we match it with the comment in the dedicated table
		if (isset($attachment_id))
		{
			$this->shots_attachments_model->create_shot_attachment($attachment_id, $shot_id);
		}
		
		redirect('/shots/view/' . $shot_id);
	}

	function delete_preview($attachment_id) 
	{
		$this->shots_model->delete_preview($attachment_id);
		
		$this->session->set_flashdata('message', 'Attachment <strong>' . $attachment_id . '</strong> has been deleted, along with the relative data!');
		redirect('/shots/');
	}
	
	function post_subscribe_to_comments()
	{
		// We are going to call this mostly via AJAX
		$this->load->model('shots_subscriptions_model');
		$this->shots_subscriptions_model->create_shot_subscription();
				
		$this->output->set_status_header('200');
	}

	function post_unsubscribe_from_comments()
	{
		// We are going to call this mostly via AJAX
		$this->load->model('shots_subscriptions_model');
		$this->shots_subscriptions_model->delete_shot_subscription();
				
		$this->output->set_status_header('200');
	}
	
}

/* End of file shots.php */
/* Location: ./application/controllers/shots.php */

