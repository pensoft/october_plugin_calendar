<?php namespace Pensoft\Calendar\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTableGalleriesEntryPivot extends Migration
{
    public function up()
    {
        // if (!Schema::hasTable('pensoft_media_galleries') || !Schema::hasTable('christophheich_calendar_entries')) {
        //     return;
        // }

        if (Schema::hasTable('pensoft_gallery_entry_pivot')) {
            return;
        }

        Schema::create('pensoft_gallery_entry_pivot', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('gallery_id')->unsigned();
            $table->integer('entry_id')->unsigned();

            $table->foreign('gallery_id')
                  ->references('id')->on('pensoft_media_galleries')
                  ->onDelete('cascade');

            $table->foreign('entry_id')
                  ->references('id')->on('christophheich_calendar_entries')
                  ->onDelete('cascade');

            $table->primary(['gallery_id', 'entry_id'], 'gallery_entry_pivot_pk');
        });
    }

    public function down()
    {
        if (Schema::hasTable('pensoft_gallery_entry_pivot')) {
            Schema::dropIfExists('pensoft_gallery_entry_pivot');
        }
    }
}
