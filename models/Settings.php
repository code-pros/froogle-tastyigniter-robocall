<?php

namespace CodePros\RoboCall\Models;

use Igniter\Flame\Database\Model;

/**
 * @method static instance()
 */
class Settings extends Model
{
    public $implement = [\System\Actions\SettingsModel::class];

    public string $settingsCode = 'robocall_settings';

    public string $settingsFieldsConfig = 'settings';
}
