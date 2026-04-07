<?php namespace Pensoft\Calendar\Models;

use Model;
use BackendAuth;
use System\Models\Revision;

/**
 * Model
 */
class Event extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    // For Revisionable namespace
    use \October\Rain\Database\Traits\Revisionable;

    public $timestamps = false;

    // Add  for revisions limit
    public $revisionableLimit = 200;

    // Add for revisions on particular field
    protected $revisionable = ["id","title","color"];

    protected $casts = ['deleted_at' => 'datetime'];

	/* translate */
	public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

	public $translatable = ['title', 'description'];

    /**
     * @var array Validation rules
     */
    public $rules = [];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'christophheich_calendar_events';
    // Add  below relationship with Revision model
    public $morphMany = [
        'revision_history' => [Revision::class, 'name' => 'revisionable']
    ];

    // Add below function use for get current user details
    public function diff(){
        $history = $this->revision_history;
    }
    public function getRevisionableUser()
    {
        return BackendAuth::getUser()->id;
    }
}