# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.33)
# Database: conf
# Generation Time: 2014-02-19 00:53:13 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table attachments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attachments`;

CREATE TABLE `attachments` (
  `attachment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `attachment_name` varchar(256) NOT NULL,
  `attachment_path` varchar(512) NOT NULL,
  `attachment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `comment_body` text,
  `comment_edit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment_creation_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table comments_attachments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments_attachments`;

CREATE TABLE `comments_attachments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `attachment_id` int(11) unsigned NOT NULL,
  `comment_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `files`;

CREATE TABLE `files` (
  `file_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_path` varchar(255) DEFAULT NULL,
  `file_settings` mediumtext,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `description` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `description`)
VALUES
	(1,'admin','Administrator'),
	(2,'members','General User'),
	(3,'artists','People who work on art');

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table login_attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) CHARACTER SET latin1 NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`version`)
VALUES
	(5);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table scenes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `scenes`;

CREATE TABLE `scenes` (
  `scene_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sequence_id` int(11) NOT NULL,
  `scene_name` text NOT NULL,
  `scene_description` text,
  PRIMARY KEY (`scene_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `scenes` WRITE;
/*!40000 ALTER TABLE `scenes` DISABLE KEYS */;

INSERT INTO `scenes` (`scene_id`, `sequence_id`, `scene_name`, `scene_description`)
VALUES
	(1,1,'Default Scene',NULL);

/*!40000 ALTER TABLE `scenes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sequences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sequences`;

CREATE TABLE `sequences` (
  `sequence_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `show_id` int(11) DEFAULT NULL,
  `sequence_name` text NOT NULL,
  `sequence_description` text,
  PRIMARY KEY (`sequence_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `sequences` WRITE;
/*!40000 ALTER TABLE `sequences` DISABLE KEYS */;

INSERT INTO `sequences` (`sequence_id`, `show_id`, `sequence_name`, `sequence_description`)
VALUES
	(1,1,'Default Sequence','Sequence Description');

/*!40000 ALTER TABLE `sequences` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_group` int(11) DEFAULT NULL,
  `setting_name` varchar(250) DEFAULT NULL,
  `setting_value` text,
  `setting_help` text,
  `setting_options` text,
  `setting_hidden` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`setting_id`, `setting_group`, `setting_name`, `setting_value`, `setting_help`, `setting_options`, `setting_hidden`)
VALUES
	(1,0,'current_show','1','You can pick only one show at a time.',NULL,NULL);

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table shot_comment_notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shot_comment_notifications`;

CREATE TABLE `shot_comment_notifications` (
  `shot_comment_notification_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `comment_id` int(11) unsigned NOT NULL,
  `shot_comment_description` varchar(256) NOT NULL,
  `was_seen` tinyint(1) NOT NULL,
  PRIMARY KEY (`shot_comment_notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shot_edit_notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shot_edit_notifications`;

CREATE TABLE `shot_edit_notifications` (
  `shot_edit_notification_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `shot_edit_description` int(11) unsigned NOT NULL,
  `was_seen` tinyint(1) NOT NULL,
  PRIMARY KEY (`shot_edit_notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shot_tasks_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shot_tasks_users`;

CREATE TABLE `shot_tasks_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shot_task_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shots
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shots`;

CREATE TABLE `shots` (
  `shot_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `scene_id` int(11) DEFAULT NULL,
  `shot_name` varchar(256) DEFAULT NULL,
  `shot_description` text,
  `shot_duration` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `shot_notes` text,
  `shot_order` int(11) DEFAULT NULL,
  `shot_creation_date` datetime DEFAULT NULL,
  `shot_edit_date` datetime DEFAULT NULL,
  PRIMARY KEY (`shot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shots_attachments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shots_attachments`;

CREATE TABLE `shots_attachments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `attachment_id` int(11) unsigned NOT NULL,
  `shot_id` int(11) unsigned NOT NULL,
  `is_current` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shots_files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shots_files`;

CREATE TABLE `shots_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shots_subscriptions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shots_subscriptions`;

CREATE TABLE `shots_subscriptions` (
  `shot_subscription_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `subscription_type` varchar(256) NOT NULL,
  PRIMARY KEY (`shot_subscription_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shots_tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shots_tasks`;

CREATE TABLE `shots_tasks` (
  `shot_task_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `shot_task_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`shot_task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table shots_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shots_users`;

CREATE TABLE `shots_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `shot_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='This table is for shot supervisors';



# Dump of table shows
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shows`;

CREATE TABLE `shows` (
  `show_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `show_name` varchar(256) NOT NULL DEFAULT '',
  `show_description` text,
  `show_path` text,
  PRIMARY KEY (`show_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `shows` WRITE;
/*!40000 ALTER TABLE `shows` DISABLE KEYS */;

INSERT INTO `shows` (`show_id`, `show_name`, `show_description`, `show_path`)
VALUES
	(1,'Default Show','Default description','/path/to/files/');

/*!40000 ALTER TABLE `shows` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `statuses`;

CREATE TABLE `statuses` (
  `status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status_name` varchar(256) NOT NULL DEFAULT '',
  `status_color` tinytext CHARACTER SET latin1,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `statuses` WRITE;
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;

INSERT INTO `statuses` (`status_id`, `status_name`, `status_color`)
VALUES
	(1,'in_progress','#F0AD4E'),
	(2,'todo','#999999'),
	(3,'final_1','#5CB85C'),
	(4,'fix','#D9534F'),
	(5,'review','#5BC0DE'),
	(6,'CBB','#428BCA');

/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `task_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_name` varchar(128) NOT NULL DEFAULT '',
  `task_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;

INSERT INTO `tasks` (`task_id`, `task_name`, `task_order`)
VALUES
	(1,'boards',NULL),
	(2,'layout',NULL),
	(3,'animatic',NULL),
	(4,'lighting',NULL),
	(6,'animation',NULL);

/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 NOT NULL,
  `password` varchar(80) CHARACTER SET latin1 NOT NULL,
  `salt` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 NOT NULL,
  `activation_code` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `forgotten_password_code` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `company` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`)
VALUES
	(1,X'7F000001','admin','59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4','9462e8eee0','admin@admin.com','',NULL,NULL,NULL,1268889823,1392768174,1,'Uncle','Rossi','Blender Institute','--');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`)
VALUES
	(14,1,1),
	(15,1,2);

/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
