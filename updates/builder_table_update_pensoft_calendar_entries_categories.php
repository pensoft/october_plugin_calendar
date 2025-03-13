<?php namespace Pensoft\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePensoftCalendarEntriesCategories extends Migration
{
    public function up()
    {
        Schema::table('pensoft_calendar_entries_categories', function($table)
        {
            $table->integer('sort_order')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('pensoft_calendar_entries_categories', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
}
