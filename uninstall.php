<?php
// check that the script was not directly called
if (isset(WP_UNINSTALL_PLUGIN)) {
	// remove the only option of the plugin
	delete_option(WorkWithUsPlugin::HTML_OPTION_NAME);
}
