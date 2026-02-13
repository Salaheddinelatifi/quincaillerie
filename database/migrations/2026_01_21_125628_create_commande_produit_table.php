<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    if (!Schema::hasTable('commande_produit')) {
        Schema::create('commande_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->cascadeOnDelete();
            $table->foreignId('produit_id')->constrained()->cascadeOnDelete();
            $table->integer('quantite');
            $table->decimal('prix', 10, 2);
            $table->string('size')->nullable();
            $table->timestamps();
        });
    }
}


    public function down(): void
{
    Schema::dropIfExists('commande_produit');
}

};
