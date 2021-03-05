<?php namespace ChristophHeich\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateChristophheichCalendarEntries6 extends Migration
{
    public function up()
    {
		if (Schema::hasTable('christophheich_calendar_entries')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->string('identifier', 255)->nullable()->unsigned(false)->default(null)->change();
			});
		}
    }
    
    public function down()
    {
		if (Schema::hasTable('christophheich_calendar_entries')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->integer('identifier')->nullable()->unsigned(false)->default(null)->change();
			});
		}
    }
}