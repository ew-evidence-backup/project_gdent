// portal jQuery plugin
(function($) {
	$.Portal = function(action, data, redirect) {
		switch(action) {
			case 'load-page':
				// show 'Loading' modal
				$('.action-modal-state').html('Loading');
				$('.action-modal-wrapper').show();

				sforce_array	= [];
				sfile_array		= [];

				// 'serialize' all SalesForce fields
				$('.sforce').each(function(index) {
					var item = {};

					item['object']		= $(this).data('sforce-object');
					item['field']		= $(this).data('sforce-field');
					item['filters']		= $(this).data('sforce-json-filters');

					// push if no data is missing
					if(item.object !== undefined && item.field !== undefined && item.filters !== undefined)
						sforce_array.push(item);
				});

				// 'serialize' all ShareFile fields
				$('.sfile').each(function(index) {
					var item = {};

					item['folder']			= $(this).data('sfile-folder');
					item['filename']		= $(this).data('sfile-filename');

					sfile_array.push(item);
				});

				if(sforce_array.length > 0 || sfile_array.length > 0) {
					if(sforce_array.length > 0) {
						var query =
						{
							'SalesForce': sforce_array
						}

						// debug
						$('#debug .panel-body').prepend('<h3>POST ' + wp_ajax.url + '</h3><hr><pre>' + JSON.stringify(query, null, 4) + '</pre>');

						$.ajax({
							type: 	'POST',
							cache: 	false,
							url: 	wp_ajax.url,
							data:
							{
								action		: 'load-page',
								serialized	: query,
								nonce		: wp_ajax.nonce
							},
							complete: function(data)
							{
								// debug
								$('#debug .panel-body').prepend('<h3>load_page_ajax_func()</h3><hr><pre>' + JSON.stringify(data, null, 4) + '</pre>');

								// hide 'Loading' modal
								$('.action-modal-state').html('Done');
								$('.action-modal-wrapper').fadeOut();
							},
							success: function(data)
							{
								// parse SalesForce
								var sforce_data = data.SalesForce;
								$.each(sforce_data, function(object, v) {
									$.each(sforce_data[object], function(field, value) {
										if(field != 'attributes') {
											var element = null;
											// __r child relationship
											if(field.slice(-3) == '__r') {
									    		$.each(sforce_data[object][field], function(key, value) {
									    			if(key != 'attributes') {
														element = $(".sforce[data-sforce-object='" + sforce_data[object].attributes.type + "'][data-sforce-field='" + field + '.' + key + "']");
														element.attr('data-sforce-url', sforce_data[object][field].attributes.url);

														if(element.is('input')) {
															switch(element.attr('type')) {
																case 'text':
																	element.val(value);
																	break;
																case 'radio':
																	var checked = null;

																	if($(".sforce[data-sforce-field='" + field + "']").val() == value) {
																		checked = $(".sforce[data-sforce-field='" + field + "']").prop('checked', true);
																	} else {
																		checked = $(".sforce[data-sforce-field='" + field + "']").closest('.radio').siblings('.radio').find(".sforce[value='" + value + "']").prop('checked', true);
																	}

																	// unhide any child toggles
																	var toggle_element = $(checked).data('toggle');

																	if($(checked).parent().parent().hasClass('answer-horizontal')) {
																		$(toggle_element).appendTo($(checked).parent().parent().parent());
																	} else {
																		$(toggle_element).appendTo($(checked).parent().parent());
																	}

																	$(toggle_element).removeClass('hidden');
																	break;
															}
														} else if(element.is('div')) {
															element.html(value);

															var function_name = element.data('function');
															if(typeof window[function_name] === 'function') {
																window[function_name](element, value);
															}
														}
									    			}
									    		});
											} else {
												element = $(".sforce[data-sforce-object='" + sforce_data[object].attributes.type + "'][data-sforce-field='" + field + "']");
												element.attr('data-sforce-url', sforce_data[object].attributes.url);

												if(element.is('input')) {
													switch(element.attr('type')) {
														case 'text':
															element.val(value);
															break;
														case 'radio':
															var checked = null;

															if($(".sforce[data-sforce-field='" + field + "']").val() == value) {
																checked = $(".sforce[data-sforce-field='" + field + "']").prop('checked', true);
															} else {
																checked = $(".sforce[data-sforce-field='" + field + "']").closest('.radio').siblings('.radio').find(".sforce[value='" + value + "']").prop('checked', true);
															}

															// unhide any child toggles
															var toggle_element = $(checked).data('toggle');

															if($(checked).parent().parent().hasClass('answer-horizontal')) {
																$(toggle_element).appendTo($(checked).parent().parent().parent());
															} else {
																$(toggle_element).appendTo($(checked).parent().parent());
															}

															$(toggle_element).removeClass('hidden');
															break;
													}
												} else if(element.is('div')) {
													element.html(value);

													var function_name = element.data('function');
													if(typeof window[function_name] === 'function') {
														window[function_name](element, value);
													}
												}
											}
										}
									});
								});
							}
						});
					}

					if(sfile_array.length > 0) {
						var query =
						{
							'ShareFile': sfile_array
						}

						// debug
						$('#debug .panel-body').prepend('<h3>POST ' + wp_ajax.url + '</h3><hr><pre>' + JSON.stringify(query, null, 4) + '</pre>');

						$.ajax({
							type: 	'POST',
							cache: 	false,
							url: 	wp_ajax.url,
							data:
							{
								action		: 'load-page',
								serialized	: query,
								nonce		: wp_ajax.nonce
							},
							complete: function(data)
							{
								// debug
								$('#debug .panel-body').prepend('<h3>load_page_ajax_func()</h3><hr><pre>' + JSON.stringify(data, null, 4) + '</pre>');

								// hide 'Loading' modal
								$('.action-modal-state').html('Done');
								$('.action-modal-wrapper').fadeOut();
							},
							success: function(data)
							{
								// parse ShareFile
								var sfile_data = data.ShareFile;
								$.each(sfile_data, function(index, pair) {
									$.each(pair, function(key, value) {
										var element = $(".sfile[data-sfile-filename='" + key + "']");
										element.parent().parent().siblings('.col-md-12').children('.file-list').removeClass('hidden').children('.list-group').append('<li><a class="list-group-item" target="_blank" href="'+ location.protocol + '//' + location.host + '/download/?id=' + value + '">Download File<span class="glyphicon glyphicon-cloud-download pull-right" aria-hidden="true"></span></a></li>');
										element.siblings('button').remove();
									});
								});
							}
						});
					}
				} else {
					// hide 'Loading' modal
					$('.action-modal-state').html('Done');
					$('.action-modal-wrapper').fadeOut();
				}
				break;
			case 'save-page':
		        if(data.length > 0) {
		        	var sforce_array = [];

					// 'serialize' all SalesForce fields
					$(data).each(function(index) {
						item = {};

						if(typeof $(this).data('sforce-url') !== "undefined")
							item['url']		= $(this).data('sforce-url');
						
						item['field']	= $(this).data('sforce-field');
						item['value']	= $(this).val();

						sforce_array.push(item);
					});

					// package it all before sending to handler themes/gfportal/functions/ajax.php
					var query =
					{
						'SalesForce': sforce_array
					}

					// debug
					$('#debug .panel-body').prepend('<h3>POST ' + wp_ajax.url + '</h3><hr><pre>' + JSON.stringify(query, null, 4) + '</pre>');

		        	$('.action-modal-wrapper').fadeIn();
		        	$('.action-modal-state').html('Saving');

					$.ajax({
						type: 	'POST',
						cache: 	false,
						url: 	wp_ajax.url,
						data:
						{
							action		: 'save-page',
							serialized	: query,
							nonce		: wp_ajax.nonce
						},
						complete: function(data)
						{
							$('#debug .panel-body').prepend('<h3>save_page_ajax_func()</h3><hr><pre>' + JSON.stringify(data, null, 4) + '</pre>');

							// hide 'Saving' modal
							$('.action-modal-state').html('Done');
				        	$('.action-modal-wrapper').fadeOut();
						},
						success: function(data)
						{
							if(redirect)
				        		window.location = redirect;
						}
					});
		        } else {
		        	$('#debug .panel-body').prepend("<h3>$.Portal 'data' variable dump</h3><hr><pre>" + JSON.stringify(data, null, 4) + '</pre>');

					if(redirect)
						window.location = redirect;
		        }
				break;
			case 'edit-user-meta':
				var query =
				{
					'data-sforce-contact-id': $(data).data('sforce-contact-id'),
					'data-sforce-account-id': $(data).data('sforce-account-id'),
					'data-sfile-id': $(data).data('sfile-id')
				}

				$.ajax({
					type: 	'POST',
					cache: 	false,
					url: 	wp_ajax.url,
					data:
					{
						action		: 'edit-user-meta',
						serialized	: query,
						nonce		: wp_ajax.nonce
					},
					success: function(data)
					{
						if(data == true) {
							location.reload();
						}
					}
				});

				break;
			case 'init-record':
				var sforce_array = [];
				var item = {};

				item['object']		= $(data).data('sforce-object');
				item['field']		= $(data).data('sforce-field');
				item['filters']		= $(data).data('sforce-json-filters');

				// push if no data is missing
				if(item.object !== undefined && item.field !== undefined && item.filters !== undefined)
					sforce_array.push(item);

				var query =
				{
					'SalesForce': sforce_array
				}

				$.ajax({
					type: 	'POST',
					cache: 	false,
					url: 	wp_ajax.url,
					data:
					{
						action		: 'init-record',
						serialized	: query,
						nonce		: wp_ajax.nonce
					},
					success: function(success_data)
					{
						var function_name = $(data).data('init-handler-function');

						if(typeof window[function_name] === 'function') {
							window[function_name](success_data, data);
						}
					}
				});

				break;
			case 'add-object':
				$.ajax({
					type: 	'POST',
					cache: 	false,
					url: 	wp_ajax.url,
					data:
					{
						action		: 'add-object',
						serialized	: JSON.stringify(data),
						nonce		: wp_ajax.nonce
					},
					success: function(success_data)
					{
						console.log('success: ' + success_data);
					}
				});
		}
	};
}(jQuery));