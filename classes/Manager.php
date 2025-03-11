<?php

namespace CodePros\RoboCall\Classes;

use Admin\Models\Orders_model;
use Aws\Credentials\Credentials;
use Aws\Sns\SnsClient;
use CodePros\RoboCall\Models\Settings;
use Igniter\Flame\Support\PagicHelper;
use Igniter\Flame\Support\StringParser;
use Igniter\Flame\Traits\Singleton;
use System\Helpers\ViewHelper;

class Manager
{
    use Singleton;

    public function run($to, $data, $object, $location = null): void
    {
        $settings = Settings::instance();

        $subject = $this->buildContent($settings->get('subject'), $data);
        $message = $this->buildContent($settings->get('message'), $data);

        if (!str_starts_with($to, '+'))
            $to = $settings->get('country_code') . $to;

        $phone = $location ? $location->location_telephone : '';
        if (!str_starts_with($phone, '+'))
            $phone = $settings->get('country_code') . $phone;

        $messageData = [
            'default' => $message,
            'order_id' => strval(($object instanceof Orders_model) ? $object->order_id : $object->id),
            'customer' => $object->customer_name,
            'restaurant_phone' => $phone,
            'restaurant_notification_phone' => $to
        ];

        $payload = [
            'Message' => json_encode($messageData),
            'Subject' => $subject,
            'TopicArn' => $settings->get('topic'),
        ];

        $credentials = new Credentials($settings->get('key'), $settings->get('secret'));
        $client = new SnsClient([
            'version' => 'latest',
            'region' => $settings->get('region'),
            'credentials' => $credentials,
            'use_aws_shared_config_files' => false,
        ]);
        $client->publish($payload);
    }

    public function buildContent($template, $data = []): string
    {
        $globalVars = ViewHelper::getGlobalVars();
        if (!empty($globalVars)) {
            $data = (array)$data + $globalVars;
        }

        $content = PagicHelper::parse($template, $data);

        $content = (new StringParser)->parse($content, $data);

        return html_entity_decode(preg_replace("/[\r\n]{2,}/", "\n\n", $content), ENT_QUOTES, 'UTF-8');
    }
}
