<?php

namespace Pensoft\Calendar\Components;

/**
 * Created by PhpStorm.
 * User: Christoph Heich
 * Date: 02.06.2018
 * Time: 17:36
 */

use Carbon\Carbon;
use Pensoft\Calendar\Models\Entry;
use Cms\Classes\ComponentBase;

class Timeline extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Timeline',
            'description' => 'Displays a timeline events.'
        ];
    }

	public function onRun()
	{
//		$this->addJs('assets/js/slick.min.js');
//		$this->addJs('assets/js/def.js');
	}

    public function defineProperties()
    {
        return [
            'limit' => [
                'title'             => 'Limit',
                'description'       => 'You can limit the amount of events shown. While "null" equals to no limit and "30" says that the latest 30 events will be shown.',
                'default'           => '5',
                'type'              => 'string',
                'validationPattern' => '^[1-9]+$',
                'validationMessage' => 'You can only use numeric symbols eg. 5 or 1.'
            ],
			'upcoming' => [
				'title' => 'Show only upcoming',
				'type' => 'checkbox',
				'default' => false
			],
			'marked_for_display' => [
				'title' => 'Show only marked for displaying in the timeline',
				'type' => 'checkbox',
				'default' => false
			],
			'templates' => [
				'title' => 'Select templates',
				'type' => 'dropdown',
				'default' => 'template1'
			],
//			'link' => [
//				'title' => 'Hashtag link',
//				'type'  => 'string',
//				'default' => '#september'
//			],
//			'use_day' => [
//				'title' => 'Use entry day for the link',
//				'type' => 'checkbox',
//				'default' => false
//			],
        ];
    }

	public function getTemplatesOptions()
	{
		return [
			'template1' => 'Template 1',
			'template2' => 'Template 2',
			'template3' => 'Template 3',
		];
	}

    public function getLatestEntries()
    {
    	if($this->property('upcoming')){
			if($this->property('marked_for_display')){
				$entries = Entry::where('start', '>', Carbon::now())->where('show_on_timeline', true)->orderBy('start', 'asc');
			}else{
				$entries = Entry::where('start', '>', Carbon::now())->orderBy('start', 'asc');
			}

			return $entries->take($this->property('limit'))->get();
		}else{
			if($this->property('marked_for_display')){
				$entries = Entry::orderBy('start', 'desc')->where('show_on_timeline', true);
			}else{
				$entries = Entry::orderBy('start', 'desc');
			}

			return $entries->take($this->property('limit'))->get()->reverse();
		}

    }
}
