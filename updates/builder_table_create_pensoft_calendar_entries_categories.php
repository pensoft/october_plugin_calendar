<?php namespace Pensoft\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePensoftCalendarEntriesCategories extends Migration
{
    public function up()
    {
        Schema::create('pensoft_calendar_entries_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('category_id');
            $table->integer('entry_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pensoft_calendar_entries_categories');
    }
}
