(function ($) {
	"use strict";

	$(window).load(function() {
		$(".exertio-loader-container").fadeOut("slow");
	});
	var localize_vars;
	if(typeof localize_vars_frontend != 'undefined')
	{
		localize_vars = localize_vars_frontend;
	}
	else
	{
		localize_vars = '';
	}
	var owl_rtl = false;
	if( localize_vars.is_rtl == true)
	{
		owl_rtl = true;
	}
	$(document).ready(function(){
		if ( $( ".project-sidebar .panel-body, .service-side .panel-body" ).length )
		{
			$(".project-sidebar .panel-body, .service-side .panel-body").niceScroll();
			$(".project-sidebar .panel-body, .service-side .panel-body").mouseover(function() {
				$(this).getNiceScroll().resize(); 
			});
		}
	});
	$(document).ready(function(){
		if ( $( ".popup-video" ).length )
		{
			jQuery("a.popup-video").YouTubePopUp( { autoplay: 0 } );
		}
		$('.post-type-change').on('change', function() {
			var post_value = this.value;
			if(post_value === "Freelancer")
			{
				$('.hero-one-form').attr('action', localize_vars.freelancer_search_link);	
			}
			if(post_value === "Employers")
			{
				$('.hero-one-form').attr('action', localize_vars.employer_search_link);	
			}
			if(post_value === "Projects")
			{
				$('.hero-one-form').attr('action', localize_vars.project_search_link);	
			}
			if(post_value === "Services")
			{
				$('.hero-one-form').attr('action', localize_vars.services_search_link);	
			}
		});
		if ( $( ".services-range-slider" ).length )
		{
			var $servicesRange = $(".services-range-slider"),
			$servicesInputFrom = $(".services-input-from"),
			$servicesInputTo = $(".services-input-to"),
			instance,
			min = 0,
			max = 900000000,
			from = 0,
			to = 0;
			$servicesRange.ionRangeSlider({
				skin: "round",
				type: "double",
				min: min,
				max: max,
				from: 0,
				to: 900000000,
				onStart: updateInputs,
				onChange: updateInputs
			});
			instance = $servicesRange.data("ionRangeSlider");
			function updateInputs (data) {
				from = data.from;
				to = data.to;
				
				$servicesInputFrom.prop("value", from);
				$servicesInputTo.prop("value", to);	
			}
			$servicesInputFrom.on("input", function () {
				var val = $(this).prop("value");
				
				if (val < min) {
					val = min;
				} else if (val > to) {
					val = to;
				}
				
				instance.update({
					from: val
				});
			});
			$servicesInputTo.on("input", function () {
				var val = $(this).prop("value");
				
				if (val < from) {
					val = from;
				} else if (val > max) {
					val = max;
				}
				
				instance.update({
					to: val
				});
			});
		}
		if ( $( "#order_by" ).length )
		{
			$('#order_by').on('change', function() {
				$(this).closest("form").submit();
			});
			
		}
		$( ".list-style" ).on( "click", function() {
				var list_style = $(this).data('list-style');
				$("input[name=list-style]").val(list_style);
			    $(this).closest("form").submit();
			});
			
		$( ".show-skills" ).on( "click", function() {
				$( this ).parent().addClass('active');
			    $(this).hide();
			});


	});
	$.protip();
	//$('.Select').select2();
	var $container = $('.grid');
	$container.imagesLoaded(function(){
	  $container.masonry({
		itemSelector : '.grid-item',
		percentPosition: true,
		layoutMode: 'masonry',
		transitionDuration: '0.7s',
	  });
	});
$(document).ready(function() {
	$('.select2').select2();
});
$(document).ready(function(){
  $("a.scroll").on('click', function(event) {
		if (this.hash !== "") {
		  event.preventDefault();
		  var hash = this.hash;
		  $('html, body').animate({
			scrollTop: $(hash).offset().top
		  }, 800, function(){
			window.location.hash = hash;
		  });
		} 
	  });
});
	
	
	$('.not_loggedin_chat_toggler').click(function(){
		$(this).find($(".fas")).addClass("fa-spinner fa-spin" );
		$(this).find($(".fas")).removeClass("fa-angle-right" );
		$.post(localize_vars.freelanceAjaxurl,{action: 'whizzchat_notloggedin'}).done(function (response)
		{
			if ( true === response.success )
			{
				toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$(".fas").addClass("fa-angle-right" );
				$(".fas").removeClass("fa-spinner fa-spin" );
			}
			else
			{
				$(".fas").addClass("fa-angle-right" );
				$(".fas").removeClass("fa-spinner fa-spin" );
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$('.loader-outer').hide();
			}

		})
	});
	
	if ( $( "#signup-form" ).length )
	{
		$('#password-field').passtrength({
			minChars: 4,
			tooltip:true,
			textWeak:localize_vars.pass_textWeak,
			textMedium:localize_vars.pass_textMedium,
			textStrong:localize_vars.pass_textStrong,
			textVeryStrong:localize_vars.pass_textVeryStrong,
			passwordToggle: false,
		});
	}
	$('#signup-btn').click(function(){
		if( $('form#signup-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('span.bubbles').addClass('view');
			$("#signup-btn").attr("disabled", true);
			var redirect_id = $(this).attr('data-redirect-id');
		  $.post(localize_vars.freelanceAjaxurl, {action: 'sign_up', signup_data: $("form#signup-form").serialize(), security:$('#register_nonce').val(), redirect_id:redirect_id }).done(function (response)
			{
				var get_notification = response.split('|');
				if ($.trim(get_notification[0]) == '1')
				{
					$('#signup-btn').attr("disabled", false);
					toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					if(get_notification[3] != '')
					{
						this_value.find('span.bubbles').removeClass("view");
						$("#fl_user_id").val(get_notification[3]);
						$(".fr_resend_email").css("display", "block");
					}
					else if(get_notification[2] != '')
					{
							window.location = get_notification[2];
					}

				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$('#signup-btn').attr("disabled", false);
					toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#signup-btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});


	$('#lawyer-signup-btn').click(function(){
		if( $('form#lawyer-signup-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('span.bubbles').addClass('view');
			$("#lawyer-signup-btn").attr("disabled", true);
			var redirect_id = $(this).attr('data-redirect-id');
	
			$.post(localize_vars.freelanceAjaxurl, {
				action: 'lawyer_sign_up',
				signup_data: $("form#lawyer-signup-form").serialize(),
				security: $('#lawyer_register_nonce').val(),
				redirect_id: redirect_id
			}).done(function (response) {
				var get_notification = response.split('|');
				if ($.trim(get_notification[0]) == '1') {
					toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					setTimeout(function(){
						window.location.href = get_notification[2];
					}, 2000);
				} else {
					toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					$("#lawyer-signup-btn").attr("disabled", false);
					this_value.find('span.bubbles').removeClass('view');
				}
			}).fail(function () {
				toastr.error('حدث خطأ أثناء الإرسال.', '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
				$("#lawyer-signup-btn").attr("disabled", false);
				this_value.find('span.bubbles').removeClass('view');
			});
		}
	});


	$(document).on('change', '#license_file', function () {
    const file = this.files[0];
    const hiddenInput = $('#uploaded_license_file');
    const nameFile = $('#license_name_file');
    const freelanceAjaxURL = $('#freelance_ajax_url').val() || '/wp-admin/admin-ajax.php';

    if (!file || file.type !== 'application/pdf') {
        toastr.error('❌ الرجاء اختيار ملف PDF فقط.');
        return;
    }

    const formData = new FormData();
    formData.append('file', file);
    formData.append('action', 'upload_pdf_to_media');

    fetch(freelanceAjaxURL, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data && data.data.attachment_id) {
            hiddenInput.val(data.data.attachment_id);
            nameFile.text(file.name);
            toastr.success('✅ تم رفع الملف بنجاح.');
        } else {
            toastr.error(data.message || '❌ فشل رفع الملف');
        }
        this.value = '';
    })
    .catch(err => {
        toastr.error('⚠️ حدث خطأ أثناء رفع الملف.');
        this.value = '';
    });
	});


	



	$('#customer-signup-btn').click(function(){
		if( $('form#customer-signup-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('span.bubbles').addClass('view');
			$("#customer-signup-btn").attr("disabled", true);
			var redirect_id = $(this).attr('data-redirect-id');
		  $.post(localize_vars.freelanceAjaxurl, {action: 'customer_sign_up', signup_data: $("form#customer-signup-form").serialize(), security:$('#register_nonce').val(), redirect_id:redirect_id }).done(function (response)
			{
				var get_notification = response.split('|');
				if ($.trim(get_notification[0]) == '1')
				{
					$('#customer-signup-btn').attr("disabled", false);
					toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					if(get_notification[3] != '')
					{
						this_value.find('span.bubbles').removeClass("view");
						$("#fl_user_id").val(get_notification[3]);
						$(".fr_resend_email").css("display", "block");
					}
					else if(get_notification[2] != '')
					{
							window.location = get_notification[2];
					}

				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$('#customer-signup-btn').attr("disabled", false);
					toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#customer-signup-btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});



	$('.fr_send_email').click(function(){
		var val_user_id = $('#fl_user_id').val();
		var val_nonce_id = $('#register_nonce').val();
			$.post(localize_vars.freelanceAjaxurl, {action: 'sign_up_resend',user_id:val_user_id, security:val_nonce_id}).done(function (response)
			{
				var get_notification = response.split('|');
				if ($.trim(get_notification[0]) == '1')
				{
					$('#signup-form').find('span.bubbles').removeClass("view");
					$('#signup-form').trigger("reset");
					setTimeout(function(){
						window.location = get_notification[2];
					}, 60000);
					toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				else
				{
					toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}

			 });
	});
	$('#signin-btn').click(function(){
		if( $('form#signin-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass('view');
			$("#signin-btn").attr("disabled", true);
			var redirect_id = $(this).attr('data-redirect-id');
			

		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_sign_in', signin_data: $("form#signin-form").serialize(), redirect_id:redirect_id }).done(function (response)
                    {
						var get_notification = response.split('|');
						if ($.trim(get_notification[0]) == '1')
						{
							this_value.find('div.bubbles').removeClass("view");
							toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							window.location = get_notification[2];
						}
						else
						{
							this_value.find('div.bubbles').removeClass("view");
							$('#signin-btn').attr("disabled", false);
							toastr.error(get_notification[1], '', {timeOut: 80000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						}
						
                    }).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#signup-btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 800000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});

$('#forget_btn').click(function(){
		if( $('form#fl-forget-form').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass('view');
			$("#forget_btn").attr("disabled", true);
		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_forget_pwd', forget_pwd_data: $("form#fl-forget-form").serialize(), security:$('#fl_forget_pwd_nonce').val()}).done(function (response)
                    {
						if ( true === response.success ) 
						{
							this_value.find('div.bubbles').removeClass("view");
							$('#forget_btn').attr("disabled", false);
							toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							$('#forget_pwd').modal('hide');
							$('#fl-forget-form').trigger("reset"); 
						}
						else
						{
							this_value.find('div.bubbles').removeClass("view");
							$('#forget_btn').attr("disabled", false);
							toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						}
						
                    }).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('#forget_btn').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});
if(localize_vars.is_reset !="" && localize_vars.is_reset == 1)
{
	if(localize_vars.reset_status.status == false)
	{
		toastr.error(localize_vars.reset_status.r_msg, '', {timeOut: 20000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
	}
	else
	{
		toastr.success(localize_vars.reset_status.r_msg, '', {timeOut: 20000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
		$('input[name=requested_user_id]').val(localize_vars.reset_status.requested_id);
		$(window).load(function() {
			$('#mynewpass').modal('show');
		});
	}
}
	
if(localize_vars.activation_is_set !="" && localize_vars.activation_is_set == 1)
{
	if(localize_vars.activation_is_set_msg.activation_status == false)
	{
		toastr.error(localize_vars.activation_is_set_msg.status_msg, '', {timeOut: 20000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
	}
	else
	{
		toastr.success(localize_vars.activation_is_set_msg.status_msg, '', {timeOut: 20000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
	}
}
$('.btn-reset-new').click(function(){
		if( $('form#mynewPass').smkValidate() ){
			var this_value = $(this);
			this_value.find('div.bubbles').addClass('view');
			$(".btn-reset-new").attr("disabled", true);
		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_forgot_pass_new', forget_pwd_data: $("form#mynewPass").serialize(), security:$('#fl_forget_new_pwd_nonce').val()}).done(function (response)
                    {
						if ( true === response.success ) 
						{
							this_value.find('div.bubbles').removeClass("view");
							$('.btn-reset-new').attr("disabled", false);
							toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							setTimeout(function(){
									 window.location = response.data.page_link;
									}, 800);
						}
						else
						{
							this_value.find('div.bubbles').removeClass("view");
							$('.btn-reset-new').attr("disabled", false);
							toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						}
						
                    }).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$('.btn-reset-new').attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
		}
	});





$(document).on('keyup', '#bidding-price', function() {

	var total_amount = $('input#bidding-price').val();
	var percentage = localize_vars.proAdminCost;
  
	var freelanceAjaxURL = $("#freelance_ajax_url").val();
	$.post(freelanceAjaxURL, {action: 'fl_calc_bid_price_fixed',  total_amount:total_amount, percentage:percentage }).done(function (response)
	{
		if ( true === response.success)
		{
			$("#service-price").html(response.data.admin_charges);
			$("#earning-price").html(response.data.earning);
		}
	})
});

/*FOR TOTAL CODE MINTUS ADMIN COST FOR HOURLY*/

$(document).on('keyup', '#bidding_price, #bid-hours', function() {
	
	var hourly_amount = $('input#bidding_price').val();
	var bid_hours = $('input#bid-hours').val();

	var percentage = localize_vars.proAdminCost;
  
	var freelanceAjaxURL = $("#freelance_ajax_url").val();
	$.post(freelanceAjaxURL, {action: 'fl_calc_bid_price',  hourly_amount:hourly_amount, bid_hours:bid_hours, percentage:percentage }).done(function (response)
	{
		if ( true === response.success)
		{
			$("#service-price").html(response.data.admin_charges);
			$("#earning-price").html(response.data.earning);
		}
	})
});
$('.price-breakdown').on('click', function() {
	$(".price-section").toggle(350);
});

/*SUBMIT PROJECT BID*/

$('#btn_project_bid').on('click', function() {
		if( $('form#bid_form').smkValidate() ){
			$(".btn-loading .bubbles").addClass("view");
			$("#btn_project_bid").attr("disabled", true);
			var post_id = $(this).attr('data-post-id');
		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_place_bid', bid_data: $("form#bid_form").serialize(), security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
			{
				if ( true === response.success ) 
				{
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".btn-loading .bubbles").removeClass("view");
					if(response.data.page)
					{
						location.replace(response.data.page);
					}
					else
					{
						setTimeout(function(){
						  location.reload(true);
						},600);
					}
				}
				else
				{
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$(".btn-loading .bubbles").removeClass("view");
					$('#btn_project_bid').attr("disabled", false);	
				}
				
			}).fail(function () {
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
						$(".btn-loading .bubbles").removeClass("view");
						$('#btn_project_bid').attr("disabled", false);	
					   });
		}
	});

if ( $( ".fr-services2-box" ).length )
{
	$(".fl_addon_checkbox").prop("checked", false);
}
/*SERVICE DETAIL PAGE ADDONS CHECKBOXES*/
$(document).on('click', '.fl_addon_checkbox', function() {
	$('.loader-outer').show();
	var addon_price = $(this).attr("data-addon-price");
	var service_price = $('.project-price.service').find('.price' ).attr("data-service-price");
	var service_id = $(this).attr("data-service-id");

	if($(this).prop('checked'))
	{
		var calc = 'plus';
	}
	else
	{
		var calc = 'minus';
	}
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
		$.post(freelanceAjaxURL, {action: 'fl_calc_services_price',  service_price:service_price, addon_price:addon_price, calc:calc, service_id:service_id }).done(function (response)
		{
			if ( true === response.success)
			{
				$('.loader-outer').hide();
				$('.project-price.service .price').html(response.data.cal_data_html);
				$('#buy_service small span').html(response.data.cal_data_html);
				$('#buy_service_woo small span').html(response.data.cal_data_html);
				$('.project-price.service .price').attr('data-service-price', response.data.cal_data)
				$('.loader-outer').hide();
			}
			else
			{
				$('.loader-outer').hide();
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			}

		}).fail(function () {
		$('.loader-outer').hide();
		toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
		});
});

/*BUY SERVICE*/
$(document).on('click', '#buy_service', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars.Msgconfirm,
			content: localize_vars.serviceBuy,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {   
				ok: {
					text: localize_vars.YesSure,
					btnClass: 'btn-theme',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var sid = this_value.attr("data-sid");
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						  $.post(freelanceAjaxURL, {action: 'fl_purchase_services', security:$('#gen_nonce').val(), sid:sid, purchase_data: $("form#purchased_addon_form").serialize() }).done(function (response)
							{
								if ( true === response.success)
								{
									$('.loader-outer').hide();
									toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									if(response.data.page)
									{
										location.replace(response.data.page);
									}
									else
									{
										setTimeout(function(){
										  location.reload(true);
										},600);
									}
									 
								}
								else
								{
									$('.loader-outer').hide();
									toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								}
								
							}).fail(function () {
						$('.loader-outer').hide();
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });

					}
				},
				cancel: {
					text: localize_vars.cancel,
					action: function(){ }
				}
			}
		});
	});

/*BUY SERVICE*/
$(document).on('click', '#buy_service_woo', function (){
		var this_value = $(this);
		$.confirm({
			title: localize_vars.Msgconfirm,
			content: localize_vars.serviceBuy,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {
				ok: {
					text: localize_vars.YesSure,
					btnClass: 'btn-theme',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var sid = this_value.attr("data-sid");
						var freelanceAjaxURL = $("#freelance_ajax_url").val(); 
						$.post(freelanceAjaxURL, {action: 'fl_deposit_custom_service_callback', security:$('#gen_nonce').val(), sid:sid, deposit_custom_service_data: $("form#purchased_addon_form").serialize() }).done(function (response)
						{
							if ( true === response.success)
							{
								$('.loader-outer').hide();
								toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								if(response.data.page)
								{
									location.replace(response.data.page);
								}
								else
								{
									setTimeout(function(){
										location.reload(true);
									},600);
								}

							}
							else
							{
								$('.loader-outer').hide();
								toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							}

						}).fail(function () {
							$('.loader-outer').hide();
							toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
						});

					}
				},
				cancel: {
					text: localize_vars.cancel,
					action: function(){ }
				}
			}
		});
	});




/*BUY consultation*/
/*
$(document).on('click', '#buy_consultation_woo', function (){
	var this_value = $(this);
	$.confirm({
		title: localize_vars.Msgconfirm,
		content: localize_vars.consultationBuy,
		type: 'green',
		theme: 'light',
		icon: 'mdi mdi-alert-outline ',
		buttons: {
			ok: {
				text: localize_vars.YesSure,
				btnClass: 'btn-theme',
				keys: ['enter'],
				action: function(){
					$('.loader-outer').show();
					var lcid = this_value.attr("data-lcid");
					var freelanceAjaxURL = $("#freelance_ajax_url").val(); 
					$.post(freelanceAjaxURL, {action: 'fl_deposit_custom_consultation_callback', security:$('#gen_nonce').val(), lcid:lcid, deposit_custom_consultation_data: $("form#legal_consultation_form").serialize() }).done(function (response)
					{
						if ( true === response.success)
						{
							$('.loader-outer').hide();
							toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
							if(response.data.page)
							{
								location.replace(response.data.page);
							}
							else
							{
								setTimeout(function(){
									location.reload(true);
								},600);
							}

						}
						else
						{
							$('.loader-outer').hide();
							toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						}

					}).fail(function () {
						$('.loader-outer').hide();
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					});

				}
			},
			cancel: {
				text: localize_vars.cancel,
				action: function(){ }
			}
		}
	});
});
*/

/*FRONT END JAVASCRIPT*/
if ( $( ".client-slider" ).length )
{
	$('.client-slider').owlCarousel({
		loop: true,
		margin: 10,
		autoplay: true,
		nav: true,
		rtl:owl_rtl,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
}
if ( $( ".sign-in" ).length )
{
	$('.sign-in').owlCarousel({
		loop: true,
		margin: 0,
		autoplay: false,
		nav: true,
		rtl:owl_rtl,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
}

	/* owl-carousel comments*/
	if ( $( ".header-cat-slider" ).length )
	{
		$('.header-cat-slider').owlCarousel({
			loop: true,
			margin: 10,
			autoplay: false,
			nav: true,
			dots:false,
			rtl:owl_rtl,
			navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
			responsive: {
				0: {
					items: 2
				},
				600: {
					items: 3
				},
				1000: {
					items: 4
				},
				1300: {
					items: 6
				},
				1600: {
					items: 8
				}
			}
		});
	}
if ( $( ".explore-slider" ).length )
{


 var $auto_play = false;
 var $is_$auto_play   =  $('#cat-slider-autoplay').val();
  if($is_$auto_play == 'yes'){
  	$auto_play  = true;
  }


  var $autoplay_time =  $('#autoplay_time').val();
  if($autoplay_time == ""){
  	$autoplay_time =  3000;
  }


	$('.explore-slider').owlCarousel({
		loop: true,
		margin: 10,
		autoplay: $auto_play,
		autoplayTimeout: $autoplay_time,
		nav: false,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			},
			1200: {
				items: 4
			}
		}
	});
}
if ( $( ".top-lancer-slider" ).length )
{
	$('.top-lancer-slider').owlCarousel({
		loop: true,
		margin: 10,
		autoplay: true,
		nav: true,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	});
}
if ( $( ".top-services-2" ).length )
{
	$('.top-services-2').owlCarousel({
		loop: false,
		margin: 20,
		autoplay: true,
		nav: true,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			},
			1200: {
				items:4
			}
		}
	});
}

	if ( $( ".fr-top-product_slider" ).length > 1 )
	{
		var item_count = parseInt($(this).find('.slide').length);
		$('.fr-top-product_slider').owlCarousel({

			loop: true,
			smartSpeed :900,
			margin: 20,
			autoplay: false,
			nav: true,
			dots:true,
			mouseDrag: false,
			rtl:owl_rtl,
			navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1000: {
					items: 1
				},
				1200: {
					items:1
				}
			},
			onInitialize: function(event) {
				// Check if only one slide in carousel
				if (item_count <= 1) {
					this.settings.loop = false;
					this.settings.nav = false;
					this.settings.dots = false;
				}
				// I have more than one slide?! Great what are my options?!
				else {
					this.settings.loop = true;
					this.settings.nav = true;
					this.settings.dots = true;
				}
			},
		});

	}
/* owl-carousel comments*/
if ( $( ".recomended-slider" ).length )
{
	$('.recomended-slider').owlCarousel({
		loop: false,
		margin: 10,
		nav: true,
		dots:false,
		rtl:owl_rtl,
		navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 2
			},
			1000: {
				items: 3
			},
			1200: {
				items: 4
			}
			
		}
	});
}

$(document).ready(function() {
    $('.default-select').select2();
});

$(document).ready(function() {
  $('.fr-slick-thumb ').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: true,
    slideshow: false,
    itemWidth: 100,
    itemMargin: 10,
    asNavFor: '.fr-slick',
	prevText:'<i class="fas fa-angle-left"></i>',
	nextText:'<i class="fas fa-angle-right"></i>',
  });
  $('.fr-slick').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: true,
    slideshow: false,
    sync: ".fr-slick-thumb ",
	prevText:'<i class="fas fa-angle-left"></i>',
	nextText:'<i class="fas fa-angle-right"></i>',
  });
});

	
/*MARK FAV*/

	$(document).on('click', '.mark_fav', function () {
	$('.loader-outer').show();
	var post_id = $(this).attr('data-post-id');
	var this_elem   =  $(this);
	$.post(localize_vars.freelanceAjaxurl, {action: 'fl_mark_fav_project', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
	{
		if ( true === response.success ) 
		{
			 this_elem.addClass('fav'); 
			toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			$('.loader-outer').hide();
		}
		else
		{
			toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			$('.loader-outer').hide();
		}
		
	}).fail(function () {
				toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
				$('.loader-outer').hide();
			   });
	});


	$(document).on('click', '.delete_fav_project', function () {
	var this_value = $(this);
	$.confirm({
				title: localize_vars.Msgconfirm,
				content: localize_vars.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
							$('.loader-outer').show();
							var post_id = this_value.attr('data-post-id');
							$.post(localize_vars.freelanceAjaxurl, {action: 'fl_delete_fav_project', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
							{
								if ( true === response.success ) 
								{
									toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									setTimeout(function(){
										location.reload(true);
									}, 600);
								}
								else
								{
									toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									$('.loader-outer').hide();
								}
								
							}).fail(function () {
										toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
										$('.loader-outer').hide();
									   });

						}
					},
					cancel: {
						text: localize_vars.confimNo,
						action: function(){ }
					}
				}
			});
	});



/*SERVICES MARK AS SAVED*/

$('.save_service').on('click', function() {
	$('.loader-outer').show();
	var post_id = $(this).attr('data-post-id');
	$.post(localize_vars.freelanceAjaxurl, {action: 'fl_mark_fav_services', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
	{
		if ( true === response.success ) 
		{
			toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			$('.loader-outer').hide();
		}
		else
		{
			toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			$('.loader-outer').hide();
		}
		
	}).fail(function () {
				toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
				$('.loader-outer').hide();
			   });
	});

$('.delete_saved_service').on('click', function() {
	var this_value = $(this);
	$.confirm({
				title: localize_vars.Msgconfirm,
				content: localize_vars.AreYouSure,
				type: 'green',
				theme: 'light',
				icon: 'mdi mdi-alert-outline ',
				buttons: {   
					ok: {
						text: localize_vars.confimYes,
						btnClass: 'btn-primary',
						keys: ['enter'],
						action: function(){
							$('.loader-outer').show();
							var post_id = this_value.attr('data-post-id');
							$.post(localize_vars.freelanceAjaxurl, {action: 'fl_delete_saved_services', security:$('#gen_nonce').val(), post_id:post_id}).done(function (response)
							{
								if ( true === response.success ) 
								{
									toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									$('.loader-outer').hide();
									setTimeout(function(){
										location.reload(true);
									}, 600);
								}
								else
								{
									toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
									$('.loader-outer').hide();
								}
								
							}).fail(function () {
										toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
										$('.loader-outer').hide();
									   });

						}
					},
					cancel: {
						text: localize_vars.confimNo,
						action: function(){ }
					}
				}
			});
	});

/*EMPLOYER DETAIL PAGE PAGINATION */
	$(document).on('click', '.emp_pro_pagination', function () {
			var pageno = $(this).attr('data-page-number');
			var author = $(this).attr('data-post-author');
			var this_value = $(this);
			$('.loader-outer').show();
		  $.post(localize_vars.freelanceAjaxurl, {action: 'fl_get_paged_projects', pageno: pageno, author: author, security:$('#gen_nonce').val() }).done(function (response)
			{
				if ( true === response.success ) 
				{
					$("div.fl-navigation").find('.emp_pro_pagination').removeClass("active");
					this_value.addClass('active');

					$(".posted-projects").html('');
					$(".posted-projects").html(response.data.html);
					$(".emp-profile-pagination").html(response.data.pagination);
					$('.loader-outer').hide();
					$( ".show-skills" ).on( "click", function() {
						$( this ).parent().addClass('active');
						$(this).hide();
					});
				}
				else
				{
					$('.loader-outer').hide();
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						$('.loader-outer').hide();
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
	});
	$(document).on('click', '.emp_pro_sidebare_pagination', function () {
		var pageno = $(this).attr('data-page-number');
		var author = $(this).attr('data-post-author');
		var this_value = $(this);
		$('.loader-outer').show();
		$.post(localize_vars.freelanceAjaxurl, {action: 'fl_get_paged_projects_sidebar', pageno: pageno, author: author, security:$('#gen_nonce').val() }).done(function (response)
		{
			if ( true === response.success )
			{
				$("div.fl-navigation").find('.emp_pro_pagination').removeClass("active");
				this_value.addClass('active');

				$(".posted-projects").html('');
				$(".posted-projects").html(response.data.html);
				$(".emp-profile-pagination").html(response.data.pagination);
				$('.loader-outer').hide();
				$( ".show-skills" ).on( "click", function() {
					$( this ).parent().addClass('active');
					$(this).hide();
				});
			}
			else
			{
				$('.loader-outer').hide();
				toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
			}

		}).fail(function () {
			$('.loader-outer').hide();
			toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
		});
	});

/*FOLLOW EMPLOYERS*/

	$(document).on('click', '.follow-employer', function () {
		$('.loader-outer').show();
		var emp_id = $(this).attr('data-emp-id');
		$.post(localize_vars.freelanceAjaxurl, {action: 'fl_follow_employer', security:$('#gen_nonce').val(), emp_id:emp_id}).done(function (response)
		{
			if ( true === response.success ) 
			{
				toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$('.loader-outer').hide();
			}
			else
			{
				toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				$('.loader-outer').hide();
			}
			
		}).fail(function () {
					toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
					$('.loader-outer').hide();
				   });
	});

/*FOLLOW FREELANCER*/

	$(document).on('click', '.follow-freelancer', function () {
		var this_value =$(this);
		this_value.find('i.fa-heart').remove();
		this_value.prepend('<i class="fa fa-spinner fa-spin"></i>');
		var fid = $(this).attr('data-fid');
		$.post(localize_vars.freelanceAjaxurl, {action: 'fl_follow_freelancer', security:$('#gen_nonce').val(), fid:fid}).done(function (response)
		{
			if ( true === response.success ) 
			{
				toastr.success(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				this_value.find('i.fa-spinner').hide();
				this_value.prepend('<i class="fa fa-heart active"></i>');
			}
			else
			{
				toastr.error(response.data.message, '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				this_value.find('i.fa-spinner').hide();
			}
			
		}).fail(function () {
					toastr.error($('#nonce_error').val(), '', {timeOut: 5000, "closeButton": true, "positionClass": "toast-top-right"});
					this_value.find('i.fa-spinner').hide();
					this_value.prepend('<i class="fa fa-heart"></i>');
				   });
	});
	
$(".toggle-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("data-toggle"));
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
	
	

	if(typeof window.counterUp !== "undefined"){
	
	var counterUp = window.counterUp["default"];  
	 /*import counterUp from "counterup2"*/  
    var $counters = $(".counter");
    
    /* Start counting, do this on DOM ready or with Waypoints. */
    $counters.each(function (ignore, counter) {
        counterUp(counter, {
            duration: 1000,
            delay: 16
        });
    });

  }

	if ( $( ".elbow" ).length )
	{
		$('.elbow').owlCarousel({
			loop:true,
			margin:0,
			autoplay:true,
			nav:true,
			rtl:owl_rtl,
			responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:1
				}
			}
		})
	}
	if($('.my-testimonials').length > 0)
	{
		$(".my-testimonials").owlCarousel({
			margin: 0,
			smartSpeed: 600,
			autoplay: 5000, /*Set AutoPlay to 5 seconds*/

			loop: true,
			responsiveClass: true,
			navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
			nav: false,
			dots: false,
			rtl:owl_rtl,
			responsive: {
				0: {
					items: 1
				},
				480: {
					items: 1
				},
				769: {
					items: 1
				},
				1000: {
					items: 1
				}
			}

		});
	}
	
/*EMPLOYER PACKAGE*/
$(document).on('click', '.emp-purchase-package', function () {
			var this_value = $(this);
			this_value.find('span.bubbles').addClass("view");
			var product_id = $(this).attr('data-product-id');
			var emp_nonce = $(".employer_package_nonce"). val();
			$(".emp-purchase-package").attr("disabled", true);
	alert
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_employer_package_callback', security:emp_nonce, product_id:product_id }).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('span.bubbles').removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					window.location = response.data.cart_page;
				}
				else
				{
					this_value.find('span.bubbles').removeClass("view");
					$(".emp-purchase-package").attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('span.bubbles').removeClass("view");
						$(".emp-purchase-package").attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
	});	


/*FREELANCER PACKAGE*/
$(document).on('click', '.freelancer-purchase-package', function () {
			var this_value = $(this);
			this_value.find('div.bubbles').addClass("view");
			var product_id = $(this).attr('data-product-id');
			var freelancer_nonce = $(".freelancer_package_nonce"). val();
			$(".freelancer-purchase-package").attr("disabled", true);
		  $.post(localize_vars_frontend.freelanceAjaxurl, {action: 'exertio_freelancer_package_callback', security:freelancer_nonce, product_id:product_id }).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('div.bubbles').removeClass("view");
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					window.location = response.data.cart_page;
				}
				else
				{
					this_value.find('div.bubbles').removeClass("view");
					$(".freelancer-purchase-package").attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}
				
			}).fail(function () {
						this_value.find('div.bubbles').removeClass("view");
						$(".freelancer-purchase-package").attr("disabled", false);
						toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
					   });
	});	

	/*REPORT*/
	$('#btn-report').click(function(){
		if( $('form#report-form').smkValidate() )
		{
			var this_value = $(this);
			var post_id = $(this).attr('data-post-id');
			this_value.find('span.bubbles').addClass('view');
			$("#btn-report").attr("disabled", true);
			$.post(localize_vars.freelanceAjaxurl, {action: 'fl_report_call_back', report_data: $("form#report-form").serialize(), post_id: post_id, security:$('#fl_report_nonce').val()}).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('span.bubbles').removeClass("view");
					$('#btn-report').attr("disabled", false);
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$('#report-modal').modal('hide');
					$('#report-form').trigger("reset"); 
				}
				else
				{
					this_value.find('span.bubbles').removeClass("view");
					$('#btn-report').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$('#report-form').trigger("reset"); 
				}

			}).fail(function () {
				this_value.find('span.bubbles').removeClass("view");
				$('#btn-report').attr("disabled", false);
				toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
			   });
		}
	});
	
	/*REPORT*/
	$('#btn-hire-freelancer').click(function(){
		if( $('form#hire-freelancer-form').smkValidate() )
		{
			var this_value = $(this);
			var freelancer_id = $(this).attr('data-freelancer-id');
			this_value.find('span.bubbles').addClass('view');
			$("#btn-hire-freelancer").attr("disabled", true);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.post(freelanceAjaxURL, {action: 'hire_freelancer_call_back', hire_freelancer_data: $("form#hire-freelancer-form").serialize(), freelancer_id:freelancer_id, security:$('#fl_hire_freelancer_nonce').val()}).done(function (response)
			{
				if ( true === response.success ) 
				{
					this_value.find('span.bubbles').removeClass("view");
					$('#btn-hire-freelancer').attr("disabled", false);
					toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$('#report-modal').modal('hide');
					$('#hire-freelancer-form').trigger("reset"); 
				}
				else
				{
					this_value.find('span.bubbles').removeClass("view");
					$('#btn-hire-freelancer').attr("disabled", false);
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					$('#hire-freelancer-form').trigger("reset"); 
				}

			}).fail(function () {
				this_value.find('span.bubbles').removeClass("view");
				$('#btn-hire-freelancer').attr("disabled", false);
				toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});
			   });
		}
	});
	
	
	$(document).ready(function(){
	      $('.project-sidebar .panel-body.add-search, .service-side .panel-body.add-search').before(
	          '<div class="search-finder"><input class="search form-control"  type="text" />'
	          +'<span class="search-clear-btn"><a href="" onclick="return false;" class="search-clear"><i class="fas fa-times"></i></a></span></div>'
	          );
		
		$('.project-sidebar .search, .service-side .search').keyup(function(){
	        var valThis = $(this).val().toLowerCase();
	          $(this).parent().parent().find('input[type=checkbox]').each(function(){
	             var text = $("span[for='"+$(this).attr('id')+"']").text().toLowerCase();
				 (text.indexOf(valThis) != -1) ? $(this).parent().show() : $(this).parent().hide();
				  (text.indexOf(valThis) != -1) ? $(this).show() : $(this).hide();
				  
				  if(text.indexOf(valThis) != -1){
					   $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").show();
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").parent().removeClass("sub_li_hide");
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").parent().parent().removeClass("sub_ul_hide");
				  }
				  else{
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").hide();
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").parent().addClass("sub_li_hide");
					  $(this).parent().parent().find("span[for='"+$(this).attr('id')+"']").parent().parent().addClass("sub_ul_hide");
				  }
				  
	         });
	  });
		
		$(".project-sidebar .search-clear, .service-side .search-clear").on('click', function(){
	        $(".search").val("");

			$(".project-sidebar, .service-side").find(".sub_ul_hide").removeClass("sub_ul_hide");
			$(".project-sidebar, .service-side").find(".sub_li_hide").removeClass("sub_li_hide");
	        $('input[type=checkbox]').each(function(){
	        	$(this).parent().show();
				$(this).parent().parent().find("span").show();
	        });
	      });
	});
	if(localize_vars_frontend.exertio_notification == true)
	{
		setInterval(exertio_automate_notification, localize_vars_frontend.notification_time);
		var title = document.title;
		function exertio_automate_notification(){
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.post(freelanceAjaxURL, {action: 'exertio_notification_ajax'}).done(function (response)
			{
				if ( true === response.success )
				{
					var n_count = response.data.count;
					if(n_count > 0)
					{
						$(".notification-list").html(response.data.n_list);
						$("a.notification-click .badge-container").html('<span class="badge bg-danger">'+n_count+'</span>');
						document.title = '('+response.data.count+') '+title;
					}
				}
				else
				{
					console.log('error');
				}

			}).fail(function () {
				console.log('error 2');
			});
		}

		$('a.notification-click').on('click', function(){
			var this_value = $(this);
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
			$.post(freelanceAjaxURL, {action: 'exertio_read_notifications', security:$('#gen_nonce').val()}).done(function (response)
			{
				if ( true === response.success )
				{
					$( ".notification-click .badge-container span.badge" ).remove();
					document.title = title;
				}
				else
				{
					toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
				}

			}).fail(function () {
				toastr.error($('#nonce_error').val(), '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right"});

			});
		});
	}
	
	$('.arrow-down').on('click', function() {
		$(".cpt-dropdown-header").toggle();
		});
	$('.cpt-dropdown-header li').on('click', function() {
			var post_value = $(this).attr('data-cpt');
			if(post_value === "freelancer")
			{
				$('.cpt-header-form').attr('action', localize_vars.freelancer_search_link);	
				$('.cpt-header-form input').attr("placeholder", localize_vars.searchTalentText);
			}
			if(post_value === "employer")
			{
				$('.cpt-header-form').attr('action', localize_vars.employer_search_link);
				$('.cpt-header-form input').attr("placeholder", localize_vars.searchEmpText);
			}
			if(post_value === "project")
			{
				$('.cpt-header-form').attr('action', localize_vars.project_search_link);
				$('.cpt-header-form input').attr("placeholder", localize_vars.findJobText);
			}
			if(post_value === "service")
			{
				$('.cpt-header-form').attr('action', localize_vars.services_search_link);
				$('.cpt-header-form input').attr("placeholder", localize_vars.searchServiceText);
			}
			$(".cpt-dropdown-header").toggle();
		});
	$(document).ready(function(){
		if ( $( ".services-range-slider" ).length )
		{
			var $servicesRange = $(".services-range-slider"),
				$servicesInputFrom = $(".services-input-from"),
				$servicesInputTo = $(".services-input-to"),
				instance,
				min = 0,
				max = 9000,
				from = 0,
				to = 0;
			$servicesRange.ionRangeSlider({
				skin: "round",
				type: "double",
				min: min,
				max: max,
				from: 0,
				to: 9000,
				onStart: updateInputs,
				onChange: updateInputs
			});
			instance = $servicesRange.data("ionRangeSlider");
			function updateInputs (data) {
				from = data.from;
				to = data.to;

				$servicesInputFrom.prop("value", from);
				$servicesInputTo.prop("value", to);
			}
			$servicesInputFrom.on("input", function () {
				var val = $(this).prop("value");

				if (val < min) {
					val = min;
				} else if (val > to) {
					val = to;
				}

				instance.update({
					from: val
				});
			});
			$servicesInputTo.on("input", function () {
				var val = $(this).prop("value");

				if (val < from) {
					val = from;
				} else if (val > max) {
					val = max;
				}

				instance.update({
					to: val
				});
			});
		}
		$('.default-select').select2();
	});
	$(document).ready(function(){
		if ( $( ".info_boxes" ).length )
		{
			$('.detail_loader_earning .loader-outer').show();
			$('.loader-outer').css("position", "absolute");
			$.post(localize_vars.freelanceAjaxurl, {action: 'fl_earning' }).done(function (response)
			{

				$('.info_boxes').css("display", "block"),2000;

				if ( true === response.success )
				{
					$('.detail_loader_earning .loader-outer').hide();
					$(".info_boxes").html(response.data.html);
				}
				else
				{
					$('.detail_loader_earning .loader-outer').hide();
					$(".info_boxes").html(response.data.html);
				}

			}).fail(function () {
			});
		}
	});
	/* Candidate Subscribing job alerts */
	$(document).on('click', '#job_alerts', function () {
		if( $('form#alert_job_form').smkValidate() ){
				var freelanceAjaxURL = $("#freelance_ajax_url").val();
				$.post(freelanceAjaxURL, {
					action: 'job_alert_subscription',
					submit_alert_data: $("form#alert_job_form").serialize(),
					security:$('#gen_nonce').val(),
				}).done(function (response) {
					var get_notification = response.split('|');
					if ($.trim(get_notification[0]) == '1')
					{
						toastr.success(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
						location.reload();
					}
					else {
						toastr.error(get_notification[1], '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
					}
				});
		}
				return false;
	});
	$(document).on('click', '#submit_paid_alerts', function () {
		if( $('form#alert_job_form').smkValidate() ) {
			var freelanceAjaxURL = $("#freelance_ajax_url").val();
				$.post(freelanceAjaxURL, {
					action: 'job_alert_paid_subscription',
					submit_alert_data: $("form#alert_job_form").serialize(),
					security:$('#gen_nonce').val(),
				}).done(function (response) {
					var get_r = response.split('|');
					if ($.trim(response) == '1') {
						setTimeout(function () {
							location.reload();
						}, 2000);
					} else if ($.trim(response) == '2') {
						toastr.warning($('#demo_mode').val(), '', {
							timeOut: 2500,
							"closeButton": true,
							"positionClass": "toast-top-right"
						});
					} else if ($.trim(response) == '3') {
						toastr.warning($('#not_log_in').val(), '', {
							timeOut: 2500,
							"closeButton": true,
							"positionClass": "toast-top-right"
						});
					} else if ($.trim(response) == '4') {
						toastr.warning($('#not_cand').val(), '', {
							timeOut: 2500,
							"closeButton": true,
							"positionClass": "toast-top-right"
						});
					} else if ($.trim(get_r[0]) == '1') {
						toastr.success(get_r[1], '', {
							timeOut: 2500,
							"closeButton": true,
							"positionClass": "toast-top-right"
						});
						window.location = get_r[2];
					} else {
						toastr.error(response, '', {
							timeOut: 2500,
							"closeButton": true,
							"positionClass": "toast-top-right"
						});
					}
				});
				return false;
		}
	});
	/* Candidate Deleting Saved alerts */
	$(".del_save_alert").on("click", function () {
		var alert_id = $(this).attr("data-value");
	
		$.confirm({
			title: localize_vars.Msgconfirm,
			content: localize_vars.AreYouSure,
			type: 'green',
			theme: 'light',
			icon: 'mdi mdi-alert-outline ',
			buttons: {
				ok: {

					text: localize_vars.confimYes,
					btnClass: 'btn-primary',
					keys: ['enter'],
					action: function(){
						$('.loader-outer').show();
						var freelanceAjaxURL = $("#freelance_ajax_url").val();
						$.post(freelanceAjaxURL, {
							action: 'del_job_alerts',
							alert_id: alert_id,
						}).done(function (response) {
							$('.loader-outer').hide();
							if ( true === response.success )
							{
								toastr.success(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								$(".fas").addClass("fa-angle-right" );
								$(".fas").removeClass("fa-spinner fa-spin" );
								setTimeout(function(){
									location.reload(true);
								}, 600);
							}
							else
							{
								$(".fas").addClass("fa-angle-right" );
								$(".fas").removeClass("fa-spinner fa-spin" );
								toastr.error(response.data.message, '', {timeOut: 8000, "closeButton": true, "positionClass": "toast-top-right", "showMethod": "slideDown", "hideMethod":"slideUp"});
								$('.loader-outer').hide();
							}
						});
					}
				},
				cancel: {
					text: localize_vars.confimNo,
					action: function(){$('.loader-outer').hide(); }
				}
			}
		});
	});
	/* Candidate saving job alerts model*/
	$(".job_alert").click(function () {
		$('#job-alert-subscribtion').modal('show');
	});
	$(".show_detail_project").on( "click", function() {
		$('.detail_loader .loader-outer').show();
		var post_id = $(this).attr('data-post-id');
		$.post(localize_vars.freelanceAjaxurl, {action: 'fl_detail_search_page', post_id:post_id }).done(function (response)
		{
			$('.close_project_detail').css("display", "block");
			$('.exer-fr-dtl-main').css("display", "block");
			if ( true === response.success )
			{
				$('.detail_loader .loader-outer').hide();
				$(".exer-fr-dtl-main").html(response.data.html);
			}
			else
			{
				$('.detail_loader .loader-outer').hide();
				$(".exer-fr-dtl-main").html(response.data.html);
			}

		}).fail(function () {
		});
	});
	$(".close_project_detail").on("click",function(){
		$('.exer-fr-dtl-main').css("display", "none");
		$('.close_project_detail').css("display", "none");
	});
	$(document).on('change', '#alert_sub_cat', function() {
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
		$('#get_child_lev1').hide();
		$('#get_child_lev2').hide();
		$('#get_child_lev5').hide();
		$('#job_alerts').attr('disabled','disabled');
		$('#submit_paid_alerts').attr('disabled','disabled');
		var cat_s_id = $(this).val();
		$.post(freelanceAjaxURL, {
			action: 'get_child_lev1',
			cat_id: cat_s_id,
		}).done(function (response) {
			$('#get_child_lev1').show();
			$('#get_child_lev1').html(response);
			$('.questions-category').select2({ width:'100%',placeholder: "Select an Option",allowClear: true});
			$('.alerts_limit').removeClass('none');
			$('.alerts_price').removeClass('none');
			$('#job_alerts').removeAttr('disabled');
			$('#submit_paid_alerts').removeAttr('disabled');
			$('#job_alerts').show();
			$('#get_cat_val').val(cat_s_id);
		});
	});
	$(document).on('change', '#child_lev1', function () {
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
		$('#get_child_lev2').hide();
		$('#get_child_lev3').hide();
		$('#job_alerts').attr('disabled','disabled');
		$('#submit_paid_alerts').attr('disabled','disabled');
		var cat_s_id = $(this).val();
		$.post(freelanceAjaxURL, {
			action: 'get_child_lev2',
			cat_id: cat_s_id,
		}).done(function (response) {
			$('.cp-loader').hide();
			$('#get_child_lev2').show();
			$('#get_child_lev2').html(response);
			$('.search-select').select2({ width:'100%',placeholder: "Select an Option",allowClear: true});
			$('#job_alerts').removeAttr('disabled');
			$('#submit_paid_alerts').removeAttr('disabled');
			$('#get_cat_val').val(cat_s_id);
		});
	});
	$(document).on('change', '#child_lev2', function () {
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
		$('#get_child_lev5').hide();
		$('#job_alerts').attr('disabled','disabled');
		$('#submit_paid_alerts').attr('disabled','disabled');
		var cat_s_id = $(this).val();
		$.post(freelanceAjaxURL, {
			action: 'get_child_lev3',
			cat_id: cat_s_id,
		}).done(function (response) {
			$('.cp-loader').hide();
			$('#get_child_lev5').show();
			$('#get_child_lev5').html(response);
			$('.search-select').select2({ width:'100%',placeholder: "Select an Option",allowClear: true});
			$('#job_alerts').removeAttr('disabled');
			$('#submit_paid_alerts').removeAttr('disabled');
			$('#get_cat_val').val(cat_s_id);
		});
	});
	$(document).on('change', '#get_child_lev3', function () {
		var cat_s_id = $(this).val();
		var freelanceAjaxURL = $("#freelance_ajax_url").val();
		$.post(freelanceAjaxURL, {
			action: 'get_child_lev4',
			cat_id: cat_s_id,
		}).done(function (response) {
			$('#get_cat_val').val(response);
		});
	});


	
})(jQuery); 


