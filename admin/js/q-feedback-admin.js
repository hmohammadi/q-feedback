(function ($) {
    'use strict';

    $(document).ready(function () {
        $('#feedback_optionsgeneral, #feedback_optionsidea, #feedback_optionsbug').emojiPicker();
    })

    $(document).on('click', '.qfb_archive', function () {
        var feedbackId = $(this).data('id');
        var feedbackStatus = $(this).data('status');

        // Change the post status
        $.post(ajaxurl, {
            action: 'archive_feedback_action',
            feedback_id: feedbackId,
            feedback_status: feedbackStatus
        }, function (response) {
            // Handle success response
            console.log(response);

            // Reload the page after changing the status
            location.reload();
        });
    });
})(jQuery);