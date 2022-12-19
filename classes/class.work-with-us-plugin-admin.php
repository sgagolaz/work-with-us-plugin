<?php

if (is_admin()) {

class WorkWithUsPluginAdmin {
	
	const SUBMENU_TITLE="Configurazione Call-to-action";
	const SUBMENU_MENU_TITLE="Call-to-action governo";
	const SETTING_NAME="work_with_us_plugin_configuration";
	const SETTING_SECTION_NAME="wwup_call_to_action_html";
	const SETTING_FIELD_NAME="wwup_call_to_action_html_textarea";
	
	public static function init() {
		add_action('admin_menu', array('WorkWithUsPluginAdmin', 'add_submenu'));
		add_action('admin_init', array('WorkWithUsPluginAdmin', 'register_setting'));
	}
	
	public static function add_submenu() {
		add_options_page(
			self::SUBMENU_TITLE,
			self::SUBMENU_MENU_TITLE,
			'administrator',
			self::SETTING_NAME,
			array('WorkWithUsPluginAdmin', 'view_page')
		);
	}
	
	public static function view_page() {
		WorkWithUsPlugin::view('config');
	}
	
	public static function view_input($args) {
		// TODO:
		//	Check if current user has admin role
		$content = get_option(WorkWithUsPlugin::HTML_OPTION_NAME);
		?>
		<textarea
			name="<?php echo WorkWithUsPlugin::HTML_OPTION_NAME; ?>"
			id="<?php echo esc_attr( $args['label_for'] ); ?>" 
		><?php echo esc_html($content) ?></textarea><?php
	}
	
	public static function register_setting() {
		register_setting(
			self::SETTING_NAME,
			WorkWithUsPlugin::HTML_OPTION_NAME
		);
		add_settings_section(
			self::SETTING_SECTION_NAME,
			'Modifica call-to-action',
			'', // callback
			self::SETTING_NAME
		);
		add_settings_field(
			self::SETTING_FIELD_NAME,
			'HTML content',
			array('WorkWithUsPluginAdmin', 'view_input'), // callable $callback,
			self::SETTING_NAME,
			self::SETTING_SECTION_NAME,
			array(
				'label_for' => self::SETTING_FIELD_NAME,
				'class' => 'wwup_text_area_css_class'
			)
		);
	}
	
}

}
