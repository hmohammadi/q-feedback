// import Feedback from '../../node_modules/@betahuhn/feedback-js/srx/feedback.js'
import Feedback, { IS_BROWSER } from '../../node_modules/@betahuhn/feedback-js/src/feedback.js'

(function ($) {
	'use strict';

	$(document).ready(function () {
		$.ajax({
			type: 'post',
			url: ajax_object.ajax_url,
			data: {
				action: 'get_feedback_options',
			},
			success: function (response) {
				response = JSON.parse(response);

				if (response) {
					jQuery.each( response, function( i, val ) {
						if(val === '')
							delete response[i];
					});

					response.primary = hexToRgb(response.primary);
					response.events = true;
					var types = {};

					if(response.general) {
						types.types = {
							text: response.general.replace(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g, ''),
							icon: response.general.match(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g).join(' ')
						}
					}

					if(response.idea) {
						types.idea = {
							text: response.idea.replace(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g, ''),
							icon: response.idea.match(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g).join(' ')
						}
					}

					if(response.bug) {
						types.bug = {
							text: response.bug.replace(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g, ''),
							icon: response.bug.match(/[\uD800-\uDBFF][\uDC00-\uDFFF]/g).join(' ')
						}
					}

					if(response.general || response.idea || response.bug) {
						response.types = types;

						delete response.general;
						delete response.idea;
						delete response.bug;
					}
				} else
					response = ''

				new Feedback(response).renderButton()
			}
		});
	})

	$(document).on('click', '.feedback-item', function () {
		// populate the email field
		if (ajax_object.is_user_logged_in) {
			$('#feedback-email').val(ajax_object.current_user.data.user_email)
		}
	})

	window.addEventListener('feedback-submit', (event) => {
		alert()
		$.ajax({
			type: 'post',
			url: ajax_object.ajax_url,
			data: {
				action: 'save_feedback',
				event: event.detail,
				device: detect_user_device()
			},
			success: function (response) {
				console.log(response);
			}
		});
	})

	function detect_user_device() {
		// Get user agent string
		var userAgent = navigator.userAgent;

		// Detect device name and OS version
		var deviceName = 'Unknown';
		var deviceOSVersion = 'Unknown';

		if (/Android/i.test(userAgent)) {
			deviceName = 'Android';
			var match = /Android\s([\d\.]+)/.exec(userAgent);
			if (match !== null) {
				deviceOSVersion = match[1];
			}
		} else if (/webOS/i.test(userAgent)) {
			deviceName = 'webOS';
		} else if (/iPhone|iPad|iPod/i.test(userAgent)) {
			deviceName = 'iOS';
			var match = /OS\s([\d_]+)/.exec(userAgent);
			if (match !== null) {
				deviceOSVersion = match[1].replace(/_/g, '.');
			}
		} else if (/Windows Phone/i.test(userAgent)) {
			deviceName = 'Windows Phone';
			var match = /Windows Phone\s([\d\.]+)/.exec(userAgent);
			if (match !== null) {
				deviceOSVersion = match[1];
			}
		} else if (/Macintosh|Mac OS X/i.test(userAgent)) {
			deviceName = 'MacOS';
			var match = /Mac OS X\s([\d_]+)/.exec(userAgent);
			if (match !== null) {
				deviceOSVersion = match[1].replace(/_/g, '.');
			}
		} else if (/Windows NT/i.test(userAgent)) {
			deviceName = 'Windows';
			var match = /Windows NT\s([\d\.]+)/.exec(userAgent);
			if (match !== null) {
				deviceOSVersion = match[1];
			}
		} else if (/Linux/i.test(userAgent)) {
			deviceName = 'Linux';
		}

		// Detect browser name and version
		var browserName = 'Unknown';
		var browserVersion = 'Unknown';

		if (/MSIE|Trident/i.test(userAgent)) {
			browserName = 'Internet Explorer';
			var match = /MSIE (\d+\.\d+);/.exec(userAgent);
			if (match !== null) {
				browserVersion = match[1];
			}
		} else if (/Edge/i.test(userAgent)) {
			browserName = 'Microsoft Edge';
			var match = /Edge\/(\d+\.\d+)/.exec(userAgent);
			if (match !== null) {
				browserVersion = match[1];
			}
		} else if (/Firefox/i.test(userAgent)) {
			browserName = 'Firefox';
			var match = /Firefox\/(\d+\.\d+)/.exec(userAgent);
			if (match !== null) {
				browserVersion = match[1];
			}
		} else if (/Chrome/i.test(userAgent)) {
			browserName = 'Chrome';
			var match = /Chrome\/(\d+\.\d+)/.exec(userAgent);
			if (match !== null) {
				browserVersion = match[1];
			}
		} else if (/Safari/i.test(userAgent)) {
			browserName = 'Safari';
			var match = /Version\/(\d+\.\d+)/.exec(userAgent);
			if (match !== null) {
				browserVersion = match[1];
			}
		} else if (/Opera|OPR/i.test(userAgent)) {
			browserName = 'Opera';
			var match = /(?:Opera|OPR)\/(\d+\.\d+)/.exec(userAgent);
			if (match !== null) {
				browserVersion = match[1];
			}
		}

		return `${deviceName} ${deviceOSVersion}, ${browserName} ${browserVersion}`
	}

	// Function to convert hex color to RGB
	function hexToRgb(hex) {
		// Remove '#' if present
		hex = hex.replace('#', '');

		// Convert to RGB
		var r = parseInt(hex.substring(0, 2), 16);
		var g = parseInt(hex.substring(2, 4), 16);
		var b = parseInt(hex.substring(4, 6), 16);

		return 'rgb(' + r + ', ' + g + ', ' + b + ')';
	}
})(jQuery);