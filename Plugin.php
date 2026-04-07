<?php namespace Pensoft\Calendar;
/**
 * Created by PhpStorm.
 * Overwrited by Pensoft
 * User: Christoph Heich
 * Date: 02.06.2018
 * Time: 15:12
 */

use System\Classes\PluginBase;
use Pensoft\Calendar\Components\Calendar;
use Pensoft\Calendar\Components\EventList;
use Pensoft\Calendar\Components\EventHighlights;
use Pensoft\Calendar\Components\PastEvents;

class Plugin extends PluginBase
{

    public $require = ['RainLab.Translate', 'Pensoft.Media'];

    public function pluginDetails(): array
    {
        return [
            'name'      => 'Events',
            'icon'      => 'oc-icon-calendar-o',
            'author'    => 'Pensoft'
        ];
    }

    public function registerComponents(): array
    {
        return [
            Calendar::class => 'calendar',
            EventList::class => 'event_list',
            EventHighlights::class => 'event_highlights',
            PastEvents::class => 'PastEvents',
        ];
    }

    public function boot(): void {}

}