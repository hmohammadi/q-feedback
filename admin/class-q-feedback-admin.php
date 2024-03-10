<?php
require __DIR__ . '/../vendor/autoload.php';

use Jeffreyvr\WPSettings\WPSettings;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/hmohammadi/q-feedback
 * @since      1.0.0
 *
 * @package    Q_Feedback
 * @subpackage Q_Feedback/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Q_Feedback
 * @subpackage Q_Feedback/admin
 * @author     Hesam Mohammadi <hesam.m728@hotmail.com>
 */
class Q_Feedback_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->register_feedback_settings_page();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style('jquery-emoji-picker', plugin_dir_url(__FILE__) . 'css/jquery.emojipicker.css', array(), $this->version, 'all');
		wp_enqueue_style('jquery-emoji-picker-data', plugin_dir_url(__FILE__) . 'css/jquery.emojipicker.tw.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/q-feedback-admin.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script('jquery-emoji-picker', plugin_dir_url(__FILE__) . 'js/jquery.emojipicker.js', array('jquery'), $this->version, false);
		wp_enqueue_script('jquery-emoji-picker-data', plugin_dir_url(__FILE__) . 'js/jquery.emojis.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/q-feedback-admin.js', array('jquery'), $this->version, false);

	}

	// Register Custom Post Type
	function register_cpt()
	{

		$labels = array(
			'name'                  => _x($this->plugin_name, 'Post Type General Name', 'q_feedback'),
			'singular_name'         => _x($this->plugin_name, 'Post Type Singular Name', 'q_feedback'),
			'menu_name'             => __($this->plugin_name, 'q_feedback'),
			'name_admin_bar'        => __($this->plugin_name, 'q_feedback'),
			'archives'              => __('Item Archives', 'q_feedback'),
			'attributes'            => __('Item Attributes', 'q_feedback'),
			'parent_item_colon'     => __('Parent Item:', 'q_feedback'),
			'all_items'             => __('Feedbacks', 'q_feedback'),
			'add_new_item'          => __('Add New Item', 'q_feedback'),
			'add_new'               => __('Add New', 'q_feedback'),
			'new_item'              => __('New Item', 'q_feedback'),
			'edit_item'             => __('Edit Item', 'q_feedback'),
			'update_item'           => __('Update Item', 'q_feedback'),
			'view_item'             => __('View Item', 'q_feedback'),
			'view_items'            => __('View Items', 'q_feedback'),
			'search_items'          => __('Search Item', 'q_feedback'),
			'not_found'             => __('Not found', 'q_feedback'),
			'not_found_in_trash'    => __('Not found in Trash', 'q_feedback'),
			'featured_image'        => __('Featured Image', 'q_feedback'),
			'set_featured_image'    => __('Set featured image', 'q_feedback'),
			'remove_featured_image' => __('Remove featured image', 'q_feedback'),
			'use_featured_image'    => __('Use as featured image', 'q_feedback'),
			'insert_into_item'      => __('Insert into item', 'q_feedback'),
			'uploaded_to_this_item' => __('Uploaded to this item', 'q_feedback'),
			'items_list'            => __('Items list', 'q_feedback'),
			'items_list_navigation' => __('Items list navigation', 'q_feedback'),
			'filter_items_list'     => __('Filter items list', 'q_feedback'),
		);

		$args = array(
			'label'                 => __($this->plugin_name, 'q_feedback'),
			'description'           => __('Post Type Description', 'q_feedback'),
			'labels'                => $labels,
			'supports'              => array('title'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 25,
			'menu_icon'             => 'dashicons-feedback',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'capabilities' 			=> array(
				'create_posts' 	=> false, // Removes support for the "Add New" function ( use 'do_not_allow' instead of false for multisite set ups )
			),
			'map_meta_cap' 			=> false, // Set to `false`, if users are not allowed to edit/delete existing posts
			'show_in_rest'          => true,
		);

		register_post_type('q_feedback', $args);

	}

	function filter_cpt_columns($columns)
	{

		unset($columns['title']);
		unset($columns['date']);

		// this will add the column to the end of the array
		$columns['feedback_text'] 	= 'Feedback';
		$columns['type'] 			= 'Type';
		$columns['user'] 			= 'User';
		$columns['device'] 			= 'Device';
		$columns['page'] 			= 'Page';
		$columns['archived'] 		= 'Archived';
		$columns['create_date'] 	= 'Date';

		return $columns;

	}

	function action_custom_columns_content($column_id, $post_id)
	{

		switch ($column_id) {
			case 'feedback_text':
				echo ($value = get_post_meta($post_id, 'qfb_feedback_text', true)) ? $value : 'No feedback Given';
				break;
			case 'type':
				echo ($value = get_post_meta($post_id, 'qfb_type', true)) ? ucfirst($value) : 'No Type Given';
				break;
			case 'user':
				echo ($value = get_post_meta($post_id, 'qfb_user', true)) ? $value : 'No user Given';
				break;
			case 'device':
				echo ($value = get_post_meta($post_id, 'qfb_device', true)) ? $value : 'No device Given';
				break;
			case 'page':
				$page_url = get_post_meta($post_id, 'qfb_page', true);
				echo $value = '<a href="' . esc_url($page_url) . '" target="_blank">' . esc_url($page_url) . '</a>';
				break;
			case 'archived':
				echo ($value = get_post_meta($post_id, 'qfb_archived', true)) ? 'Yes' : 'No';
				break;
			case 'create_date':
				echo ($value = get_the_time(get_option('date_format'), $post_id) . '<br>' . get_the_time(get_option('time_format'), $post_id)) ? $value : 'N/A';
				break;
		}

	}

	function action_custom_action_row($actions, $post)
	{

		if ($post->post_type == "q_feedback") {
			$feedback_status = $post->post_status;
			$archive_label = $feedback_status == 'archive' ? 'Restore' : 'Archive';

			$actions['archive'] = '<a href="#" style="color: #b32d2e;" class="qfb_archive" data-status="' . $feedback_status . '" data-id="' . $post->ID . '">' . $archive_label . '</a>';
			$actions['reply'] 	= '<a href="mailto:user@mail.com?subject=Re%3A%20Your%20feedback&amp;body=%3E%20This%20is%20what%20your%20customer%20feedback%20will%20look%20like%20once%20you%20integrate%20the%20widget%20into%20your%20website!%20Why%20don\'t%20you%20try%20clicking%20\'Reply%20with%20Mail\'%20below%20and%20sending%20me%20an%20email%3F%0D%0A%0D%0A">Reply with Mail</a>';

			unset($actions['view']);
		}

		return $actions;
	}

	function show_custom_statuses_in_admin_filter($query)
	{

		global $post_type;

		// Replace 'your_custom_post_type' with the actual slug of your custom post type
		$your_custom_post_type = 'q_feedback';

		if (is_admin() && $post_type == $your_custom_post_type && $query->is_main_query() && !isset($_GET['post_status'])) {
			// Get all registered post statuses for the custom post type
			$custom_statuses = get_post_stati(array('show_in_admin_status_list' => true), 'objects', 'or');

			unset($custom_statuses['archive']);

			// Include custom statuses in the "All" filter
			$query->set('post_status', array_keys($custom_statuses));
		}

	}

	function include_custom_statuses_in_admin_filter($views)
	{

		global $post_type, $wpdb;

		$your_custom_post_type = 'q_feedback';
		// Replace 'excluded_status' with the slug of the status you want to exclude
		$excluded_status = 'archive';

		if ($post_type == $your_custom_post_type) {
			// Get the count of all posts without the excluded status
			$count = $wpdb->get_var($wpdb->prepare(
				"SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = %s AND post_status != %s",
				$your_custom_post_type,
				$excluded_status
			));

			// Replace the count for 'All' filter
			$views['all'] = sprintf(
				'<a href="%s"%s>%s <span class="count">(%s)</span></a>',
				admin_url("edit.php?post_type=$your_custom_post_type"),
				(empty($_GET['post_status']) && !$views['trash'] ? ' class="current"' : ''),
				__('All'),
				number_format_i18n($count)
			);
		}

		return $views;

	}

	// Make Custom Post Type Custom Columns Sortable
	function cpt_custom_columns_sortable($columns)
	{

		$columns['type'] 			= 'type';
		$columns['user'] 			= 'user';
		$columns['device'] 			= 'device';
		$columns['page'] 			= 'page';
		$columns['archived'] 		= 'archived';
		$columns['create_date'] 	= 'created_date';

		return $columns;

	}

	function customize_custom_post_statuses()
	{

		register_post_status('general', array(
			'label'                     => _x('General', 'q_feedback'),
			'public'                    => false,
			'exclude_from_search'       => false,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop('General <span class="count">(%s)</span>', 'General <span class="count">(%s)</span>'),
		));

		register_post_status('idea', array(
			'label'                     => _x('Idea', 'q_feedback'),
			'public'                    => false,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop('Idea <span class="count">(%s)</span>', 'Idea <span class="count">(%s)</span>'),
		));

		register_post_status('bug', array(
			'label'                     => _x('Bug', 'q_feedback'),
			'public'                    => false,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop('Bug <span class="count">(%s)</span>', 'Bug <span class="count">(%s)</span>'),
		));

		register_post_status('archive', array(
			'label'                     => _x('Archive', 'q_feedback'),
			'public'                    => false,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop('Archive <span class="count">(%s)</span>', 'Archive <span class="count">(%s)</span>'),
		));

		// Hide default post stauses
		register_post_status('publish', array(
			'public'                    => true,
			'show_in_admin_status_list' => false,
		));

		register_post_status('draft', array(
			'public'                    => true,
			'show_in_admin_status_list' => false,
		));

		register_post_status('future', array(
			'public'                    => true,
			'show_in_admin_status_list' => false,
		));

		register_post_status('pending', array(
			'public'                    => true,
			'show_in_admin_status_list' => false,
		));

		register_post_status('private', array(
			'public'                    => true,
			'show_in_admin_status_list' => false,
		));

		register_post_status('trash', array(
			'public'                    => true,
			'show_in_admin_status_list' => false,
		));

	}

	function show_all_statuses_on_all_posts_screen($views)
	{

		// Replace 'custom_item' with your custom post type
		$post_type = 'q_feedback';

		// Get all registered post statuses for the custom post type
		$custom_statuses = get_post_stati(array('show_in_admin_status_list' => true), 'objects', 'or');

		foreach ($custom_statuses as $status => $status_object) {
			// Count posts with the specific status even if count is zero
			$count = wp_count_posts($post_type)->$status;
			$class = ($status === 'publish') ? ' class="current"' : '';

			// Include the status link in the views
			$views["$status"] = "<a href='edit.php?post_type=$post_type&post_status=$status'$class>" . sprintf(__('%s <span class="count">(%s)</span>', 'custom_item'), $status_object->label, number_format_i18n($count)) . '</a>';
		}

		return $views;

	}

	function archive_feedback_action()
	{

		if (isset($_POST['feedback_id'])) {
			$feedback_id 		= intval($_POST['feedback_id']);
			$feedback_status 	= sanitize_text_field($_POST['feedback_status']);

			if ($feedback_status == 'archive') {
				$type = get_post_meta($feedback_id, 'qfb_type', true);

				wp_update_post(array('ID' => $feedback_id, 'post_status' => $type));
				update_post_meta($feedback_id, 'qfb_archived', 0);
			} else {
				wp_update_post(array('ID' => $feedback_id, 'post_status' => 'archive'));
				update_post_meta($feedback_id, 'qfb_archived', 1);
			}

			// Output a success message
			$notice = __('Feedback ' . $feedback_status . 'd successfully!', 'q_feedback');

			// Save the notice in a session variable
			set_transient('status_change_notice', $notice, 5); // Adjust the timeout as needed
		}

		die();

	}

	function register_feedback_settings_page()
	{

		$settings = new WPSettings(__('Feedback Options', 'q_feedback'));

		$settings->set_menu_parent_slug('edit.php?post_type=q_feedback');

		$general_tab = $settings->add_tab(__('General', 'q_feedback'));
		$types_tab = $settings->add_tab(__('Types', 'q_feedback'));

		$gerneral = $general_tab->add_section('General');
		$types = $types_tab->add_section('types');

		$gerneral->add_option('checkbox', [
			'name' => 'emailField',
			'label' => __('Email Field', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'btnTitle',
			'label' => __('Button Title', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'title',
			'label' => __('Title', 'q_feedback')
		]);

		$gerneral->add_option('textarea', [
			'name' => 'inputPlaceholder',
			'label' => __('Input Placeholder', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'emailPlaceholder',
			'label' => __('Email Placeholder', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'submitText',
			'label' => __('Submit Text', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'backText',
			'label' => __('Back Text', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'typeMessage',
			'label' => __('Type Message', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'success',
			'label' => __('Success Message', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'failedTitle',
			'label' => __('Failed Title', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'failedMessage',
			'label' => __('Failed Message', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'contactText',
			'label' => __('Contact Text', 'q_feedback')
		]);

		$gerneral->add_option('text', [
			'name' => 'contactLink',
			'label' => __('Contact Link', 'q_feedback')
		]);

		$gerneral->add_option('select', [
			'name' => 'position',
			'label' => __('Button Position', 'q_feedback'),
			'options' => [
				'right' => 'Right',
				'left' => 'Left'
			]
		]);

		$gerneral->add_option('color', [
			'name' => 'primary',
			'label' => __('Primary Color', 'q_feedback')
		]);

		$gerneral->add_option('color', [
			'name' => 'background',
			'label' => __('Background Color', 'q_feedback')
		]);

		$gerneral->add_option('color', [
			'name' => 'color',
			'label' => __('Font Color', 'q_feedback')
		]);

		$types->add_option('text', [
			'name' => 'general',
			'label' => __('General', 'q_feedback')
		]);

		$types->add_option('text', [
			'name' => 'idea',
			'label' => __('Idea', 'q_feedback')
		]);

		$types->add_option('text', [
			'name' => 'bug',
			'label' => __('Bug', 'q_feedback')
		]);

		$settings->make();

	}

	function display_status_change_notice()
	{

		if ($notice = get_transient('status_change_notice')) {
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html($notice) . '</p></div>';
			// Delete the transient to prevent displaying the notice on subsequent page loads
			delete_transient('status_change_notice');
		}

	}
}
