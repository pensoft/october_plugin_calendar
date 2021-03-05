<?php namespace ChristophHeich\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateChristophheichCalendarEntries3 extends Migration
{
    public function up()
    {
		if (!Schema::hasColumn('christophheich_calendar_entries', 'dow')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->string('dow')->nullable();
			});
		}
    }
    
    public function down()
    {
		if (Schema::hasColumn('christophheich_calendar_entries', 'dow')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->dropColumn('dow');
			});
		}
    }
}
