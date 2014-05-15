<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Shots_subscriptions extends CI_Migration {

	public function up()
	{
			
		// shots_subscriptions table generation
		$fields = array(
			'shot_subscription_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE,
                 'auto_increment' => TRUE
            				),
            'shot_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE,
                              ),
            'user_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE
             				),
            'subscription_type' => array(
                 'type' => 'VARCHAR',
                 'constraint' => 256
				 )
        );
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('shot_subscription_id', TRUE);
		$this->dbforge->create_table('shots_subscriptions');
		
		
		// shot_comment_notifications table generation
		$fields = array(
			'shot_comment_notification_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE,
                 'auto_increment' => TRUE
            				),
            'shot_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE,
                              ),
            'user_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE
             				),
            'comment_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE
             				),
            'shot_comment_description' => array(
                 'type' => 'VARCHAR',
                 'constraint' => 256
				 ),
             'was_seen' => array(
                 'type' => 'BOOL' 
             				)
        );
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('shot_comment_notification_id', TRUE);
		$this->dbforge->create_table('shot_comment_notifications');
		
		
		// shot_edit_notifications table generation
		$fields = array(
			'shot_edit_notification_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE,
                 'auto_increment' => TRUE
            				),
            'shot_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE,
                              ),
            'user_id' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE
             				),
            'shot_edit_description' => array(
                 'type' => 'INT',
                 'constraint' => 11, 
                 'unsigned' => TRUE
             				),
             'was_seen' => array(
                 'type' => 'BOOL' 
             				)
        );
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('shot_edit_notification_id', TRUE);	
		$this->dbforge->create_table('shot_edit_notifications');

	}

	public function down()
	{
		$this->dbforge->drop_table('shots_subscriptions');
		$this->dbforge->drop_table('shot_comment_notifications');
		$this->dbforge->drop_table('shot_edit_notifications');
	}
}

/* End of file 005_shots_subscriptions.php */
/* Location: ./application/migrations/005_shots_subscriptions.php */
