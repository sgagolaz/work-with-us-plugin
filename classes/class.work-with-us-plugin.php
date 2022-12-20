<?php

class WorkWithUsPlugin {
	
	const ACTIVATING_TAG='governo';
	
	const HTML_OPTION_NAME='wwup_call_to_action_option';
	
	const PARAGRAPHS_BEFORE_CTA = 4;
	
	
	/**
	 * It simply returns the ACTIVATING_TAG. Such constant
	 * is not directly used, so that it may be 
	 * customized by users in future.
	 * 
	 * @return	string
	 */
	private static function get_activating_tag() : string {
		return self::ACTIVATING_TAG;
	}

	
	/**
	 * Similarly to get_activating_tag, it is a wrapper of
	 * PARAGRAPHS_BEFORE_CTA constant for future customizations.
	 * 
	 * @return	int
	 */
	private static function get_n_parag_before_cta() : int {
		return self::PARAGRAPHS_BEFORE_CTA;
	}
	
	
	/**
	 * init function. It simply add a filter to hook the_content
	 * to manipulate content of post (if is a one-post page)
	 */
	public static function init() : void {
		add_filter( 'the_content', array('WorkWithUsPlugin','append_call_to_action'), 1);		
	}
	

	/**
	 * It checks if it has been called from a single
	 * post with the activating tag and call the manipulating function
	 * 
	 * @param	string	content	html text to which append the call-to-action
	 * 
	 * @return 	string	the given argument without modifications if it has been called from a page that is not of a single post. Otherwise the given argument, with the call-to-action inserted into.
	 * 
	 */
	public static function append_call_to_action(string $content) : string {    
		if ( is_singular() && in_the_loop() && is_main_query() && has_tag(self::get_activating_tag()) ) {
			// add the call-to-action to content
			return self::manipulate_content($content);
		}
		return $content;
	}
	
	
	/**
	 * retrieve default html code for call_to_action
	 * and save it in DB using add_option
	 */
	public static function plugin_activation() : void {
		// retrieve default html code for call_to_action
		// and save it in DB using add_option
		$default=self::load_view('default');
		add_option(self::HTML_OPTION_NAME, $default);
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
	 * It behaves like view method, but it returns the view instead of echoing it
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
	private static function manipulate_content(string $content) : string {
		$regex = "/(<p.*<\/p>)/i";
		
		// split articles by paragraphs
		$splitted_by_paragraphs = 
			preg_split(
				$regex, $content, 
				self::get_n_parag_before_cta() + 1,
				PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
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
	 * Get the call-to-action html string sanitized and wrapped in a div
	 * 
	 * @return string
	 */
	public static function retrieve_call_to_action_html() : string {
		$content = get_option(self::HTML_OPTION_NAME);
		return wp_kses_post(
			self::load_view(
				'call-to-action', 
				[ 'content' => $content ]
			)
		);
	}
}
