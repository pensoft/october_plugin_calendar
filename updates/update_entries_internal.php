<?php namespace Pensoft\Calendar\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateEntriesInternal extends Migration
{
	public function up(): void
	{
		if (!Schema::hasColumn('christophheich_calendar_entries', 'is_internal')) {
			Schema::table('christophheich_calendar_entries', function (Blueprint $table) {
				$table->boolean('is_internal')->nullable()->default(true);
			});
		}
	}

	public function down(): void
	{
		if (Schema::hasColumn('christophheich_calendar_entries', 'is_internal')) {
			Schema::table('christophheich_calendar_entries', function (Blueprint $table) {
				$table->dropColumn('is_internal');
			});
		}
	}
}