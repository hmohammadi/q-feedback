<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/hmohammadi/q-feedback
 * @since      1.0.0
 *
 * @package    Q_Feedback
 * @subpackage Q_Feedback/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Q_Feedback
 * @subpackage Q_Feedback/includes
 * @author     Hesam Mohammadi <hesam.m728@hotmail.com>
 */
class Q_Feedback_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$feedback_options = get_option('feedback_options');

		if(!$feedback_options) {
			$q_feedback_options = array(
				'emailField' => "1",
				'events' => true,
				'general' => __('😁 General Feedback', 'q_feedback'),
				'idea' => __('💡 I have an idea', 'q_feedback'),
				'bug' => __('🐞 I found an issue', 'q_feedback'),
				'btnTitle' => __('Feedback', 'q_feedback'),
				'title' => __('Company Feedback', 'q_feedback'),
				'inputPlaceholder' => __('Your feedback goes here!', 'q_feedback'),
				'emailPlaceholder' => __('Email address (optional)', 'q_feedback'),
				'submitText' => __('Submit', 'q_feedback'),
				'backText' => __('Back', 'q_feedback'),
				'contactText' => __('Or send an email!', 'q_feedback'),
				'contactLink' => __('mailto:hello@mail.com', 'q_feedback'),
				'typeMessage' => __('What feedback do you have?', 'q_feedback'),
				'success' => __('Thanks! 👊', 'q_feedback'),
				'failedTitle' => __('Oops, an error ocurred!', 'q_feedback'),
				'failedMessage' => __('Please try again. If this keeps happening, try to send an email instead.', 'q_feedback'),
				'position' => 'right',
				'primary' => '#35de76',
				'background' => '#fff',
				'color' => '#000',
			);

			add_option('feedback_options', $q_feedback_options);
		}

	}

}
