<?php

return [

    'admin_email' => env('ENQUIRY_ADMIN_EMAIL', env('MAIL_FROM_ADDRESS')),

    'queue_connection' => env('ENQUIRY_QUEUE_CONNECTION', env('QUEUE_CONNECTION', 'redis')),

];
