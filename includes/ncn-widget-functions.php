<?php
/**
 * NCN Widget Functions
 *
 * Widget related functions and widget registration.
 *
 * @author 		NAMNCN
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Widgets.
 *
 * @since 1.0.0
 */
function ncn_register_widgets() {
	register_widget( 'NCN_Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'ncn_register_widgets' );