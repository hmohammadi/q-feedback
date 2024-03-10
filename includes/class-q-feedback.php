<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/hmohammadi/q-feedback
 * @since      1.0.0
 *
 * @package    Q_Feedback
 * @subpackage Q_Feedback/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Q_Feedback
 * @subpackage Q_Feedback/includes
 * @author     Hesam Mohammadi <hesam.m728@hotmail.com>
 */
class Q_Feedback {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Q_Feedback_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $Q_Feedback    The string used to uniquely identify this plugin.
	 */
	protected $Q_Feedback;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'QFEEDBACK_VERSION' ) ) {
			$this->version = QFEEDBACK_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->Q_Feedback = 'QFeedback';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Q_Feedback_Loader. Orchestrates the hooks of the plugin.
	 * - Q_Feedback_i18n. Defines internationalization functionality.
	 * - Q_Feedback_Admin. Defines all hooks for the admin area.
	 * - Q_Feedback_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-q-feedback-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-q-feedback-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-q-feedback-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-q-feedback-public.php';
		
		$this->loader = new Q_Feedback_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Q_Feedback_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Q_Feedback_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Q_Feedback_Admin( $this->get_Q_Feedback(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_cpt', 0 );
		$this->loader->add_action( 'init', $plugin_admin, 'customize_custom_post_statuses' );
		$this->loader->add_action( 'manage_posts_custom_column', $plugin_admin, 'action_custom_columns_content', 10, 2 );
		$this->loader->add_action( 'wp_ajax_archive_feedback_action', $plugin_admin, 'archive_feedback_action' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'display_status_change_notice' );

		$this->loader->add_filter( 'manage_q_feedback_posts_columns', $plugin_admin, 'filter_cpt_columns' );
		$this->loader->add_filter( 'post_row_actions', $plugin_admin, 'action_custom_action_row', 10, 2 );
		$this->loader->add_filter( 'pre_get_posts', $plugin_admin, 'show_custom_statuses_in_admin_filter' );
		$this->loader->add_filter( 'manage_edit-q_feedback_sortable_columns', $plugin_admin, 'cpt_custom_columns_sortable' );
		$this->loader->add_filter( 'views_edit-q_feedback', $plugin_admin, 'show_all_statuses_on_all_posts_screen' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Q_Feedback_Public( $this->get_Q_Feedback(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_save_feedback', $plugin_public, 'save_feedback_callback' );
		$this->loader->add_action( 'wp_ajax_get_feedback_options', $plugin_public, 'get_feedback_options' );

		$this->loader->add_filter( 'script_loader_tag', $plugin_public, 'add_type_attribute', 10, 3 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_Q_Feedback() {
		return $this->Q_Feedback;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Q_Feedback_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
