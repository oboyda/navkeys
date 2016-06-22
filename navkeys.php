<?php
/*
Plugin Name: NavKeys
Description: This plugin makes possible to navigate website using keyboard keys thus complying with accesibility requirements.
Version:     1.0
Author:      Oleksiy Boyda
License:     GPL2
Domain Path: /languages
Text Domain: nvk
*/

add_action('after_setup_theme', 'nvk_set_lang');
function nvk_set_lang(){
	if(defined('ICL_LANGUAGE_CODE')){
		return define('NVK_LANG', '_' . ICL_LANGUAGE_CODE);
	}
	return define('NVK_LANG', '_' . substr(get_locale(), 0, 2));
}

add_action('plugins_loaded', 'nvk_load_textomain');
function nvk_load_textomain(){
	load_plugin_textdomain('nvk', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

add_action('admin_enqueue_scripts', 'nvk_enqueue_admin_scripts');
function nvk_enqueue_admin_scripts($hook){
	if($hook != 'settings_page_nvk-settings'){
		return;
	}
	wp_enqueue_script('nvk-admin-js', plugins_url('/admin.js', __FILE__), array('jquery'));
}

require(dirname(__FILE__) . '/helpers.php');
require(dirname(__FILE__) . '/admin-actions.php');
require(dirname(__FILE__) . '/admin.php');
require(dirname(__FILE__) . '/front.php');
