<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    if (!Schema::hasColumn('commande_produit', 'size')) {
        Schema::table('commande_produit', function (Blueprint $table) {
            $table->string('size')->nullable();
            
        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commande_produit', function (Blueprint $table) {
            
        });
    }
};
