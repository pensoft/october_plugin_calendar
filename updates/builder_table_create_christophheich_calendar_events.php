<?php namespace Pensoft\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateChristophheichCalendarEvents extends Migration
{
    public function up()
    {
		if (!Schema::hasTable('christophheich_calendar_events')) {
			Schema::create('christophheich_calendar_events', function($table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->string('title')->nullable();
				$table->string('color')->nullable();
				$table->timestamp('created_at')->nullable();
				$table->timestamp('updated_at')->nullable();
				$table->timestamp('deleted_at')->nullable();
				$table->string('description')->nullable();
				$table->string('identifier', 255)->nullable()->unsigned(false)->default(null);
			});
		}
    }
    
    public function down()
    {
		if (Schema::hasTable('christophheich_calendar_events')) {
			Schema::dropIfExists('christophheich_calendar_events');
		}
    }
}
