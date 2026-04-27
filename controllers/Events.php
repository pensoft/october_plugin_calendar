<?php namespace Pensoft\Calendar\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Backend\Behaviors\ListController;
use Backend\Behaviors\FormController;
use Backend\Behaviors\ReorderController;

class Events extends Controller
{
    public $implement = [
        ListController::class,
        FormController::class,
        ReorderController::class
    ];

    public string $listConfig = 'config_list.yaml';
    public string $formConfig = 'config_form.yaml';
    public string $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'pensoft.calendar.manage_events'
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Pensoft.Calendar', 'main-menu-item', 'side-menu-events');
    }
}