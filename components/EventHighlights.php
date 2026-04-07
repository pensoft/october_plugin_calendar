<?php namespace Pensoft\Calendar\Components;

use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Pensoft\Calendar\Models\Entry;

class EventHighlights extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name' => 'Event Highlights',
            'description' => 'Displays highlighted events.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'maxItems' => [
                'title' => 'Max items',
                'default' => 3,
            ],
            'upcomingOnly' => [
                'title' => 'Upcoming only',
                'description' => 'Show only upcoming events. If unchecked, shows all highlighted events.',
                'type' => 'checkbox',
                'default' => true,
            ],
        ];
    }

    public function onRun(): void
    {
        $this->page['event_highlights'] = $this->getHighlights();
        $this->page['upcoming_only'] = $this->property('upcomingOnly');
    }

    public function getHighlights()
    {
        $query = Entry::where('show_on_timeline', true)
            ->where('is_internal', false);

        if ($this->property('upcomingOnly')) {
            $query->where('end', '>', Carbon::now())
                  ->orderBy('start', 'asc');
        } else {
            $query->orderBy('start', 'desc');
        }

        return $query->take($this->property('maxItems'))->get();
    }
}
