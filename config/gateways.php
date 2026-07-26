<?php

return [
    'drivers' => [
        'saman' => [
            'title' => 'درگاه پرداخت سامان',
            'fields' => [
                'merchantId'  => ['label' => 'general.gateway.fields.merchant_id', 'type' => 'text', 'required' => true],
                'password'    => ['label' => 'general.gateway.fields.password', 'type' => 'password', 'required' => true],
                'currency'    => ['label' => 'general.gateway.fields.currency', 'type' => 'text', 'required' => false ,'value'=> 'T'], // R/T
            ],
        ],

        'behpardakht' => [
            'title' => 'درگاه پرداخت ملت',
            'fields' => [
                'terminalId'  => ['label' => 'general.gateway.fields.terminal_id', 'type' => 'text', 'required' => true,],
                'username'    => ['label' => 'general.gateway.fields.username', 'type' => 'text', 'required' => true],
                'password'    => ['label' => 'general.gateway.fields.password', 'type' => 'password', 'required' => true],
                'currency'    => ['label' => 'general.gateway.fields.currency', 'type' => 'text', 'required' => false ,'value'=> 'T'],
                'cumulativeDynamicPayStatus' => ['label' => 'general.gateway.fields.cumulative_dynamic_pay_status', 'type' => 'select', 'required' => false, 'options' => [
                    0 => 'general.no',
                    1 => 'general.yes',
                ]],
            ],
        ],

        'zarinpal' => [
            'title' => 'درگاه پرداخت زرین پال',
            'fields' => [
                'mode'       => ['label' => 'general.gateway.fields.mode', 'type' => 'select', 'required' => true, 'options' => [
                    'normal'   => 'general.gateway.modes.normal',
                    'sandbox'  => 'general.gateway.modes.sandbox',
                    'zaringate' => 'general.gateway.modes.zaringate',
                ]],
                'merchantId'  => ['label' => 'general.gateway.fields.merchant_id', 'type' => 'text', 'required' => true],
                'currency'    => ['label' => 'general.gateway.fields.currency', 'type' => 'text', 'required' => false ,'value'=> 'T'],
            ],
        ],
    ],
];
