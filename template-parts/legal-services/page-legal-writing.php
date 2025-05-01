<?php
//صفحة - كتابات قانونية 


if (isset($_GET['service_type'])) {

    $service_type = $_GET['service_type'];

    if ($service_type == "lawsuit") {
        get_template_part('template-parts/legal-services/page-legal-writing/lawsuit');

    } elseif ($service_type == "reply_note") {
        get_template_part('template-parts/legal-services/page-legal-writing/reply-note');

    } elseif ($service_type == "response_memo") {
        get_template_part('template-parts/legal-services/page-legal-writing/response-memo');

    } elseif ($service_type == "objection") {
        get_template_part('template-parts/legal-services/page-legal-writing/objection');

    } elseif ($service_type == "appeal") {
        get_template_part('template-parts/legal-services/page-legal-writing/appeal');

    } elseif ($service_type == "petition") {
        get_template_part('template-parts/legal-services/page-legal-writing/petition');

    } elseif ($service_type == "general_letters") {
        get_template_part('template-parts/legal-services/page-legal-writing/general-letters');
    }

} else {
?>
    <section class="pt-0 pt-xl-5">
        <div class="container">
            <!-- Title -->
            <div class="row mb-3 mb-sm-4">
                <div class="col-12 text-center">
                    <h2>اختر نوع الخدمة</h2>
                </div>
            </div>
            <div class="mb-4">

                <div class="d-grid gap-3">
                    <div class="card card-body shadow p-4 h-100">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>?service_type=lawsuit" class="">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">صحيفة الدعوى</h6>
                                    <p class="text-muted small mb-0">ما يتم تقديمه إلى المحكمة المختصة وفقًا لأحكام قانون الإجراءات للحصول على الحق المدعوم بالسند أو الإثبات</p>
                                </div>
                                <div class="fs-4 text-primary">&#8592;</div>
                            </div>
                        </a>
                    </div>

                    <div class="card card-body shadow p-4 h-100">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>?service_type=reply_note" class="">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">مذكرة رد على الدعوى</h6>
                                    <p class="text-muted small mb-0">وثيقة قانونية مكتوبة للرد على الدعوى المقامة ضدك أمام المحكمة المختصة بعد الاستماع أو الإطلاع على الدعوى في الجلسة الأولى</p>
                                </div>
                                <div class="fs-4 text-primary">&#8592;</div>
                            </div>
                        </a>
                    </div>
                    <div class="card card-body shadow p-4 h-100">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>?service_type=response_memo" class="">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">مذكرة رد جوابية</h6>
                                    <p class="text-muted small mb-0">وثيقة قانونية مكتوبة لتبادل الردود والدفاع والشرح بين أطراف القضية أو إجابة لطلبات القاضي في الجلسات المتقدمة</p>
                                </div>
                                <div class="fs-4 text-primary">&#8592;</div>
                            </div>
                        </a>
                    </div>

                    <div class="card card-body shadow p-4 h-100">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>?service_type=objection" class="">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">لائحة اعتراض</h6>
                                    <p class="text-muted small mb-0">وثيقة قانونية مكتوبة للرد على الدعوى المقامة ضدك أمام المحكمة المختصة بعد الاستماع أو الاطلاع على الدعوى في الجلسة الأولى</p>
                                </div>
                                <div class="fs-4 text-primary">&#8592;</div>
                            </div>
                        </a>
                    </div>
                    <div class="card card-body shadow p-4 h-100">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>?service_type=appeal" class="">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">لائحة نقض</h6>
                                    <p class="text-muted small mb-0">لائحة يتم تقديمها للمحكمة العليا لنقض الحكم الذي صدر من محاكم الاستئناف خلال المدة المحددة نظامًا من تاريخ صدور الحكم</p>
                                </div>
                                <div class="fs-4 text-primary">&#8592;</div>
                            </div>
                        </a>
                    </div>
                    <div class="card card-body shadow p-4 h-100">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>?service_type=petition" class="">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">لائحة التماس</h6>
                                    <p class="text-muted small mb-0">لائحة يتم تقديمها لإعادة النظر في القضية بعد ظهور أحداث لم تكن موجودة قبل إصدار الحكم النهائي ويجب أن تكون هذه الاحداث مطابقة للمادة 200 و 201 من نظام المرافعات الشرعية</p>
                                </div>
                                <div class="fs-4 text-primary">&#8592;</div>
                            </div>
                        </a>
                    </div>

                    <div class="card card-body shadow p-4 h-100">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>?service_type=general_letters" class="">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1">خطابات عامة</h6>
                                    <p class="text-muted small mb-0">الخطابات القانونية العامة الموجهة للأفراد، المنشآت او الجهات الحكومية والمصاغة بطريقة قانونية سليمة لأداء الغرض المطلوب من تقديمها.</p>
                                </div>
                                <div class="fs-4 text-primary">&#8592;</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </section>
<?php
}
?>




