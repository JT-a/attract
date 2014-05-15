<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title ?> - Attract</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="<?php echo assets_url(); ?>/css/bootstrap.min.css" rel="stylesheet">

  
    <link href="<?php echo assets_url(); ?>/css/chosen.min.css" rel="stylesheet">
    <link href="<?php echo assets_url(); ?>/css/bootstrap-markdown.min.css" rel="stylesheet">
    <link href="<?php echo assets_url(); ?>/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo assets_url(); ?>/css/attract.css" rel="stylesheet">
    <link href="<?php echo assets_url(); ?>/css/bootstrap-colorpicker.min.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo assets_url(); ?>/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo assets_url(); ?>/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo assets_url(); ?>/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo assets_url(); ?>/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>/ico/favicon.png">
    
    <script src="<?php echo assets_url(); ?>/js/jquery.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/jquery.knob.js"></script>
    <script src="<?php echo assets_url(); ?>/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/jquery.dataTables.fnGetColumnData.js"></script>
    <script src="<?php echo assets_url(); ?>/js/jquery.dataTables.fnFilterClear.js"></script>
    <script src="<?php echo assets_url(); ?>/js/jquery.dataTables.bootstrap.js"></script>
    <!-- <script src="<?php echo assets_url(); ?>/js/jquery.jeditable.js"></script> -->
    <script src="<?php echo assets_url(); ?>/js/jquery.chosen.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/bootstrap-markdown.js"></script>
    <script src="<?php echo assets_url(); ?>/js/markdown.js"></script>

    <script src="<?php echo assets_url(); ?>/js/jquery.attract.js"></script>
  </head>

  <body>
	
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="<?php echo site_url(); ?>" class="navbar-brand">Attract</a>
        </div>
        <div class="navbar-collapse collapse">
        	
        <ul class="nav navbar-nav navbar-right">

	        <li id="fat-menu" class="dropdown">
	          <a href="#" id="drop3" class="dropdown-toggle" data-toggle="dropdown">
	          	<?php echo $the_user->email ?> 
	          	<?php echo ($unread_comment_notifications > 0 ? ' <span class="badge">' . $unread_comment_notifications . '</span> ' : ''); ?>
	          	<b class="caret"></b>
	          </a>
	          <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
	            <li><a role="menuitem" tabindex="-1" href="<?php echo site_url("/user/tasks/") ;?>">My tasks</a></li>
	            <li><a role="menuitem" tabindex="-1" href="<?php echo site_url("/user/activity/") ;?>">Activity</a></li>
	            <li><a role="menuitem" tabindex="-1" href="<?php echo site_url("/user/profile/") ;?>">Edit profile</a></li>
	            <li class="divider"></li>
	            <li><a role="menuitem" tabindex="-1" href="<?php echo site_url("/auth/logout/") ;?>">Log out</a></li>
	          </ul>
	    	</li>
	    </ul>
        
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <div class="container">
    	<div class="row">
      
 
