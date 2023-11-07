<?php namespace Pensoft\Calendar;
/**
 * Created by PhpStorm.
 * Overwrited by Pensoft
 * User: Christoph Heich
 * Date: 02.06.2018
 * Time: 15:12
 */

use System\Classes\PluginBase;
use SaurabhDhariwal\Revisionhistory\Classes\Diff as Diff;
use System\Models\Revision as Revision;

class Plugin extends PluginBase
{
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
    
    public $require = ['RainLab.Translate'];

    public function registerComponents()
    {
        return [
            'Pensoft\Calendar\Components\Calendar' => 'calendar',
            'Pensoft\Calendar\Components\PastEvents' => 'PastEvents',
            'Pensoft\Calendar\Components\Timeline' => 'Timeline',
            'Pensoft\Calendar\Components\EventGallery' => 'event_galleries',

        ];
    }

    public function registerSettings()
    {

    }
}
