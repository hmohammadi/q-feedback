<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/hmohammadi/q-feedback
 * @since      1.0.0
 *
 * @package    Q_Feedback
 * @subpackage Q_Feedback/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Q_Feedback
 * @subpackage Q_Feedback/public
 * @author     Hesam Mohammadi <hesam.m728@hotmail.com>
 */
class Q_Feedback_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Q_Feedback    The ID of this plugin.
	 */
	private $Q_Feedback;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $Q_Feedback       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $Q_Feedback, $version ) {

		$this->Q_Feedback = $Q_Feedback;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Q_Feedback_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Q_Feedback_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->Q_Feedback, plugin_dir_url( __FILE__ ) . 'css/q-feedback-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Q_Feedback_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Q_Feedback_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$current_user = wp_get_current_user();
    	$is_user_logged_in = is_user_logged_in();

		// wp_enqueue_script( 'feedback-js', plugin_dir_url( __FILE__ ) . 'js/feedback.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->Q_Feedback, plugin_dir_url( __FILE__ ) . 'js/q-feedback-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->Q_Feedback, 'ajax_object', array( 
				'ajax_url' => admin_url('admin-ajax.php'), 
				'post_id' => get_the_ID(),
				'is_user_logged_in' => $is_user_logged_in, 
				'current_user' => $current_user 
			) 
		);

	}

	public function add_type_attribute( $tag, $handle, $src ) {

		// if not your script, do nothing and return original $tag
		if ( $this->Q_Feedback !== $handle ) {
			return $tag;
		}

		// change the script tag by adding type="module" and return it.
		$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
		
		return $tag;

	}

	function save_feedback_callback() {

		$type 		= sanitize_text_field( $_POST['event']['feedbackType'] );
		$post_data 	= array(
			'post_status'   => $type,
			'post_type'     => 'q_feedback',
		);
	
		$post_id = wp_insert_post($post_data);
	
		if (!is_wp_error($post_id)) {
			$id 		= sanitize_text_field( $_POST['event']['id'] );
			$email 		= sanitize_email( $_POST['event']['email'] );
			$url 		= sanitize_url( $_POST['event']['url'] );
			$message 	= sanitize_textarea_field( $_POST['event']['message'] );
			$device 	= sanitize_text_field( $_POST['device'] );

			add_post_meta($post_id, 'qfb_id', $id, true);
			add_post_meta($post_id, 'qfb_user', $email, true);
			add_post_meta($post_id, 'qfb_type', $type, true);
			add_post_meta($post_id, 'qfb_page', $url, true);
			add_post_meta($post_id, 'qfb_feedback_text', $message, true);
			add_post_meta($post_id, 'qfb_device', $device, true);
			add_post_meta($post_id, 'qfb_archived', 0, true);

			echo __('Thank you, your feedback submitted successfully!', 'q_feedback');
		} else {
			echo __('Error submitting feedback: ', 'q_feedback') . $post_id->get_error_message();
		}
	
		exit();

	}

	function get_feedback_options() {

		$feedback_options = get_option('feedback_options');

		echo json_encode($feedback_options);

		exit();

	}

}
