<?php

class WorkWithUsPluginAdmin {
	
	const SUBMENU_TITLE="Modifica Call-to-action 'governo'";
	const SUBMENU_MENU_TITLE="Call-to-action governo";
	
	public static function init() {
		add_action('admin_menu', array('WorkWithUsPluginAdmin', 'add_submenu'));
	}
	
	public static function add_submenu() {
		add_options_page(
			self::SUBMENU_TITLE,
			self::SUBMENU_MENU_TITLE,
			'administrator',
			'work_with_us_plugin_configuration',
			array('WorkWithUsPluginAdmin', 'view_page')
		);
	}
	
	public static function view_page() {
		WorkWithUsPlugin::view('config');
	}
	
}
