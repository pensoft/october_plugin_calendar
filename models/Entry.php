<?php namespace Pensoft\Calendar\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Model;
use Cms\Classes\Theme;
use RainLab\User\Facades\Auth;

use BackendAuth;
use Validator;

/**
 * Model
 */
class Entry extends Model
{
	use \October\Rain\Database\Traits\Validation;
	use \October\Rain\Database\Traits\SoftDelete;
    // For Revisionable namespace
    use \October\Rain\Database\Traits\Revisionable;

    public $timestamps = false;

    // Add  for revisions limit
    public $revisionableLimit = 200;

    // Add for revisions on particular field
    protected $revisionable = ["id","title", "start", "end", "url", "place", "slug"];

	protected $dates = ['deleted_at'];

	protected $filters = [
		'year'
	];
	protected $jsonable = [
		'materials'
	];
	/* translate */
	// public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

	public $translatable = ['title', 'description', 'place', 'slug'];

	public $appends = ['event_date', 'event_time'];

	public $attachOne = [
		'cover_image' => 'System\Models\File',
	];

	public $belongsToMany = [
		'speakers' => 'System\Models\File',

		'galleries' => [
            'Pensoft\Media\Models\Galleries',
            'table' => 'pensoft_gallery_entry_pivot',
            'key' => 'entry_id',
            'otherKey' => 'gallery_id',
            'order' => 'created_at desc'
        ],

        'categories' => [
            'Pensoft\Calendar\Models\Category',
            'table' => 'pensoft_calendar_entries_categories',
            'key' => 'entry_id',
            'otherKey' => 'category_id',
        ]
	];

	/**
	 * @var array Validation rules
	 */
	public $rules = [ ];


	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'christophheich_calendar_entries';

	/**
	 * Cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'all_day'               => 'boolean',
		'display_event_end'     => 'boolean',
		'display_event_time'    => 'boolean',
		'overlap'               => 'boolean',
		'editable'              => 'boolean',
		'start_editable'        => 'boolean',
		'duration_editable'     => 'boolean',
		'resource_editable'     => 'boolean'
	];

	/**
	 * Get the start value.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function getStartAttribute($value)
	{
		return str_replace(' ', 'T', $value);
	}

	public function myColorList(){
		$theme = new Theme;
		$themeData = $theme->getCustomData()->first();
		if(!$themeData){
			return [];
		}
		return [$themeData->primary_color, $themeData->secondary_color];
	}

	/**
	 * Get the end value.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function getEndAttribute($value)
	{
		return str_replace(' ', 'T', $value);
	}

	public function getEventDateAttribute(){
		$start = new Carbon($this->start);
		$end = new Carbon($this->end);
		if ($start->day === $end->day && $start->month === $end->month && $start->year === $end->year) {
			return $start->day . ' ' . $start->englishMonth . ' ' . $start->year;
		}else if($start->month === $end->month && $start->year === $end->year){
			return $start->day .' - '. $end->day .' '. $end->englishMonth .' '. $end->year;
		}else if($start->year === $end->year){
			return $start->day .' '. $start->englishMonth . ' - ' . $end->day . ' ' . $end->englishMonth . ' ' . $end->year;
		}else{
			return $start->day . ' ' . $start->englishMonth .' ' . $start->year . ' - ' . $end->day . ' ' . $end->englishMonth . ' ' . $end->year;
		}
	}

	public function getEventTimeAttribute(){
		if($this->all_day){
			return '';
		}
		$start = new Carbon($this->start);
		$end = new Carbon($this->end);
		if ($start->hour === $end->hour && $start->minute === $end->minute) {
			return ' at ' . $start->hour . ':' . str_pad($start->minute, 2,  0, STR_PAD_RIGHT);
		}else{
			return ' at ' .$start->hour . ':' . str_pad($start->minute, 2,  0, STR_PAD_RIGHT).'-' . $end->hour . ':' . str_pad($end->minute, 2,  0, STR_PAD_RIGHT);
		}
	}

	/**
	 * Get the formatted values of our eloquent model.
	 *
	 */
	public static function formatted($count, $category)
	{
		$user = Auth::check();
        $activeTheme = Theme::getActiveTheme();
        $themeData = $activeTheme->getCustomData();
		//dd($user = Entry::whereIn('identifier->id', array(1, 3))->get());
		//dd(Entry::whereRaw('JSON_CONTAINS(identifier->"$.id", "1")')->get());
		//dd($category);
		// Check if count is not null, not numeric, if so limit to the latest entries only!
		if (is_null($count) || $count == 'null' || !is_numeric($count)) {
			//dd(explode(",", str_replace(array('[', ']', ' '), '', $category)));

			if ( !$user ) {

				if (is_null($category) || $category == 'null' || !is_array(explode(",", str_replace(array('[', ']', ' '), '', $category)))) {
					$entries = Entry::where('is_internal', false)->get()->toArray();
				} else {
					$entries = Entry::where('identifier', $category)->where('is_internal', false)->get()->toArray();
				}
			}else{
				if (is_null($category) || $category == 'null' || !is_array(explode(",", str_replace(array('[', ']', ' '), '', $category)))) {
					$entries = Entry::all()->toArray();
				} else {
					// TODO: $category equals an array
					// TODO: $category = [1, 2, 3]
					$entries = Entry::where('identifier', $category)->get()->toArray();
				}
			}

		}
		else {
			if ( !$user ){
				if (is_null($category) || $category == 'null') {
					$entries = Entry::latest()->limit($count)->where('is_internal', false)->get()->toArray();
				} else {
					$entries = Entry::latest()->limit($count)->where('is_internal', false)->where('identifier', $category)->get()->toArray();
				}
			}else{
				if (is_null($category) || $category == 'null') {
					$entries = Entry::latest()->limit($count)->get()->toArray();
				} else {
					$entries = Entry::latest()->limit($count)->where('identifier', $category)->get()->toArray();
				}
			}

		}
		return array_map(function($data) use($themeData) {
			$format['id']               = $data['id'];
			$format['title']            = $data['title'];
			$format['slug']             = $data['slug'];
			if (empty($data['dow'])) { // If dow is empty continue as normal, if not use only the time!
				$format['start']        = $data['start'];
				$format['end']          = $data['end'];
			}
			else {
				$format['startTime']        = preg_replace('/^[^T]*T/', '', $data['start']);
				$format['endTime']          = preg_replace('/^[^T]*T/', '', $data['end']);
			}
			$format['color']            = $data['color'];
			$format['textColor']        = $data['text_color'];
			$format['rendering']        = $data['rendering'];
			$format['description']      = $data['description'];
			if(!empty($data['url'])) {
				$format['url']          = $data['url'];
			}
			$format['allDay']           = $data['all_day'];
			$format['displayEventEnd']  = $data['display_event_end'];
			$format['displayEventTime'] = $data['display_event_time'];
			$format['eventTitle']            = $data['title'];
			$format['index']               = $data['index'];
			$format['timeFormat']       = $data['time_format'];
			//$format['constraint']     = $data['constraint'];
			$format['overlap']          = $data['overlap'];
			$format['className']        = $data['class_name'];
			$format['editable']         = $data['editable'];
			if (!$data['editable']) { // If false do not show thoe aboves to prevent override!
				$format['startEditable']    = $data['start_editable'];
				$format['durationEditable'] = $data['duration_editable'];
			}
			$format['resourceEditable'] = $data['resource_editable'];
			$format['source']           = $data['source'];
			if(!is_null($data['background_color'])) {
				$format['backgroundColor']  = $data['background_color'];
			}else{
                if ( $data['is_internal'] && !is_null($themeData->internal_events_color)) {
                    $format['backgroundColor']  = $themeData->internal_events_color;
                }
            }
			if(!is_null($data['border_color'])) {
				$format['borderColor'] = $data['border_color'];
			}
			if (!empty($data['dow'])) {
				$format['daysOfWeek']   = $data['dow'];
			}
			return $format;

		}, $entries);
	}

