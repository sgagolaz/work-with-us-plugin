<?php

// if I am not in the admin page there's no need at all
// for this class, since it is only used for configuration
// management.
if (is_admin()) {

class WorkWithUsPluginAdmin {
	
	const SUBMENU_TITLE="Configurazione Call-to-action";
	const SUBMENU_MENU_TITLE="Call-to-action";
	const SETTING_NAME="work_with_us_plugin_configuration";
	const SETTING_SECTION_NAME="wwup_call_to_action_html";
	const SETTING_FIELD_NAME="wwup_call_to_action_html_textarea";
	
	/**
	 * Add actions to add the menu entry in the admin page
	 * and to register setting
	 */
	public static function init() :void {
		add_action('admin_menu', array('WorkWithUsPluginAdmin', 'add_submenu'));
		add_action('admin_init', array('WorkWithUsPluginAdmin', 'register_setting'));
	}
	
	/**
	 * Method that adds the submenu to general options menu.
	 * Note: only users with administration role can view the entry menu
	 * and access to the page (even by direct url).
	 */
	public static function add_submenu() :void {
		add_options_page(
			self::SUBMENU_TITLE,
			self::SUBMENU_MENU_TITLE,
			'administrator', // role that can access this configuration page
			self::SETTING_NAME,
			array('WorkWithUsPluginAdmin', 'view_page')
		);
	}
	
	/**
	 * Register setting, the unique section associated and the unique field
	 * in the section.
	 */
	public static function register_setting() {
		register_setting(
			self::SETTING_NAME,
			WorkWithUsPlugin::HTML_OPTION_NAME
		);
		add_settings_section(
			self::SETTING_SECTION_NAME,
			'Modifica call-to-action',
			'', // callback. Since there is only one section, there is no need for a specific output
			self::SETTING_NAME
		);
		add_settings_field(
			self::SETTING_FIELD_NAME,
			'HTML content',
			array('WorkWithUsPluginAdmin', 'view_input'),
			self::SETTING_NAME,
			self::SETTING_SECTION_NAME,
			array(
				'label_for' => self::SETTING_FIELD_NAME,
				'class' => 'wwup_text_area_css_class'
			)
		);
	}
	
	/**
	 * Echoes the configuration page.
	 */
	public static function view_page() :void {
		WorkWithUsPlugin::view('config');
	}
	
	/**
	 * Echoes textarea input to edit HTML code of the call-to-action
	 * 
	 * @param	array	args	Arguments array defined in the add_settings_field function call
	 */
	public static function view_input($args) {
		$content = get_option(WorkWithUsPlugin::HTML_OPTION_NAME);
		WorkWithUsPlugin::view(
			'html_code_input', 
			array('content'=>$content, 'label_for'=>$args['label_for'])
		);
	}
	
}

}
