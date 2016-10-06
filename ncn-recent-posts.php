<?php
/**
 * Plugin Name: NCN: Recent Posts
 * Plugin URI: http://namncn.com/plugins/ncn-recent-posts/
 * Author: Nam NCN
 * Author URI: http://namncn.com/about/
 * Version: 1.0.0
 * Description: Show recent posts.
 * Tags:
 * Text Domain: namncn
 * Domain Path: /languages/
 *
 * @package NAMNCN
 */

define( 'NCN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'NCN_DIR_URI', plugin_dir_url( __FILE__ ) );

load_plugin_textdomain( 'namncn', false, NCN_DIR_PATH . 'languages/' );

/**
 * Require files.
 */
function ncn_plugin_loaded() {
	require_once NCN_DIR_PATH . 'includes/abstract/abstract-ncn-widget.php';
	require_once NCN_DIR_PATH . 'includes/widgets/class-ncn-recent-posts-widget.php';
	require_once NCN_DIR_PATH . 'includes/ncn-widget-functions.php';
}
add_action( 'plugins_loaded', 'ncn_plugin_loaded' );

/**
 * Enqueue styles and scripts.
 */
function ncn_enqueue_scripts() {
	wp_enqueue_style( 'fontawesome', NCN_DIR_URI . 'assets/css/font-awesome.min.css', array(), '4.6.3' );
	wp_enqueue_style( 'ncn-recent-posts-style', NCN_DIR_URI . 'assets/css/style.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'ncn_enqueue_scripts' );
