<?php namespace Pensoft\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateChristophheichCalendarEntries extends Migration
{
    public function up()
    {
		if (!Schema::hasTable('christophheich_calendar_entries')) {
			Schema::create('christophheich_calendar_entries', function($table)
			{
				$table->engine = 'InnoDB';
				$table->increments('id')->unsigned();
				$table->string('title')->nullable();
				$table->dateTime('start')->nullable();
				$table->dateTime('end')->nullable();
				$table->string('color')->nullable();
				$table->string('text_color')->nullable();
				$table->string('rendering')->nullable();
				$table->text('description')->nullable();
				$table->string('url')->nullable();
				$table->boolean('all_day')->nullable();
				$table->boolean('display_event_end')->nullable();
				$table->boolean('display_event_time')->nullable();
				$table->integer('index')->nullable();
				$table->string('time_format')->nullable();
				$table->string('constraint')->nullable();
				$table->boolean('overlap')->nullable();
				$table->timestamp('deleted_at')->nullable();
				$table->timestamp('created_at')->nullable();
				$table->timestamp('updated_at')->nullable();
				$table->string('class_name')->nullable();
				$table->boolean('editable')->nullable();
				$table->boolean('start_editable')->nullable();
				$table->boolean('duration_editable')->nullable();
				$table->boolean('resource_editable')->nullable();
				$table->string('source')->nullable();
				$table->string('background_color')->nullable();
				$table->string('border_color')->nullable();
				$table->string('dow')->nullable();
				$table->string('identifier', 255)->nullable()->unsigned(false)->default(null);
				$table->string('place')->nullable();
				$table->string('slug');
			});
		}
    }
    
    public function down()
    {
		if (Schema::hasTable('christophheich_calendar_entries')) {
			Schema::dropIfExists('christophheich_calendar_entries');
		}
    }
}
