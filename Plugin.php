<?php namespace Graffon\Graffauth;

use System\Classes\PluginBase;
use Backend;

/**
 * Plugin class
 */
class Plugin extends PluginBase
{
    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
    }

    /**
     * registerSettings used by the backend.
     */
    // public function registerSettings()
    // {
    //     return [
    //         'settings' => [
    //             'label' => 'Graff Auth Settings',
    //             'description' => 'Manage API keys & APIs',
    //             'category' => 'Graff Auth',
    //             'icon' => 'icon-key',
    //             'class' => 'Graffon\GraffAuth\Controllers\Keys',
    //             'url' => Backend::url('graffon/graffauth/keys'),
    //         ]
    //     ];
    // }
}
