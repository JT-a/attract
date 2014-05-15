<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {

    protected $the_user;

    public function __construct() {

        parent::__construct();

        if($this->ion_auth->is_admin()) {
            $this->the_user = $this->ion_auth->user()->row();
			$data = new stdClass;
            $data->the_user = $this->the_user;
			$data->is_admin = TRUE;
            // we load comment notifications
			$this->load->model('shot_comment_notifications_model');
			$data->unread_comment_notifications = $this->shot_comment_notifications_model->get_unread_shot_comment_notifications_count();
			
			$this->load->vars($data);
        }
        else {
            redirect('/');
        }
    }
}

class User_Controller extends CI_Controller {

    protected $the_user;

    public function __construct() {

        parent::__construct();

        if($this->ion_auth->in_group('users')) {
            $this->the_user = $this->ion_auth->user()->row();
			$data = new stdClass;
            $data->the_user = $this->the_user;
			$data->is_admin = FALSE;
            // we don't load comment notifications. Currently this is a workaround to prevent
            // migration issues, but should be fixed by placing the notifications somewhere
            // welse perhaps
			// $this->load->model('shot_comment_notifications_model');
			// $data->unread_comment_notifications = $this->shot_comment_notifications_model->get_unread_shot_comment_notifications_count();
			$data->unread_comment_notifications = 0;
			
			$this->load->vars($data);
        }
        else {
            redirect('/');
        }
    }
}

class Common_Auth_Controller extends CI_Controller {

    protected $the_user;

    public function __construct() {

        parent::__construct();

        if($this->ion_auth->logged_in()) {
            $this->the_user = $this->ion_auth->user()->row();
			$data = new stdClass;
			if($this->ion_auth->is_admin()){
				$data->is_admin = TRUE;
			} else {
				$data->is_admin = FALSE;
			}
            $data->the_user = $this->the_user;
            
			// we load comment notifications
			$this->load->model('shot_comment_notifications_model');
			$data->unread_comment_notifications = $this->shot_comment_notifications_model->get_unread_shot_comment_notifications_count();
			
			$this->load->vars($data);
        }
        else {
            redirect('/auth/');
        }
    }
}