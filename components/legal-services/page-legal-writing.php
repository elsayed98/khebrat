<?php

//صفحة - كتابات قانونية 


$service_type_writing = get_post_meta(get_the_ID(), '_service_type_writing', true);

if ($service_type_writing == "lawsuit") {
    get_template_part('components/legal-services/page-legal-writing/lawsuit');
} elseif ($service_type_writing == "reply_note") {
    get_template_part('components/legal-services/page-legal-writing/reply-note');
} elseif ($service_type_writing == "response_memo") {
    get_template_part('components/legal-services/page-legal-writing/response-memo');
} elseif ($service_type_writing == "objection") {
    get_template_part('components/legal-services/page-legal-writing/objection');
} elseif ($service_type_writing == "appeal") {
    get_template_part('components/legal-services/page-legal-writing/appeal');
} elseif ($service_type_writing == "petition") {
    get_template_part('components/legal-services/page-legal-writing/petition');
} elseif ($service_type_writing == "general_letters") {
    get_template_part('components/legal-services/page-legal-writing/general-letters');
} else {
}
