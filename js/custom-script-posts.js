(function ($) {
  $("#create_offer_btn").click(function () {
    if ($("form#offer_form").smkValidate()) {
      $(".loader-outer").show();
      $.post(localize_vars_frontend.freelanceAjaxurl, {
        action: "offer_services",
        offer_data: $("form#offer_form").serialize(),
        security: $("#create_offer_nonce").val(),
      })
        .done(function (response) {
          if (true === response.success) {
            toastr.success(response.data.message, "", {
              timeOut: 8000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
            setTimeout(function () {
              window.location.reload(); // إعادة تحميل نفس الصفحة
            }, 1000);
          } else {
            $(".loader-outer").hide();
            toastr.error(response.data.message, "", {
              timeOut: 8000,
              closeButton: true,
              positionClass: "toast-top-right",
            });
          }
        })
        .fail(function () {
          $(".loader-outer").hide();
          toastr.error("حدث خطأ أثناء المعالجة.", "", {
            timeOut: 8000,
            closeButton: true,
            positionClass: "toast-top-right",
          });
        });
    }
  });

  $(document).on("click", ".btn-offer-action", function (e) {
    e.preventDefault();

    let offerID = $(this).data("id");
    let actionType = $(this).data("action");

    let confirmTitle =
      actionType == "accept" ? "تأكيد قبول العرض" : "تأكيد رفض العرض";
    let confirmContent =
      actionType == "accept"
        ? "هل أنت متأكد أنك تريد قبول هذا العرض؟"
        : "هل أنت متأكد أنك تريد رفض هذا العرض؟";
    let confirmButton = actionType == "accept" ? "نعم، قبول" : "نعم، رفض";

    $.confirm({
      title: confirmTitle,
      content: confirmContent,
      type: actionType == "accept" ? "green" : "red",
      theme: "light",
      icon: "mdi mdi-alert-outline",
      buttons: {
        ok: {
          text: confirmButton,
          btnClass: "btn-primary",
          keys: ["enter"],
          action: function () {
            $(".loader-outer").show();

            $.post(localize_vars_frontend.freelanceAjaxurl, {
              action: "handle_offer_action",
              offer_id: offerID,
              action_type: actionType,
            })
              .done(function (response) {
                $(".loader-outer").hide();

                if (response.success) {
                  toastr.success(response.data.message, "", {
                    timeOut: 8000,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });

                  $("#offer-status-" + offerID).html(
                    '<div class="alert alert-' +
                      (actionType == "accept" ? "success" : "danger") +
                      '">' +
                      response.data.message +
                      "</div>"
                  );

                  $('.btn-offer-action[data-id="' + offerID + '"]').remove();
                } else {
                  toastr.error(response.data.message, "", {
                    timeOut: 8000,
                    closeButton: true,
                    positionClass: "toast-top-right",
                  });
                }
              })
              .fail(function () {
                $(".loader-outer").hide();
                toastr.error("حدث خطأ أثناء تنفيذ العملية.", "", {
                  timeOut: 8000,
                  closeButton: true,
                  positionClass: "toast-top-right",
                });
              });
          },
        },
        cancel: {
          text: "إلغاء",
          action: function () {},
        },
      },
    });
  });

  /*

  $(document).on("click", ".btn-start-consultation", function (e) {
    e.preventDefault();

    let postID = $(this).data("id");

    $.confirm({
      title: "تأكيد بدء الاستشارة",
      content: "هل أنت متأكد أنك تريد بدء هذه الاستشارة؟",
      type: "blue",
      theme: "light",
      icon: "mdi mdi-alert-outline",
      buttons: {
        ok: {
          text: "نعم، ابدأ",
          btnClass: "btn-primary",
          keys: ["enter"],
          action: function () {
            $(".loader-outer").show();

            $.post(localize_vars_frontend.freelanceAjaxurl, {
              action: "start_legal_consultation_action",
              post_id: postID,
            })
              .done(function (response) {
                $(".loader-outer").hide();

                if (response.success) {
                  toastr.success("تم بدء الاستشارة بنجاح", "", {
                    timeOut: 1000,
                    closeButton: true,
                    positionClass: "toast-top-right",
                    onHidden: function () {
                      location.reload();
                    },
                  });

                  $(
                    '.btn-start-consultation[data-id="' + postID + '"]'
                  ).remove();
                } else {
                  toastr.error(
                    response.data.message || "حدث خطأ أثناء بدء الاستشارة",
                    "",
                    {
                      timeOut: 5000,
                      closeButton: true,
                      positionClass: "toast-top-right",
                    }
                  );
                }
              })
              .fail(function () {
                $(".loader-outer").hide();
                toastr.error("فشل الاتصال بالخادم.", "", {
                  timeOut: 5000,
                  closeButton: true,
                  positionClass: "toast-top-right",
                });
              });
          },
        },
        cancel: {
          text: "إلغاء",
          action: function () {},
        },
      },
    });
  });
  */

  $(document).on("click", ".btn-consultation-action", function (e) {
    e.preventDefault();

    let postID = $(this).data("id");
    let newStatus = $(this).data("status");
    let postType = $(this).data("posttype");

    let confirmTitle =
      newStatus === "processing" ? "تأكيد البدء" : "تأكيد الإنهاء";

    let confirmContent = "";
    if (postType === "legal_consultation") {
      confirmContent =
        newStatus === "processing"
          ? "هل تريد بدء هذه الاستشارة؟"
          : "هل تريد إنهاء هذه الاستشارة؟";
    } else if (postType === "legal_services") {
      confirmContent =
        newStatus === "processing"
          ? "هل تريد بدء هذا الطلب؟"
          : "هل تريد إنهاء هذا الطلب؟";
    } else {
      confirmContent = "هل أنت متأكد؟";
    }

    let confirmButton = newStatus === "processing" ? "نعم، ابدأ" : "نعم، أنهِ";

    $.confirm({
      title: confirmTitle,
      content: confirmContent,
      type: "blue",
      theme: "light",
      icon: "mdi mdi-alert-outline",
      buttons: {
        ok: {
          text: confirmButton,
          btnClass: "btn-primary",
          action: function () {
            $(".loader-outer").show();

            $.post(localize_vars_frontend.freelanceAjaxurl, {
              action: "change_legal_consultation_status",
              post_id: postID,
              new_status: newStatus,
            })
              .done(function (response) {
                $(".loader-outer").hide();

                if (response.success) {
                  toastr.success(response.data.message, "", {
                    timeOut: 1000,
                    closeButton: true,
                    onHidden: function () {
                      location.reload();
                    },
                  });
                } else {
                  toastr.error(response.data.message, "", {
                    timeOut: 5000,
                    closeButton: true,
                  });
                }
              })
              .fail(function () {
                $(".loader-outer").hide();
                toastr.error("حدث خطأ أثناء العملية.", "", {
                  timeOut: 5000,
                  closeButton: true,
                });
              });
          },
        },
        cancel: {
          text: "إلغاء",
        },
      },
    });
  });
})(jQuery);
