<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/hmohammadi/q-feedback
 * @since      1.0.0
 *
 * @package    Q_Feedback
 * @subpackage Q_Feedback/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Q_Feedback
 * @subpackage Q_Feedback/includes
 * @author     Hesam Mohammadi <hesam.m728@hotmail.com>
 */
class Q_Feedback_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'q_feedback',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
