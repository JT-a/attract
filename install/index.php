<?php

/**
* Installer v 1.2
*
* Installs Attract
*
* @author Francesco Siddi
* @package Attract
*/

//error_reporting(E_NONE); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.


function currentPageUrlMinusInstall() {
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"])) {$pageURL .= "s";}
		$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return substr($pageURL,0,strrpos($pageURL,'install/'));
}


$db_config_path = '../application/config/database.php';

// Only load the classes in case the user submitted the form
if($_POST) {

	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');

	$core = new Core();
	$database = new Database();


	// Validate the post data
	if($core->validate_post($_POST) == true)
	{

		// First create the database, then create tables, then write config file
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		} else if ($core->write_databse_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod application/config/database.php file to 777");
		} else if ($core->write_app_config($_POST) == false) {
			$message = $core->show_message('error',"The application configuration file could not be written, please chmod application/config/config.php file to 777");
		}

		// If no errors, redirect to registration page
		if(!isset($message)) {
		  $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
      $redir .= "://".$_SERVER['HTTP_HOST'];
      $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
      $redir = str_replace('install/','',$redir); 
			header( 'Location: ' . $redir . 'shots' ) ;
		}

	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, and database name are required.');
		$error_message = 'Not all fields have been filled in correctly. The host, username, password, and database name are required.';
	}
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link href="<?php echo currentPageUrlMinusInstall(); ?>assets/css/bootstrap.min.css" rel="stylesheet">

		<title>Install | Attract</title>
	</head>
	<body>
	<div class="container">
		<div class="row">
			
	        <div class="col-md-6 col-md-offset-3">
	        	<div class="page-header">
					<h1>Attract 2.0 Installation</h1>
					<p class="lead">Insert the <i>database</i> credentials to install Attract</p>
				</div>
				
				<?php if (isset($error_message)): ?>
				<div class="alert alert-warning">
					<?php echo($error_message); ?>
				</div>
				<?php endif;?>
	        	
				<form class="form-horizontal" role="form" id="install_form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		
					<div class="form-group">
						<label class="col-sm-4 control-label">Webroot</label>
						<div class="col-sm-8">
					      	<input type="text" id="base_url" value="<?php echo currentPageUrlMinusInstall(); ?>" class="form-control" name="base_url" />
					    </div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Hostname</label>
						<div class="col-sm-8">
					      	<input type="text" id="hostname" value="localhost" class="form-control" name="hostname" />
					    </div>
					</div>
					<div class="form-group">
					   	<label class="col-sm-4 control-label">Username</label>
					    <div class="col-sm-8">
					    	<input type="text" id="username" class="form-control" name="username" placeholder="root" />
					    </div>
					</div>
					<div class="form-group">
					    <label for="inputPassword" class="col-sm-4 control-label">Password</label>
					    <div class="col-sm-8">
						    <input type="password" id="password" class="form-control" name="password" placeholder="root" />
					    </div>
					</div>
					<div class="form-group">
					    <label class="col-sm-4 control-label">DB Name</label>
					    <div class="col-sm-8">
						    <input type="text" id="database" class="form-control" name="database" placeholder="attract" />
					    </div>
					</div>
					<div class="form-group">
					    <div class="col-sm-8 col-sm-offset-4">
						    <button class="btn btn-primary" type="submit" value="Install" id="submit">Install Attract</button>
					    </div>
					</div>
				</form>
			    <p>You will be able to login into Attract with the following credentials:</p>
			    <ul>
			    	<li>Username: admin@admin.com</li>
			    	<li>Password: password</li>
			    </ul>
	        </div>
      	</div>
	</div>
	</body>
</html>
