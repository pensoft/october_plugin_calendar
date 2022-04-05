<?php namespace Pensoft\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateEntriesInternal extends Migration
{
	public function up()
	{
		if (!Schema::hasColumn('christophheich_calendar_entries', 'is_internal')) {
			Schema::table('christophheich_calendar_entries', function ($table) {
				$table->boolean('is_internal')->nullable()->default(true);
			});
		}
	}

	public function down()
	{
		if (Schema::hasColumn('christophheich_calendar_entries', 'is_internal')) {
			Schema::table('christophheich_calendar_entries', function ($table) {
				$table->dropColumn('is_internal');
			});
		}
	}
}