<?php namespace ChristophHeich\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateChristophheichCalendarEntries5 extends Migration
{
    public function up()
    {
		if (!Schema::hasColumn('christophheich_calendar_entries', 'identifier')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->renameColumn('category', 'identifier');
			});
		}
    }
    
    public function down()
    {
		if (Schema::hasColumn('christophheich_calendar_entries', 'identifier')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->renameColumn('identifier', 'category');
			});
		}
    }
}
