<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Table commandes
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });

        // Pivot table commande_produit
        Schema::create('commande_produit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->onDelete('cascade');
            $table->foreignId('produit_id')->constrained()->onDelete('cascade');
            $table->integer('quantite');
            $table->decimal('prix', 10,2);
            $table->string('size')->nullable();
            $table->timestamps(); // مهم باش attach() مع withTimestamps() يخدم
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commande_produit');
        Schema::dropIfExists('commandes');
    }
};
