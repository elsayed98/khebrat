/*
document.getElementById('custom-fields-form').addEventListener('submit', function(e) {
  e.preventDefault(); // منع الإرسال الافتراضي للنموذج

  const form = e.target;
  const formData = new FormData(form);

  fetch(window.location.href, {
          method: 'POST',
          body: formData,
      })
      .then(response => response.text())
      .then(responseText => {
          // عرض رسالة النجاح
          const message = document.getElementById('success-message');
          message.style.display = 'block';

          // تحديث الصفحة بعد بضع ثوانٍ
          setTimeout(() => {
              location.reload();
          }, 2000);
      })
      .catch(error => {
          alert('حدث خطأ أثناء الحفظ. حاول مرة أخرى.');
          console.error(error);
      });
});


document.getElementById('uploadfile-1').addEventListener('change', function(event) {
  const fileInput = event.target;
  const file = fileInput.files[0];

  if (file) {
      const reader = new FileReader();

      // تحميل الصورة الجديدة في العنصر <img>
      reader.onload = function(e) {
          document.getElementById('uploadfile-1-preview').src = e.target.result;
      };

      reader.readAsDataURL(file);
  }
});


*/