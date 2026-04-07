<?php namespace Pensoft\Calendar\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateEntries3 extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('christophheich_calendar_entries', 'meta_keywords')) {
            Schema::table('christophheich_calendar_entries', function (Blueprint $table) {
                $table->text('meta_keywords')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('christophheich_calendar_entries', 'meta_keywords')) {
            Schema::table('christophheich_calendar_entries', function (Blueprint $table) {
                $table->dropColumn('meta_keywords');
            });
        }
    }
}