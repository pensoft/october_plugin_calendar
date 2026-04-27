<?php namespace Pensoft\Calendar\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateEntries4 extends Migration
{
    public function up(): void
    {
        Schema::table('christophheich_calendar_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('christophheich_calendar_entries', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }

            if (!Schema::hasColumn('christophheich_calendar_entries', 'meta_title')) {
                $table->string('meta_title')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('christophheich_calendar_entries', function (Blueprint $table) {
            if (Schema::hasColumn('christophheich_calendar_entries', 'meta_description')) {
                $table->dropColumn('meta_description');
            }

            if (Schema::hasColumn('christophheich_calendar_entries', 'meta_title')) {
                $table->dropColumn('meta_title');
            }
        });
    }
}