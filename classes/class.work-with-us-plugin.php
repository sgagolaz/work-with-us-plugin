<?php

class WorkWithUsPlugin {
	
	const ACTIVATING_TAG='governo';
	// to apply the plugin to ilpost.it, the following constant should set
	// to 'singleBody'
	const CONTENT_IDENTIFIER='singleBody';
	
	const JAVASCRIPT_IDENITFIER='wwup-call_to_action';
	
	
	/*
	 * It simply returns the ACTIVATING_TAG. Such constant
	 * is not directly used, so that it may be 
	 * customized by users in future.
	 */
	public static function get_activating_tag() : string {
		return self::ACTIVATING_TAG;
	}
	
	/*
	 * Similarly to get_activating_tag, it is a wrapper of
	 * CONTENT_IDENTIFIER constant for future customizations.
	 */
	public static function get_content_identifier() {
		return CONTENT_IDENTIFIER;
	}
	
	/**
	 * init function. It checks if it has been called from a single
	 * post with the activating tag and call the appending function
	 */
	public static function init() : void {
		// Register the js script that does the magic
		wp_register_script(
			self::JAVASCRIPT_IDENITFIER, 
			WORK_WITH_US_PLUGIN_DIR."/assets/js/WwupCallToAction.class.js"
		);
		
// 		if (have_post(){
// 			the_post();
// 			if (has_tag(get_activating_tag())) {
// 				wp_enqueue_script(self::JAVASCRIPT_IDENITFIER);
// 				
// 			}
// 		}
		
		add_filter( 'the_content', array('WorkWithUsPlugin','append_call_to_action'), 1);

		
				
	}
	

	public static function append_call_to_action( $content) {    
		if ( is_singular() && in_the_loop() && is_main_query() && has_tag(self::get_activating_tag()) ) {
			$call_to_action_html=file_get_contents(WORK_WITH_US_PLUGIN_DIR.'/views/default.php');
			return $content.$call_to_action_html;
		}
		return $content;
	}
	
	public static function plugin_activation() : void {
		# Do nothing, so far
	}
	
	public static function plugin_deactivation() : void {
		# Do nothing, so far
	}
	
	
	public static function view($page) : void {
		include WORK_WITH_US_PLUGIN_DIR."/views/$page.php";
	}
	
}
