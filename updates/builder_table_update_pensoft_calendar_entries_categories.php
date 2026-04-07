<?php namespace Pensoft\Calendar\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePensoftCalendarEntriesCategories extends Migration
{
    public function up(): void
    {
        Schema::table('pensoft_calendar_entries_categories', function(Blueprint $table)
        {
            $table->integer('sort_order')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('pensoft_calendar_entries_categories', function(Blueprint $table)
        {
            $table->dropColumn('sort_order');
        });
    }
}