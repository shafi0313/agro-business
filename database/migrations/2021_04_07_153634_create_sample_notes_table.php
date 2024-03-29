<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sample_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_ledger_book_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('tran_id', 64)->index()->nullable();
            $table->text('note');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sample_notes');
    }
}
