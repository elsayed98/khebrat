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

    // jQuery(document).ready(function($) {
    //     $('.next-step').click(function() {
    //     var currentStep = $(this).closest('.form-step');
    
    //     // فحص الحقول باستخدام smkValidate
    //     if (!currentStep.smkValidate()) {
    //         return;
    //     }
    
    //     var currentNum = currentStep.data('step');
    //     var nextNum = currentNum + 1;
    
    //     $('[data-step="' + currentNum + '"]').removeClass('active');
    //     $('[data-step="' + nextNum + '"]').addClass('active');
    //     });
    // });



if (document.querySelector('.wp-singular.page-template .step')) {
    console.log('الكلاس موجود في الصفحة');
    let currentStep = 0;
    const steps             = document.querySelectorAll('.step');
    const nextButtons       = document.querySelectorAll('.nextBtn');
    const prevButtons       = document.querySelectorAll('.prevBtn');




    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === stepIndex);
        });
    }

    nextButtons.forEach(button => {
        button.addEventListener('click', function() {
            const self = this;
            
            (function($){
                const $button = $(self);
                console.log($button.html());
                
                var checkFormSKM = $(button).closest('.step');
                if(!checkFormSKM.smkValidate()){
                    return;
                }
                else if(currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            })(jQuery)
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });



    showStep(currentStep);
    }