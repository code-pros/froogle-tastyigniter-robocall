<?php

return [
    'form' => [
        'toolbar' => [
            'buttons' => [
                'back' => [
                    'label' => 'lang:admin::lang.button_icon_back',
                    'class' => 'btn btn-outline-secondary',
                    'href' => 'settings',
                ],
                'save' => ['label' => 'lang:admin::lang.button_save', 'class' => 'btn btn-primary', 'data-request' => 'onSave'],
                'saveClose' => [
                    'label' => 'lang:admin::lang.button_save_close',
                    'class' => 'btn btn-default',
                    'data-request' => 'onSave',
                    'data-request-data' => 'close:1',
                ],
            ],
        ],
        'fields' => [
            'is_enabled' => [
                'label' => 'lang:admin::lang.label_status',
                'type' => 'switch',
            ],
            'region' => [
                'label' => 'lang:codepros.robocall::default.settings.label_region',
                'span' => 'left',
                'type' => 'text',
                'comment' => 'lang:codepros.robocall::default.settings.help_region',
            ],
            'topic' => [
                'label' => 'lang:codepros.robocall::default.settings.label_topic',
                'span' => 'right',
                'type' => 'text',
                'comment' => 'lang:codepros.robocall::default.settings.help_topic',
            ],
            'key' => [
                'label' => 'lang:codepros.robocall::default.settings.label_key',
                'span' => 'left',
                'type' => 'text',
            ],
            'secret' => [
                'label' => 'lang:codepros.robocall::default.settings.label_secret',
                'span' => 'right',
                'type' => 'text',
            ],
            'separator' => [
                'label' => '<hr>',
                'type' => 'section',
            ],
            'subject' => [
                'label' => 'lang:codepros.robocall::default.settings.label_subject',
                'type' => 'textarea',
                'span' => 'left',
                'default' => '{{ $site_name }} Submitted Order #{{ $order_number }}',
            ],
            'message' => [
                'label' => 'lang:codepros.robocall::default.settings.label_message',
                'type' => 'textarea',
                'span' => 'right',
                'default' => 'An order for {{ $customer_name }} has been submitted. Its Order ID is #{{ $order_number }}',
            ],
            '_variables' => [
                'type' => 'partial',
                'path' => '~/app/system/views/mailtemplates/form/variables',
                'options' => [\System\Models\Mail_templates_model::class, 'getVariableOptions'],
            ],
            'footer' => [
                'label' => '<hr>',
                'type' => 'section',
            ],
            'country_code' => [
                'label' => 'lang:codepros.robocall::default.settings.label_country_code',
                'type' => 'text',
                'span' => 'left',
                'default' => '+1'
            ],
        ],
        'rules' => [
            ['region', 'lang:codepros.robocall::default.settings.label_region', 'required_if:is_enabled,1|string'],
            ['topic', 'lang:codepros.robocall::default.settings.label_topic', 'required_if:is_enabled,1|string'],
            ['key', 'lang:codepros.robocall::default.settings.label_key', 'required_if:is_enabled,1|string'],
            ['secret', 'lang:codepros.robocall::default.settings.label_secret', 'required_if:is_enabled,1|string'],
            ['subject', 'lang:codepros.robocall::default.settings.label_subject', 'required_if:is_enabled,1|string'],
            ['message', 'lang:codepros.robocall::default.settings.label_message', 'required_if:is_enabled,1|string'],
        ],
    ],
];
