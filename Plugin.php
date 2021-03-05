<?php namespace Pensoft\Calendar;
/**
 * Created by PhpStorm.
 * User: Christoph Heich
 * Date: 02.06.2018
 * Time: 15:12
 */

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Pensoft\Calendar\Components\Calendar' => 'calendar',
            'Pensoft\Calendar\Components\PastEvents' => 'PastEvents',
            'Pensoft\Calendar\Components\Timeline' => 'Timeline',
        ];
    }

    public function registerSettings()
    {

    }
}
