<?php

return [
    'mode' => 'utf-8',
    'format' => 'a4',
    'author' => '',
    'subject' => '',
    'keywords' => '',
    'creator' => 'Laravel Pdf',
    'display_mode' => 'fullpage',
//	'tempDir'               => base_path('../temp/'),
    'tempDir' => public_path('temp'),
    'font_path' => base_path('storage/fonts/'),
    'font_data' => [
        'bangla' => [
            'R' => 'SolaimanLipi.ttf',    // regular font
            'B' => 'SolaimanLipi.ttf',       // optional: bold font
            'I' => 'SolaimanLipi.ttf',     // optional: italic font
            'BI' => 'SolaimanLipi.ttf', // optional: bold-italic font
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ]
    ],
    'default_font'=>'bangla',



];
