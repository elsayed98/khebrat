(function ($) {
	

    $('#create_offer_btn').click(function () {
        if ($('form#offer_form').smkValidate()) {
            $('.loader-outer').show();
            $.post(localize_vars_frontend.freelanceAjaxurl, {
                action: 'offer_services',
                offer_data: $("form#offer_form").serialize(),
                security: $('#create_offer_nonce').val()
            }).done(function (response) {
                if (true === response.success) {
                    toastr.success(response.data.message, '', { timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right" });
                    setTimeout(function () {
                        window.location.reload(); // إعادة تحميل نفس الصفحة
                    }, 1000);
                } else {
                    $('.loader-outer').hide();
                    toastr.error(response.data.message, '', { timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right" });
                }
            }).fail(function () {
                $('.loader-outer').hide();
                toastr.error('حدث خطأ أثناء المعالجة.', '', { timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right" });
            });
        }
    });


	$(document).on('click', '.btn-offer-action', function (e) {
		e.preventDefault();
	
		let offerID = $(this).data('id');
		let actionType = $(this).data('action');
	
		let confirmTitle = (actionType === 'accept') ? 'تأكيد قبول العرض' : 'تأكيد رفض العرض';
		let confirmContent = (actionType === 'accept') ? 'هل أنت متأكد أنك تريد قبول هذا العرض؟' : 'هل أنت متأكد أنك تريد رفض هذا العرض؟';
		let confirmButton = (actionType === 'accept') ? 'نعم، قبول' : 'نعم، رفض';
	
		$.confirm({
			title: confirmTitle,
			content: confirmContent,
			type: (actionType === 'accept') ? 'green' : 'red',
			theme: 'light',
			icon: 'mdi mdi-alert-outline',
			buttons: {
				ok: {
					text: confirmButton,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function () {
						$('.loader-outer').show();
	
						$.post(localize_vars_frontend.freelanceAjaxurl, {
							action: 'handle_offer_action',
							offer_id: offerID,
							action_type: actionType,
							security: localize_vars_frontend.security
						}).done(function (response) {
							$('.loader-outer').hide();
	
							if (response.success) {
								toastr.success(response.data.message, '', {
									timeOut: 8000,
									closeButton: true,
									positionClass: "toast-top-right"
								});
	
								$('#offer-status-' + offerID).html(
									'<div class="alert alert-' + (actionType === 'accept' ? 'success' : 'danger') + '">' +
									response.data.message +
									'</div>'
								);
	
								$('.btn-offer-action[data-id="' + offerID + '"]').remove();
							} else {
								toastr.error(response.data.message, '', {
									timeOut: 8000,
									closeButton: true,
									positionClass: "toast-top-right"
								});
							}
						}).fail(function () {
							$('.loader-outer').hide();
							toastr.error('حدث خطأ أثناء تنفيذ العملية.', '', {
								timeOut: 8000,
								closeButton: true,
								positionClass: "toast-top-right"
							});
						});
					}
				},
				cancel: {
					text: 'إلغاء',
					action: function () {}
				}
			}
		});
	});

	
	
})(jQuery);



