<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/hmohammadi/q-feedback
 * @since             1.0.0
 * @package           Q_Feedback
 *
 * @wordpress-plugin
 * Plugin Name:       QFeedback
 * Plugin URI:        https://github.com/hmohammadi/q-feedback
 * Description:       Simple modern feedback modal for WordPress.
 * Version:           1.0.0
 * Author:            Hesam Mohammadi
 * Author URI:        https://github.com/hmohammadi
 * License:           MIT
 * License URI:       https://github.com/hmohammadi/q-feedback?tab=MIT-1-ov-file
 * Text Domain:       q-feedback
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'QFEEDBACK_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_q_feedback() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-q-feedback-activator.php';
	Q_Feedback_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_q_feedback' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-q-feedback.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_q_feedback() {

	$plugin = new Q_Feedback();
	$plugin->run();

}
run_q_feedback();
