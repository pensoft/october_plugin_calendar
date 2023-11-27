<?php namespace Pensoft\Calendar;
/**
 * Created by PhpStorm.
 * Overwrited by Pensoft
 * User: Christoph Heich
 * Date: 02.06.2018
 * Time: 15:12
 */

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'      => 'Events',
            'icon'      => 'oc-icon-calendar-o',
            'author'    => 'Pensoft'
        ];
    }

    public $require = ['RainLab.Translate', 'Pensoft.Media'];

    public function registerComponents()
    {
        return [
            'Pensoft\Calendar\Components\Calendar' => 'calendar',
            'Pensoft\Calendar\Components\PastEvents' => 'PastEvents',
            'Pensoft\Calendar\Components\Timeline' => 'Timeline',
        ];
    }

    public function boot(){
        /* Extetions for revision */
        Revision::extend(function($model){
            /* Revison can access to the login user */
            $model->belongsTo['user'] = ['Backend\Models\User'];

            /* Revision can use diff function */
            $model->addDynamicMethod('getDiff', function() use ($model){
                return Diff::toHTML(Diff::compare($model->old_value, $model->new_value));
            });
        });
    }
}
