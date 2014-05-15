<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign in &middot; Attract</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo assets_url(); ?>/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
		  padding-top: 40px;
		  padding-bottom: 40px;
		  background-color: #eee;
		}
		
		.form-signin {
		  max-width: 330px;
		  padding: 15px;
		  margin: 0 auto;
		}
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
		  margin-bottom: 10px;
		}
		.form-signin .checkbox {
		  font-weight: normal;
		}
		.form-signin .form-control {
		  position: relative;
		  font-size: 16px;
		  height: auto;
		  padding: 10px;
		  -webkit-box-sizing: border-box;
		     -moz-box-sizing: border-box;
		          box-sizing: border-box;
		}
		.form-signin .form-control:focus {
		  z-index: 2;
		}
		.form-signin input[type="text"] {
		  margin-bottom: -1px;
		  border-bottom-left-radius: 0;
		  border-bottom-right-radius: 0;
		}
		.form-signin input[type="password"] {
		  margin-bottom: 10px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}

    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../../assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">
  </head>

  <body>

    <div class="container">
	<?php $attributes = array('class' => 'form-signin'); ?>
	<?php echo form_open("auth/login", $attributes);?>
        <h2 class="form-signin-heading"><?php echo lang('login_heading');?></h2>
		<div id="infoMessage"><?php echo $message;?></div>
		
		<?php $identity['class'] = 'form-control'; ?>
		<?php $identity['placeholder'] = 'Email address'; ?>
		<?php echo form_input($identity);?>

		<?php $password['class'] = 'form-control' ?>
		<?php $password['placeholder'] = 'Password'; ?>
		<?php echo form_input($password);?>
		
		<label class="checkbox">
			<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
			<?php echo lang('login_remember_label', 'remember');?>
		</label>
		
		
		<?php $attributes = array(
			'class' => 'btn btn-lg btn-primary btn-block',
			'name' => 'submit',
			'value' => 'login'
		); ?>
  		<?php echo form_submit($attributes)?>

      <?php echo form_close();?>

    </div> <!-- /container -->

  </body>
</html>

