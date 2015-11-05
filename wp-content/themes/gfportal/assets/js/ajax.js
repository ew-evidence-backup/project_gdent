// debug no redirect
function no_redirect() {
	return $('#debug .no-redirect').prop('checked');
}

// fulfillment tracker
function fulfillment_1_tracker(element, value) {
	var row = element.parent().parent().parent('.row');
	switch(value) {
		case 'Not Started':

			break;
		case 'In Progress':

			break;
		case 'Completed':
			row.addClass('done');
			element.html('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span><strong>Completed</strong>');
			break;
	}
}

function add_resident_agent(response, data) {
	var data = {
		'object': $(data).data('sforce-object'),
		'fields': {
			'sforce_contact_id'	: wp_ajax.sforce_contact_id,
			'sforce_account_id'	: wp_ajax.sforce_account_id
		}
	};

	// resident agent doesn't exist
	if(typeof response.SalesForce[0] === 'undefined') {
		$.Portal('add-object', data);
	}
}

// load & save data
(function($) {
	$.Portal('load-page');

	// watch all inputs for change
	var changed_elements = [];
	$('.watch').change(function() {
		if($(this).is('input')) {
			switch($(this).attr('type')) {
				case 'text':
					changed_elements.push($(this));
					break;
				case 'radio':
					if(this.checked) {
						if(typeof $(this).data('sforce-field') !== "undefined") {
							$(this).val($(this).data('radio-backup'));
							var radio_sender = $(this);
						} else {
							$(this).closest('.radio').parent().find('.sforce[type=radio][data-sforce-field]').val($(this).val());
							var radio_sender = $(this).closest('.radio').parent().find('.sforce[data-sforce-field]');
						}

						$.each(changed_elements, function(key, value) {
							if($(value).data('sforce-field') == $(radio_sender).data('sforce-field')) {
								changed_elements.splice(key, 1 );
							}
						});

						changed_elements.push(radio_sender);
					}

					break;
			}
		} else if($(this).is('div')) {
			// stub for later
		}
	});

	$('.btn[data-action]').click(function(event) {
		event.preventDefault();
		var action = $(this).data('action');

		var redirect_url = null;

		if(no_redirect())
			redirect_url = false;
		else
			redirect_url = $(this).attr('href');

		switch(action) {
			case 'save':
				$.Portal('save-page', changed_elements, redirect_url);
				break;
			case 'impersonate':
				$.Portal('edit-user-meta', this);
				break;
		}
	});

	// watch all radio inputs
	$('.sforce[type=radio]').change(function(event) {
		if(this.checked) {
			var all_toggles = [];

			all_toggles = $(this).closest('.radio').siblings('.radio').find('.sforce');

			$.each(all_toggles, function(key, value) {
				$($(value).data('toggle')).addClass('hidden');
			});

			var toggle_element = $(this).data('toggle');

			if($(this).parent().parent().hasClass('answer-horizontal')) {
				$(toggle_element).appendTo($(this).parent().parent().parent());
			} else {
				$(toggle_element).appendTo($(this).parent().parent());
			}

			$(toggle_element).removeClass('hidden');
		}
	});

	// fire all initialization functions
	$.each($('.sforce[data-init-function]'), function(key, value) {
		$.Portal('init-record', value);
	});
}(jQuery));

// file upload
(function($) {
	var data_url = null;
    $('.upload button').click(function(e) {
    	e.preventDefault();

    	$(this).siblings('.sfile').click();
    	$(this).addClass('active-upload');
    });

	$('.sfile').fileupload({
        dataType: 'json',
        send: function (e, data) {
		    $('.active-upload').button('uploading');
		},
		done: function(e, data) {
			$('.active-upload').removeClass('active-upload').button('done');
		},
	});
}(jQuery));