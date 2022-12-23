<?php
// check that the script was not directly called
if (defined('WP_UNINSTALL_PLUGIN')) {
	// remove the option of the plugin
	delete_option('wwup_call_to_action_option');
}
