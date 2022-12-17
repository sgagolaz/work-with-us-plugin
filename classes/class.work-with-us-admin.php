<?php_check_syntax

class WorkWithUsPluginAdmin {
	
	public static function init() {
	
		
	}
	
	public static function add_submenu() {
		add_options_page(
			'Modifica Call-to-action "governo"',
			'Call-to-action "governo"',
			'administrator'
			// 'work_with_us_plugin_edit_menu'
		);
	}
	
}
