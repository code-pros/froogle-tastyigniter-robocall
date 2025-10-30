<?php

namespace CodePros\RoboCall\Models;

class Settings extends \Igniter\Flame\Database\Model
{
    public array $implement = [\Igniter\System\Actions\SettingsModel::class];

    public string $settingsCode = 'robocall_settings';

    public string $settingsFieldsConfig = 'settings';
}
