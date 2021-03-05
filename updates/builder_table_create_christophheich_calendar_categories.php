<?php namespace Pensoft\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateChristophheichCalendarCategories extends Migration
{
    public function up()
    {
		if (!Schema::hasTable('christophheich_calendar_categories')) {
			Schema::create('christophheich_calendar_categories', function($table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->string('title')->nullable();
				$table->string('description')->nullable();
				$table->integer('identifier')->nullable();
				$table->timestamp('created_at')->nullable();
				$table->timestamp('updated_at')->nullable();
				$table->timestamp('deleted_at')->nullable();
			});
		}
    }
    
    public function down()
    {
		if (Schema::hasTable('christophheich_calendar_categories')) {
			Schema::dropIfExists('christophheich_calendar_categories');
		}
    }
}
