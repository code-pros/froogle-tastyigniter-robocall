<?php

namespace CodePros\RoboCall;

use Igniter\System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function registerPermissions(): array
    {
        return [
            'CodePros.RoboCall.Manage' => [
                'description' => 'Manage RoboCall settings',
                'group' => 'igniter::admin.permissions.name',
            ],
        ];
    }

    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label' => 'lang:codepros.robocall::default.text_settings',
                'icon' => 'fa fa-phone',
                'description' => 'lang:codepros.robocall::default.text_settings_description',
                'model' => \CodePros\RoboCall\Models\Settings::class,
                'permissions' => ['CodePros.RoboCall.Manage'],
            ],
        ];
    }

    public function registerAutomationRules(): array
    {
        return [
            'events' => [],
            'actions' => [
                \CodePros\RoboCall\AutomationRules\Actions\Call::class,
            ],
            'conditions' => [],
            'presets' => [
                'robocall_new_order_placed' => [
                    'name' => 'Call restaurant manager when new order placed',
                    'event' => \Igniter\Cart\AutomationRules\Events\OrderPlaced::class,
                    'actions' => [
                        \CodePros\RoboCall\AutomationRules\Actions\Call::class => [
                            'call_to' => 'location',
                        ],
                    ],
                ],
            ],
        ];
    }
}
