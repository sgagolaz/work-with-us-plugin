<?php
/**
 * @package WorkWithUsPlugin
 */
/*
Plugin Name: Work With Us ilpost.it
Plugin URI: https://github.com/sgagolaz/work-with-us-plugin
Description: Job application test. This plugin inserts a call-to-action after the 4th paragraph of posts tagged as "governo".
Version: 1.0.1
Requires at least: 6.1.1
Requires PHP: 8.1.12
Author: sgagolaz
Author URI: https://essediomino.pythonanywhere.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2022 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}


// Define basic constants
define ('WORK_WITH_US_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


// Import basic classes:
// WorkWithUsPlugin
require_once WORK_WITH_US_PLUGIN_DIR. '/classes/class.work-with-us-plugin.php';


// Register for activation and deactivation hooks. As of 0.1.0 version, the method called does nothing
register_activation_hook( __FILE__, array('WorkWithUsPlugin', 'plugin_activation' ));
register_activation_hook( __FILE__, array('WorkWithUsPlugin', 'plugin_deactivation' ));


// Add initializing action to wordpress' initialization hook
add_action( 'init', array('WorkWithUsPlugin', 'init') );

// If admin mode is active, then import admin class and initialize
if ( is_admin() ) {
	require (WORK_WITH_US_PLUGIN_DIR.'/classes/class.work-with-us-plugin-admin.php');
	add_action('init', array('WorkWithUsPluginAdmin', 'init'));
}

