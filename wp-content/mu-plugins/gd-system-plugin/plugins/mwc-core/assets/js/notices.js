jQuery(function($) {
	var params = MWCNotices;

	$(document.body).on('click', '.notice.is-dismissible .notice-dismiss', function() {
		var messageId = $(this).closest('.notice').data('message-id');

		if (! messageId) {
			return;
		}

		$.ajax({
			url: ajaxurl,
			data: {
				action: params.dismissNoticeAction,
				messageId: messageId
			}
		});
	});
});
