<?php
return [
    'adminEmail' => 'admin@example.com',
    'params' => [
        'bsDependencyEnabled' => false, // this will not load Bootstrap CSS and JS for all Krajee extensions
        // you need to ensure you load the Bootstrap CSS/JS manually in your view layout before Krajee CSS/JS assets
        //
        // other params settings below
        'bsVersion' => '4.x',
        // 'adminEmail' => 'admin@example.com'
    ]
];
