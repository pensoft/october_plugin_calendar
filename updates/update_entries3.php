<?php namespace Pensoft\Calendar\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateEntries3 extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('christophheich_calendar_entries', 'meta_keywords')) {
            Schema::table('christophheich_calendar_entries', function ($table) {
                $table->text('meta_keywords')->nullable();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('christophheich_calendar_entries', 'meta_keywords')) {
            Schema::table('christophheich_calendar_entries', function ($table) {
                $table->dropColumn('meta_keywords');
            });
        }
    }
}
