<?php namespace Pensoft\Calendar\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateEntries2 extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('christophheich_calendar_entries', 'show_on_timeline')) {
            Schema::table('christophheich_calendar_entries', function (Blueprint $table) {
				$table->boolean('show_on_timeline')->nullable()->default(true);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('christophheich_calendar_entries', 'show_on_timeline')) {
            Schema::table('christophheich_calendar_entries', function (Blueprint $table) {
                $table->dropColumn('show_on_timeline');
            });
        }
    }
}