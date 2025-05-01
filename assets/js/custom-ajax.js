jQuery(document).ready(function ($) {

  $("#create-edit-post-form").on("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this); // دعم رفع الملفات
    formData.append("action", "create_or_update_post");
    formData.append("security", ajax_object.nonce);

    $("#response-message").text("جاري إرسال البيانات...");

    $.ajax({
      url: ajax_object.ajax_url,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          $("#response-message").html(
            '<span style="color:green;">' + response.data + "</span>"
          );
          if (!$("#post-id").val()) {
            $("#create-edit-post-form")[0].reset(); // إعادة تعيين النموذج إذا كان إنشاء جديد
          }
        } else {
          $("#response-message").html(
            '<span style="color:red;">' + response.data + "</span>"
          );
        }

        setTimeout(() => {
          location.reload();
        }, 2000);
      },
      error: function () {
        $("#response-message").html(
          '<span style="color:red;">حدث خطأ أثناء الإرسال.</span>'
        );
      },
    });
  });


 // معاينة الصورة المصغرة عند اختيار ملف
 $('#upload-thumbnail').on('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#upload-thumbnail-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});

// معاينة صورة ACF عند اختيار ملف
$('#upload-acf-image').on('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#upload-acf-image-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});




















$("#custom-fields-form").on("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this); // دعم رفع الملفات
    formData.append("action", "update_profile");
    formData.append("security", ajax_object.nonce);

    $("#response-message").text("جاري إرسال البيانات...");

    $.ajax({
      url: ajax_object.ajax_url,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          $("#response-message").html(
            '<span style="color:green;">' + response.data + "</span>"
          );
          if (!$("#post-id").val()) {
            $("#custom-fields-form")[0].reset(); // إعادة تعيين النموذج إذا كان إنشاء جديد
          }
        } else {
          $("#response-message").html(
            '<span style="color:red;">' + response.data + "</span>"
          );
        }

        setTimeout(() => {
          location.reload();
        }, 2000);
      },
      error: function () {
        $("#response-message").html(
          '<span style="color:red;">حدث خطأ أثناء الإرسال.</span>'
        );
      },
    });
  });




// معاينة صورة ACF عند اختيار ملف
$('#uploadfile-1').on('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#uploadfile-1-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});















//vehicle_form

$("#vehicle_form").on("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this); // دعم رفع الملفات
    formData.append("action", "create_or_update_vehicle");
    formData.append("security", ajax_object.nonce);

    $("#response-message").text("جاري إرسال البيانات...");

    $.ajax({
      url: ajax_object.ajax_url,
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          $("#response-message").html(
            '<span style="color:green;">' + response.data + "</span>"
          );
          if (!$("#vehicle_id").val()) {
            $("#vehicle_form")[0].reset(); // إعادة تعيين النموذج إذا كان إنشاء جديد
          }
        } else {
          $("#response-message").html(
            '<span style="color:red;">' + response.data + "</span>"
          );
        }

        setTimeout(() => {
          location.reload();
        }, 2000);
      },
      error: function () {
        $("#response-message").html(
          '<span style="color:red;">حدث خطأ أثناء الإرسال.</span>'
        );
      },
    });
  });




// معاينة صورة ACF عند اختيار ملف
$('#uploadfile-1').on('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#uploadfile-1-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
});



});
