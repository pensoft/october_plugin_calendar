<?php namespace ChristophHeich\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateChristophheichCalendarEntries extends Migration
{
    public function up()
    {
		if (!Schema::hasColumn('christophheich_calendar_entries', 'created_at')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->timestamp('deleted_at')->nullable();
				$table->timestamp('created_at')->nullable();
				$table->timestamp('updated_at')->nullable();
			});
		}
    }
    
    public function down()
    {
		if (Schema::hasColumn('christophheich_calendar_entries', 'created_at')) {
			Schema::table('christophheich_calendar_entries', function($table)
			{
				$table->dropColumn('deleted_at');
				$table->dropColumn('created_at');
				$table->dropColumn('updated_at');
			});
		}
    }
}
