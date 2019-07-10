<?php


namespace BeansWoo\Admin\Setting;

use BeansWoo\Helper;

class Block {
	public static function render_settings_page(){
		if ( isset( $_GET['reset_beans'] ) ) {
			if ( Helper::resetSetup() ) {
				return wp_redirect( admin_url( 'admin.php?page=beans-woo-settings' ) );
			}
		}
		return include __DIR__ . '/block.info.php';
	}
}