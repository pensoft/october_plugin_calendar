<?php namespace Pensoft\Calendar\Models;

use Model;
use BackendAuth;
/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    // For Revisionable namespace
    use \October\Rain\Database\Traits\Revisionable;

    public $timestamps = false;

    // Add  for revisions limit
    public $revisionableLimit = 200;

    // Add for revisions on particular field
    protected $revisionable = ["id","title","description", "identifier"];

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'christophheich_calendar_categories';



    /* translate */
	public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

	public $translatable = ['title', 'description'];
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
}
