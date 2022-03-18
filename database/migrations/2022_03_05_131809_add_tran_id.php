<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('sales_invoices', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('sales_ledger_books', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('sales_reports', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('purchase_ledger_books', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('invoice_dues', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('sample_notes', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('stocks', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('is_returns', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
        Schema::table('production_cals', function (Blueprint $table) {
            $table->string('tran_id', 64)->after('id')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('sales_invoices', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('sales_ledger_books', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('sales_reports', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('purchase_ledger_books', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('invoice_dues', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('sample_notes', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('is_returns', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
        Schema::table('production_cals', function (Blueprint $table) {
            $table->dropColumn('tran_id');
        });
    }
}
