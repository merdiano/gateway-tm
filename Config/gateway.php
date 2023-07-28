<?php
return [
    "http_client" => [
        "timeout"         => 60,//sec,
        "connect_timeout" => 60,
        "verify"          => true,
    ],
    "clients" => [
        "altyn-asyr"      => [
            "code"        => "altyn-asyr",
            "title"       => "gateway::app.altyn-asyr.title",
            "class"       => \Merdiano\Payment\Gateways\AltynAsyr::class,
            "active"      => true,
            "user"        => env('ALTYN_ASYR_USER'),
            "password"    => env('ALTYN_ASYR_PASSWORD'),
            "api"         => env('ALTYN_ASYR_API'),
            "order_uri"   => env('ALTYN_ASYR_ORDER_URI','register.do'),
            "status_uri"  => env('ALTYN_ASYR_STATUS_URI','getOrderStatus.do')
        ],
        "rysgal"          => [
            "code"        => "rysgal",
            "title"       => "gateway::app.rysgal.title",
            "class"       => \Merdiano\Payment\Gateways\Rysgalbank::class,
            "active"      => true,
            "user"        => env('RYSGAL_USER'),
            "password"    => env('RYSGAL_PASSWORD'),
            "api"         => env('RYSGAL_API'),
            "order_uri"   => env('RYSGAL_ORDER_URI','register.do'),
            "status_uri"  => env('RYSGAL_STATUS_URI','getOrderStatus.do')
        ],
        "senagat"         => [
            "code"        => "senagat",
            "title"       => "gateway::app.senagat.title",
            "class"       => \Merdiano\Payment\Gateways\Senagat::class,
            "active"      => true,
            "user"        => env('SENAGAT_USER'),
            "password"    => env('SENAGAT_PASSWORD'),
            "api"         => env('SENAGAT_API'),
            "order_uri"   => env('SENAGAT_ORDER_URI','register.do'),
            "status_uri"  => env('SENAGAT_STATUS_URI','getOrderStatus.do')
        ]
    ]
];
