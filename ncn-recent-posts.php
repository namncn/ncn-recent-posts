<?php
/**
 * Plugin Name: NCN: Recent Posts
 * Plugin URI: http://namncn.com/plugins/ncn-recent-posts/
 * Author: Nam NCN
 * Author URI: http://namncn.com/about/
 * Version: 1.0.0
 * Description: Show recent posts using widget.
 * Tags:
 * Text Domain: namncn
 * Domain Path: /languages/
 *
 * @package NAMNCN
 */

final class NCNRP {
	public function __construct() {
		$this->define_constants();
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Define NCNRP constants.
	 */
	private function define_constants() {
		$this->define( 'NCN_DIR_PATH', plugin_dir_path( __FILE__ ) );
		$this->define( 'NCN_DIR_URI', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Define Constant if not already set.
	 * 
	 * @param string      $name  Constant
	 * @param string|bool $value //
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Set up localisation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'namncn', false, NCN_DIR_PATH . 'languages/' );
	}

	/**
	 * Require files.
	 */
	public function plugins_loaded() {
		require_once NCN_DIR_PATH . 'includes/abstract/abstract-ncn-widget.php';
		require_once NCN_DIR_PATH . 'includes/widgets/class-ncn-recent-posts-widget.php';
		require_once NCN_DIR_PATH . 'includes/ncn-widget-functions.php';
	}

	/**
	 * Enqueue styles and scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'fontawesome', NCN_DIR_URI . 'assets/css/font-awesome.min.css', array(), '4.6.3' );
		wp_enqueue_style( 'ncn-recent-posts-style', NCN_DIR_URI . 'assets/css/style.css', array(), '1.0.0' );
	}
}
new NCNRP();
