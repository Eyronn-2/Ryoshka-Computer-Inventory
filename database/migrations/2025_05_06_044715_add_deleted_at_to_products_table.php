<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeletedAtToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->softDeletes(); // adds nullable deleted_at TIMESTAMP
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
}

}
