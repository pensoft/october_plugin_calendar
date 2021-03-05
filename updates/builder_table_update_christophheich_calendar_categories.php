<?php namespace Pensoft\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateChristophheichCalendarCategories extends Migration
{
    public function up()
    {
		if (!Schema::hasColumn('christophheich_calendar_categories', 'created_at')) {
			Schema::table('christophheich_calendar_categories', function($table)
			{
				$table->timestamp('created_at')->nullable();
				$table->timestamp('updated_at')->nullable();
				$table->timestamp('deleted_at')->nullable();
			});
		}
    }
    
    public function down()
    {
		if (Schema::hasColumn('christophheich_calendar_categories', 'created_at')) {
			Schema::table('christophheich_calendar_categories', function($table)
			{
				$table->dropColumn('created_at');
				$table->dropColumn('updated_at');
				$table->dropColumn('deleted_at');
			});
		}
    }
}
