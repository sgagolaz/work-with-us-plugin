<div class='wrap'>
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action='options.php' method='post'>
			<?php
			// output security fields for the registered setting WorkWithUsPluginAdmin::SETTING_NAME.
			// These include a nonce, among other fields.
			settings_fields( WorkWithUsPluginAdmin::SETTING_NAME );
			// output the so-far-only setting section and its so-far-only field
			do_settings_sections( WorkWithUsPluginAdmin::SETTING_NAME );
			// output save settings button
			submit_button( 'Save Settings' );
			?>
	</form>
</div>
