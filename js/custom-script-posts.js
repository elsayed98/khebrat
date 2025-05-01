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

	
})(jQuery);



