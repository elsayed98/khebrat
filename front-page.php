<?php
/* Template Name: Home Page */

/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Exertio
 */


    // hatem_debug(Hatem_get_post_withFilds());
?>


<?php get_header(); ?>
<?php
if (have_posts()) {
?>


    <section class="pt-0 pt-md-6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bg-light p-4 p-sm-5 rounded-3 position-relative overflow-hidden">
                        <!-- SVG decoration -->
                        <figure class="position-absolute top-0 start-0 d-none d-lg-block ms-n7">
                            <svg width="294.5px" height="261.6px" viewBox="0 0 294.5 261.6" style="enable-background:new 0 0 294.5 261.6;">
                                <path class="fill-warning opacity-5" d="M280.7,84.9c-4.6-9.5-10.1-18.6-16.4-27.2c-18.4-25.2-44.9-45.3-76-54.2c-31.7-9.1-67.7-0.2-93.1,21.6 C82,36.4,71.9,50.6,65.4,66.3c-4.6,11.1-9.5,22.3-17.2,31.8c-6.8,8.3-15.6,15-22.8,23C10.4,137.6-0.1,157.2,0,179 c0.1,28,11.4,64.6,40.4,76.7c23.9,10,50.7-3.1,75.4-4.7c23.1-1.5,43.1,10.4,65.5,10.6c53.4,0.6,97.8-42,109.7-90.4 C298.5,140.9,293.4,111.5,280.7,84.9z"></path>
                            </svg>
                        </figure>
                        <!-- SVG decoration -->
                        <figure class="position-absolute top-50 start-50 translate-middle">
                            <svg width="453px" height="211px">
                                <path class="fill-orange" d="M16.002,8.001 C16.002,12.420 12.420,16.002 8.001,16.002 C3.582,16.002 -0.000,12.420 -0.000,8.001 C-0.000,3.582 3.582,-0.000 8.001,-0.000 C12.420,-0.000 16.002,3.582 16.002,8.001 Z"></path>
                                <path class="fill-warning" d="M176.227,203.296 C176.227,207.326 172.819,210.593 168.614,210.593 C164.409,210.593 161.000,207.326 161.000,203.296 C161.000,199.266 164.409,196.000 168.614,196.000 C172.819,196.000 176.227,199.266 176.227,203.296 Z"></path>
                                <path class="fill-primary" d="M453.002,65.001 C453.002,69.420 449.420,73.002 445.001,73.002 C440.582,73.002 437.000,69.420 437.000,65.001 C437.000,60.582 440.582,57.000 445.001,57.000 C449.420,57.000 453.002,60.582 453.002,65.001 Z"></path>
                            </svg>
                        </figure>
                        <!-- SVG decoration -->
                        <figure class="position-absolute top-0 end-0 mt-5 me-n5 d-none d-sm-block">
                            <svg width="285px" height="272px">
                                <path class="fill-info opacity-4" d="M142.500,-0.000 C221.200,-0.000 285.000,60.889 285.000,136.000 C285.000,211.111 221.200,272.000 142.500,272.000 C63.799,272.000 -0.000,211.111 -0.000,136.000 C-0.000,60.889 63.799,-0.000 142.500,-0.000 Z"></path>
                            </svg>
                        </figure>

                        <div class="col-11 mx-auto position-relative">
                            <div class="row align-items-center">
                                <!-- Title -->
                                <div class="col-lg-8">
                                    <div class="badge text-bg-success mb-2">نشط</div>

                                    <div class="d-flex align-items-center justify-content-between">
                                        <h3>81+</h3>
                                        <ul class="avatar-group mb-2 mb-sm-0">
                                            <li class="avatar avatar-xs">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/01.jpg" alt="avatar">
                                            </li>
                                            <li class="avatar avatar-xs">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt="avatar">
                                            </li>
                                            <li class="avatar avatar-xs">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="avatar">
                                            </li>
                                            <li class="avatar avatar-xs">
                                                <img class="avatar-img rounded-circle" src="assets/images/avatar/06.jpg" alt="avatar">
                                            </li>
                                            <li class="avatar avatar-xs">
                                                <div class="avatar-img rounded-circle bg-primary">
                                                    <span class="text-white position-absolute top-50 start-50 translate-middle small">1K+</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="mb-3 mb-lg-0">وأكثر محامي متاح الان يمكنهم مساعدتك</p>

                                </div>
                                <!-- Content and input -->
                                <div class="col-lg-4 text-lg-end">
                                    <a href="#" class="btn btn-warning mb-0">ابدا الان</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-2">
        <div class="container position-relative">
            <div class="row">
                <h3>الاستشارات القانونية</h3>

                <div class="col-12">
                    <!-- SVG decoration START -->
                    <figure class="position-absolute top-50 start-50 translate-middle ms-2">
                        <svg>
                            <path class="fill-white opacity-2" d="m496 22.999c0 10.493-8.506 18.999-18.999 18.999s-19-8.506-19-18.999 8.507-18.999 19-18.999 18.999 8.506 18.999 18.999z"></path>
                            <path class="fill-white opacity-2" d="m775 102.5c0 5.799-4.701 10.5-10.5 10.5-5.798 0-10.499-4.701-10.499-10.5 0-5.798 4.701-10.499 10.499-10.499 5.799 0 10.5 4.701 10.5 10.499z"></path>
                            <path class="fill-white opacity-2" d="m192 102c0 6.626-5.373 11.999-12 11.999s-11.999-5.373-11.999-11.999c0-6.628 5.372-12 11.999-12s12 5.372 12 12z"></path>
                            <path class="fill-white opacity-2" d="m20.499 10.25c0 5.66-4.589 10.249-10.25 10.249-5.66 0-10.249-4.589-10.249-10.249-0-5.661 4.589-10.25 10.249-10.25 5.661-0 10.25 4.589 10.25 10.25z"></path>
                        </svg>
                    </figure>
                    <!-- SVG decoration END -->

                    <div class="bg-dark p-4 p-sm-5 rounded-3">
                        <div class="row justify-content-center position-relative">
                            <!-- Svg decoration START -->
                            <figure class="fill-white opacity-1 position-absolute top-50 start-0 translate-middle-y">
                                <svg width="141px" height="141px">
                                    <path d="M140.520,70.258 C140.520,109.064 109.062,140.519 70.258,140.519 C31.454,140.519 -0.004,109.064 -0.004,70.258 C-0.004,31.455 31.454,-0.003 70.258,-0.003 C109.062,-0.003 140.520,31.455 140.520,70.258 Z"></path>
                                </svg>
                            </figure>
                            <!-- SVG decoration END -->

                            <!-- Action box -->
                            <div class="col-11 position-relative">
                                <div class="row align-items-center">
                                    <!-- Title -->
                                    <div class="col-lg-7">
                                        <h3 class="text-white mb-0">استشارة جديدة</h3>
                                        <p class="text-white small">شاور مع محامي في موضوع معين سواء عبر المحادثه النصية أو الاتصال الصوتي / المرئي</p>

                                    </div>
                                    <!-- Content and input -->
                                    <div class="col-lg-5 text-lg-end mt-3 mt-lg-0">
                                        <button type="button" class="btn btn-warning mb-0" data-bs-toggle="modal" data-bs-target="#bottomModal">ابدا الان</button>
                                    </div>
                                </div> <!-- Row END -->
                            </div>
                        </div>
                    </div>






                </div>
            </div> <!-- Row END -->
        </div>
    </section>
    <style>
        /* تعديل لتثبيت المودال في الأسفل */
        .modal-bottom-sheet {
            position: fixed;
            bottom: 0;
            margin: 0;
            width: 100%;
            max-width: 100%;
            transform: translateY(100%);
            transition: transform 0.4s ease;
        }

        /* عند العرض */
        .modal.fade.show .modal-bottom-sheet {
            transform: translateY(33vh);
            /* 100% - 66vh = يظهر 2/3 */
        }

        /* جعل المحتوى يأخذ 2/3 من ارتفاع الشاشة */
        .modal-content {
            height: 66vh;
            border-radius: 16px 16px 0 0;
            overflow-y: auto;
        }

        /* تحكم في الدخول من الأسفل */
        .modal.fade .modal-dialog {
            transform: translateY(100%);
        }

        .modal.fade.show .modal-dialog {
            transform: translateY(0);
        }
    </style>

    <!-- المودال -->
    <div class="modal fade" id="bottomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-sm-down modal-bottom-sheet">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">كيف تود طلب الخدمة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container mt-4">
                        <div class="row g-4">
                            <!-- الكارت الأول -->
                            <div class="col-md-6">
                                <div class="border rounded-3 p-4 h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="fw-bold mb-0">عن طريق محادثه نصيه</h5>
                                            <i class="bi bi-chat-right-text-fill fs-4 text-secondary"></i>
                                        </div>
                                        <p class="mb-3">
                                            لطلب استشارة قانونية وطرح الأسئلة في موضوع معين بمحادثة نصية. المحادثة تدعم الرسائل الكتابية والرسائل الصوتية وإرسال الصور والمستندات ولا تدعم الاتصال.
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">تبدأ من 100 ر.س</span>
                                        <a href="#" class="text-primary text-decoration-none">
                                            <i class="bi bi-arrow-left ms-1"></i>ابدأ الآن
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- الكارت الثاني -->
                            <div class="col-md-6">
                                <div class="border rounded-3 p-4 h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h5 class="fw-bold mb-0">جلسه صوتيه/ مرئيه فوريه</h5>
                                            <i class="bi bi-camera-video-fill fs-4 text-secondary"></i>
                                        </div>
                                        <p class="mb-3">
                                            للتحدث مع محامي/محامية عبر اتصال صوتي أو مرئي بشكل فوري، وطرح الأسئلة ومناقشتها في موضوع معين. سيتم توصيلك مع أول محامي متاح مناسب لموضوعك.
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted">تبدأ من 150 ر.س</span>
                                        <a href="#" class="text-primary text-decoration-none">
                                            <i class="bi bi-arrow-left ms-1"></i>ابدأ الآن
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section>
        <div class="container">
            <h3>خدمات اخري</h3>
            <div class="row g-4">


                <!-- Category item -->
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card card-body shadow rounded-3">
                        <div class="d-flex align-items-center">
                            <!-- Icon -->
                            <div class="icon-lg  bg-opacity-10 rounded-circle text-primary"><i class="fas fa-business-time"></i></div>
                            <div class="ms-3">
                                <h5 class="mb-0"><a  href="<?php echo get_page_link(31) ?>" class="stretched-link">دارسة قضاية</a></h5>
                                <p class="small">اذا كان موضعك يحتوي علي الكثير من التفاصيل و العقود و المرفقات و صكوك الاحكام المطلوب دراستها للوصول للاجابات التي تحتاجها. و تحتاج اجابات دقيقة بخصوص موضوعك.</p>
                                <span>تبدا من 500 ر.س</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card card-body shadow rounded-3">
                        <div class="d-flex align-items-center">
                            <!-- Icon -->
                            <div class="icon-lg  bg-opacity-10 rounded-circle text-primary"><i class="fas fa-business-time"></i></div>
                            <div class="ms-3">
                                <h5 class="mb-0"><a  href="<?php echo get_page_link(80) ?>" class="stretched-link">حضور الجلسات </a></h5>
                                <p class="small">اذا كنت مشغول, حصل لك ظرف او ما عندك رغبة تحضر الجلسة لاي سبب كان. وكل محامي/ة يحضر  الجلسة عندك</p>
                                <span>تبدا من 500  <?php echo do_shortcode( '[hatem_sar_sb]' ) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card card-body shadow rounded-3">
                        <div class="d-flex align-items-center">
                            <!-- Icon -->
                            <div class="icon-lg  bg-opacity-10 rounded-circle text-primary"><i class="fas fa-business-time"></i></div>
                            <div class="ms-3">
                                <h5 class="mb-0"><a  href="<?php echo get_page_link(82) ?>" class="stretched-link"><?php echo get_the_title(82) ?></a></h5>
                                <p class="small">صياغة اللوائح و المذكرات الجوابية الاعتراضية وصحائف الدعوي و النقض الاتماس و غيرها من الخطابات بطريقة قانونية سليمة</p>
                                <span>تبدا من 500  <?php echo do_shortcode( '[hatem_sar_sb]' ) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card card-body shadow rounded-3">
                        <div class="d-flex align-items-center">
                            <!-- Icon -->
                            <div class="icon-lg  bg-opacity-10 rounded-circle text-primary"><i class="fas fa-business-time"></i></div>
                            <div class="ms-3">
                                <h5 class="mb-0"><a  href="<?php echo get_page_link(84) ?>" class="stretched-link">طلبات التنفيذ</a></h5>
                                <p class="small">رفع طلب التنفيذ و/ أو متابعة الاجراءات حتي اخر اجراء صد المنفذ ضده امام محكمة التنفيذ</p>
                                <span>تبدا من 500  <?php echo do_shortcode( '[hatem_sar_sb]' ) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card card-body shadow rounded-3">
                        <div class="d-flex align-items-center">
                            <!-- Icon -->
                            <div class="icon-lg  bg-opacity-10 rounded-circle text-primary"><i class="fas fa-business-time"></i></div>
                            <div class="ms-3">
                                <h5 class="mb-0"><a  href="<?php echo get_page_link(87) ?>" class="stretched-link">العقود و الاتفاقات</a></h5>
                                <p class="small">العقد شريعة المتعاقدين , صياغة و مراجعة العقود و الاتفاقيات و دراسة العقود و البحث في امكانية فسخها</p>
                                <span>تبدا من 500  <?php echo do_shortcode( '[hatem_sar_sb]' ) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card card-body shadow rounded-3">
                        <div class="d-flex align-items-center">
                            <!-- Icon -->
                            <div class="icon-lg  bg-opacity-10 rounded-circle text-primary"><i class="fas fa-business-time"></i></div>
                            <div class="ms-3">
                                <h5 class="mb-0"><a  href="<?php echo get_page_link(89) ?>" class="stretched-link">تسجيل العلامات التجارية</a></h5>
                                <p class="small">تقديم طلب تسجيل علامة تجارية للهئية السعودية للملكية الفكرية و متابعة الطلب حتي يتم النشر</p>
                                <span>تبدا من 500  <?php echo do_shortcode( '[hatem_sar_sb]' ) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card card-body shadow rounded-3">
                        <div class="d-flex align-items-center">
                            <!-- Icon -->
                            <div class="icon-lg  bg-opacity-10 rounded-circle text-primary"><i class="fas fa-business-time"></i></div>
                            <div class="ms-3">
                                <h5 class="mb-0"><a  href="<?php echo get_page_link(93) ?>" class="stretched-link">خدمات اخري</a></h5>
                                <p class="small">اي خدمات قانوية اخري ترغب في توكيلها للمحامي او الحصول عليها من محامي, قم بطرح موضوعك هنا و حدد نوع الخدمة المطلوبة </p>
                                <span>تبدا من 500  <?php echo do_shortcode( '[hatem_sar_sb]' ) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php
    the_post();
    the_content();
}
?>
<?php get_footer(); ?>