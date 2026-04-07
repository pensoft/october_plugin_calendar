<?php namespace Pensoft\Calendar\Components;

use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Illuminate\Support\Str;
use Pensoft\Calendar\Models\Entry;

class EventList extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name' => 'Event List',
            'description' => 'Displays events with list, detail and past events views.'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'maxItems' => [
                'title' => 'Max items per page',
                'default' => 20,
            ],
        ];
    }

    public function onRun(): void
    {
        $slug = $this->param('slug');

        if ($slug) {
            $entry = Entry::where('slug', $slug)->first();
            if ($entry) {
                $this->page['is_detail_page'] = true;
                $this->page['entry'] = $entry;
                $this->page['page_url'] = $this->pageUrl('');
                $this->setSeoMeta($entry);
                return;
            }
        }

        // List page
        $this->page['entries'] = Entry::where('end', '>=', Carbon::now())
            ->orderBy('start', 'asc')
            ->paginate($this->property('maxItems'));

        $this->page['past_entries'] = Entry::where('end', '<', Carbon::now())
            ->orderBy('start', 'desc')
            ->get();

        $this->page['slug'] = $slug;
    }

    protected function setSeoMeta(Entry $entry): void
    {
        if (!class_exists('\BennoThommo\Meta\Meta')) {
            return;
        }

        $seoTitle = $entry->title;
        $seoDescription = Str::limit(strip_tags($entry->description), 255);

        if ($seoTitle) {
            \BennoThommo\Meta\Meta::set('title', $seoTitle);
        }
        if ($seoDescription) {
            \BennoThommo\Meta\Meta::set('description', $seoDescription);
        }

        \BennoThommo\Meta\Meta::set('twitter:card', 'summary_large_image');
        \BennoThommo\Meta\Meta::set('twitter:title', $seoTitle);
        \BennoThommo\Meta\Meta::set('twitter:description', $seoDescription);
        \BennoThommo\Meta\Meta::set('og:title', $seoTitle);
        \BennoThommo\Meta\Meta::set('og:description', $seoDescription);
        \BennoThommo\Meta\Meta::set('og:type', 'article');
        \BennoThommo\Meta\Meta::set('og:url', $this->pageUrl(''));

        if ($entry->cover_image) {
            \BennoThommo\Meta\Meta::set('twitter:image', $entry->cover_image->getThumb(600, null, ['mode' => 'auto']));
            \BennoThommo\Meta\Meta::set('og:image', $entry->cover_image->getThumb(600, 314, ['mode' => 'crop']));
            \BennoThommo\Meta\Meta::set('og:image:width', 600);
            \BennoThommo\Meta\Meta::set('og:image:height', 314);
        }
    }
}
