<?php

// database/migrations/xxxx_xx_xx_add_carton_and_pack_to_produits_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->integer('carton')->default(0);
            $table->integer('pack')->default(0);
        });
    }

    public function down()
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropColumn(['carton', 'pack']);
        });
    }
};
