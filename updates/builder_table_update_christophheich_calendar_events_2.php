<?php namespace ChristophHeich\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateChristophheichCalendarEvents2 extends Migration
{
    public function up()
    {
		if (!Schema::hasColumn('christophheich_calendar_events', 'category')) {
			Schema::table('christophheich_calendar_events', function($table)
			{
				$table->integer('category')->nullable();
			});
		}
    }
    
    public function down()
    {
		if (Schema::hasColumn('christophheich_calendar_events', 'category')) {
			Schema::table('christophheich_calendar_events', function($table)
			{
				$table->dropColumn('category');
			});
		}
    }
}