	public static function getEntryEndYears(){
		$entry = Entry::select(DB::raw("to_char(coalesce(\"end\", \"start\"), 'YYYY') as year"), DB::raw("to_char(coalesce(\"end\",\"start\"), 'YYYY') = to_char(now(), 'YYYY') as is_selected"))->groupBy('year')->get()->toArray();
		return $entry;
	}

	public static function forthcoming(){
		return Entry::select(
			'slug',
			'id',
			'title',
			'description',
			DB::raw("to_char(\"start\", 'DD') as start_day"),
			DB::raw("to_char(\"start\", 'YYYY') as start_year"),
			DB::raw("to_char(\"end\", 'DD') as end_day"),
			DB::raw("to_char(\"end\", 'YYYY') as end_year"),
			DB::raw("to_char(\"start\", 'MM') as start_month"),
			DB::raw("to_char(\"end\", 'MM') as end_month"),
			DB::raw("
				\"end\" is not null as has_end
			"),

			DB::raw("to_char(coalesce(\"start\", \"end\"), 'DD.MM.YYYY') as start_formatted"),
			DB::raw("\"end\" >= '" . date('Y-m-d 00:00:00'). "' as is_forthcoming"  )
		)
			->where('identifier', 1)
			->where('is_internal', false)
			->orderBy('start', 'DESC')
			->limit(4)
			->get()
			->reverse()
			->toArray();
	}

	public static function getPastEntries($filterType = null, $filterValue = null)
	{
		$startOfYear = $filterValue . '-01-01 00:00:00';
		$endOfYear = $filterValue . '-12-31 23:59:59';

		if($filterValue == date('Y')){
			$endOfYear = date('Y-m-d H:m:i');
		}

		return self::select(
			'slug',
			'id',
			'title',
			'description',
			DB::raw("to_char(coalesce(\"start\", \"end\"), 'DD.MM') as start_formatted"),
			DB::raw("to_char(coalesce(\"end\", \"start\"), 'DD.MM') as end_formatted"),
			DB::raw("to_char(coalesce(\"end\", \"start\"), 'YYYY') as year"),
			'*'
		)
			->whereBetween(DB::raw('coalesce("end", "start")'), [$startOfYear, $endOfYear])
			->where('is_internal', false)
			->orderBy('start', 'ASC')
			->get();
		// ->toArray();
	}

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($query) use ($categoryId) {
            $query->where('christophheich_calendar_categories.id', $categoryId);
        });
    }

    // Add  below relationship with Revision model
    public $morphMany = [
        'revision_history' => ['System\Models\Revision', 'name' => 'revisionable']
    ];

    // Add below function use for get current user details
    public function diff(){
        $history = $this->revision_history;
    }
    public function getRevisionableUser()
    {
        return BackendAuth::getUser()->id;
    }


	        /**
     * Add translation support to this model, if available.
     *
     * @return void
     */
    public static function boot()
    {
        Validator::extend(
            'json',
            function ($attribute, $value, $parameters) {
                json_decode($value);

                return json_last_error() == JSON_ERROR_NONE;
            }
        );

        // Call default functionality (required)
        parent::boot();

        // Check the translate plugin is installed
        if (!class_exists('RainLab\Translate\Behaviors\TranslatableModel')) {
            return;
        }

        // Extend the constructor of the model
        self::extend(
            function ($model) {
                // Implement the translatable behavior
                $model->implement[] = 'RainLab.Translate.Behaviors.TranslatableModel';
            }
        );
    }
}
