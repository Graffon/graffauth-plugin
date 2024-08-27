<?php namespace Graffon\Graffauth\Controllers;

use Backend;
use BackendMenu;
use Graffon\Graffauth\Models\Key;
use Backend\Classes\SettingsController;
use Illuminate\Support\Facades\Hash;

class Keys extends SettingsController
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    /**
     * @var string formConfig file
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var string settingsItemCode determines the settings code
     */
    public $settingsItemCode = 'graffauth';

}
