<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('commandes', function ($table) {
        $table->string('status')->default('en_attente');
    });
}

public function down()
{
    Schema::table('commandes', function ($table) {
        $table->dropColumn('status');
    });
}

};
