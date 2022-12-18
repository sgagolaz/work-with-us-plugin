<?php

class WorkWithUsPlugin {
	
	const ACTIVATING_TAG='governo';
	// to apply the plugin to ilpost.it, the following constant should set
	// to 'singleBody'
	const CONTENT_IDENTIFIER='singleBody';
	
	const JAVASCRIPT_IDENITFIER='wwup-call_to_action';
	
	
	/**
	 * It simply returns the ACTIVATING_TAG. Such constant
	 * is not directly used, so that it may be 
	 * customized by users in future.
	 * 
	 * @return	string
	 */
	public static function get_activating_tag() : string {
		return self::ACTIVATING_TAG;
	}
	
	/**
	 * Similarly to get_activating_tag, it is a wrapper of
	 * CONTENT_IDENTIFIER constant for future customizations.
	 * 
	 * @return	string
	 */
	public static function get_content_identifier() : string {
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
	

	public static function append_call_to_action(string $content) {    
		if ( is_singular() && in_the_loop() && is_main_query() && has_tag(self::get_activating_tag()) ) {
			// add the call-to-action to content
			return self::manipulate_content($content);
		}
		return $content;
	}
	
	public static function plugin_activation() : void {
		# Do nothing, so far
	}
	
	public static function plugin_deactivation() : void {
		# Do nothing, so far
	}
	
	/**
	 * Echo a view file
	 * 
	 * @param	string	page	name of the php file inside views directory to be displayed.
	 * @param	array	args	Associative array defining values of variables used iniside view's php file.
	 */
	public static function view(string $page, array $args = array()) : void {
		
		foreach ( $args AS $key => $val ) {
			$$key = $val;
		}
		
		include WORK_WITH_US_PLUGIN_DIR."/views/$page.php";
	}
	
	/**
	 * Just as view method, but it returns the view instead of echoing it
	 * 
	 * @param	string	page name of the php file inside views directory to be displayed.
	 * @param	array	args	Associative array defining values of variables used iniside view's php file.
	 * 
	 * @return	string
	 */
	public static function load_view(string $page, array $args = array()) : string {
		
		foreach ( $args AS $key => $val ) {
			$$key = $val;
		}
		
		ob_start();
		require WORK_WITH_US_PLUGIN_DIR."/views/$page.php";
		return ob_get_clean();
	}
	
	/**
	 * Insert the call-to-action inside the content and return it back.
	 * 
	 * @param	string	content	 The content of a post
	 * 
	 * @return	string
	 */
	// // public static function manipulate_content(string $content) : string {
	// // 	$found = preg_match_all('/'.preg_quote($search).'/', $subject, $matches, PREG_OFFSET_CAPTURE);
	// // 	if (false !== $found && $found > $nth) {
	// // 		return substr_replace($subject, $replace, $matches[0][$nth][1], strlen($search));
	// // 	}
	// // 	return $subject;
	// // }
	public static function manipulate_content(string $content) : string {
		$regex = "/(<p.*<\/p>)/i";
		
		// split articles by paragraphs
		$splitted_by_paragraphs = 
			preg_split(
				$regex, $content, 5, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
			);
		
		$length = count($splitted_by_paragraphs);
		
		// shift content after thr 4th paragraph
		$splitted_by_paragraphs[$length] = $splitted_by_paragraphs[$length-1];
		// put the box after the 4th paragraph
		$splitted_by_paragraphs[$length-1] = self::retrieve_call_to_action_html();
		
		// return the array back to string
		return implode('', $splitted_by_paragraphs);
	}
	
	/**
	 * Get the call-to-string wrapped in a div
	 * 
	 * @return string
	 */
	public static function retrieve_call_to_action_html() : string {
		$wwup_call_to_action_content= file_get_contents(WORK_WITH_US_PLUGIN_DIR.'/views/default.php');
		return self::load_view(
			'call-to-action', 
			[ 'content' => $wwup_call_to_action_content ]
		);
	}
}
