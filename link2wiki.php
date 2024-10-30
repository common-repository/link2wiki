<?php
/*
Plugin Name:百科链接
Plugin URI: http://www.hudong.com
Description: 为选中的文字添加链接到维基百科和互动百科，方便浏览者了解背景知识。 
Version: 1.0 
Author: 互动百科
Author URI: http://www.hudong.com
*/
function bk_addbuttons() {
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "add_bk_tinymce_plugin", 5);
		add_filter('mce_buttons', 'register_bk_button', 5);
	}
}

function register_bk_button($buttons) {
	array_push($buttons, "separator", "bk");
	return $buttons;
}

function add_bk_tinymce_plugin($plugin_array) {
	if(substr(__FILE__,-24,10)=='mu-plugins'){
		$plugin_array['bk'] = get_option('siteurl').'/wp-content/mu-plugins/editor_plugin.js';
	}else{
		$plugin_array['bk'] = get_option('siteurl').'/wp-content/plugins/link2wiki/editor_plugin.js';
	}
	return $plugin_array;
}

function bk_mce_valid_elements($init) {
	if ( isset( $init['extended_valid_elements'] ) 
	&& ! empty( $init['extended_valid_elements'] ) ) {
		$init['extended_valid_elements'] .= ',' . 'pre[lang|line|escaped]';
	} else {
		$init['extended_valid_elements'] = 'pre[lang|line|escaped]';
	}
	return $init;
}

function bk_change_tinymce_version($version) {
	return ++$version;
}

add_filter('tiny_mce_before_init', 'bk_mce_valid_elements', 0);
add_filter('tiny_mce_version', 'bk_change_tinymce_version');
add_action('init', 'bk_addbuttons');

?>