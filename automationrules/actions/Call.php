<?php

namespace CodePros\RoboCall\AutomationRules\Actions;

use CodePros\RoboCall\Classes\Manager;
use CodePros\RoboCall\Models\Settings;
use Igniter\Automation\Classes\BaseAction;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Database\Eloquent\Model;

class Call extends BaseAction
{
    public function actionDetails(): array
    {
        return [
            'name' => 'Robo Call',
            'description' => 'Calls the specified recipient on the phone',
        ];
    }

    public function defineFormFields(): array
    {
        return [
            'fields' => [
                'call_to' => [
                    'label' => 'codepros.robocall::default.label_call_to',
                    'type' => 'select',
                ],
                'custom' => [
                    'label' => 'codepros.robocall::default.label_call_to_custom',
                    'type' => 'text',
                    'trigger' => [
                        'action' => 'show',
                        'field' => 'call_to',
                        'condition' => 'value[custom]',
                    ],
                ],
            ],
        ];
    }

    public function getCallToOptions(): array
    {
        return [
            'location' => 'codepros.robocall::default.text_call_to_location_tel',
            'customer' => 'codepros.robocall::default.text_call_to_customer_tel',
            'order' => 'codepros.robocall::default.text_call_to_order_tel',
            'reservation' => 'codepros.robocall::default.text_call_to_reservation_tel',
            'custom' => 'codepros.robocall::default.text_call_to_custom_tel',
        ];
    }

    public function triggerAction($params): void
    {
        if (!(bool)Settings::get('is_enabled', false))
            return;

        if (!$object = $this->shouldTrigger($params))
            return;

        if (!$callToNumber = $this->getRecipientAddress($object))
            throw new ApplicationException('RoboCall: Missing a valid call to number from the event payload');

        Manager::instance()->run($callToNumber, $params, $object, $object->location);
    }

    protected function shouldTrigger($params): Model|false
    {
        $object = array_get($params, 'order', array_get($params, 'reservation'));

        return $object instanceof Model ? $object : false;
    }

    protected function getRecipientAddress($object)
    {
        $mode = $this->model->call_to;

        switch ($mode) {
            case 'custom':
                return $this->model->custom;
            case 'location':
                return optional($object->location)->location_telephone;
            case 'customer':
                return optional($object->customer)->telephone ?? $object->telephone;
            case 'order':
            case 'reservation':
                return $object->telephone;
        }
    }
}
