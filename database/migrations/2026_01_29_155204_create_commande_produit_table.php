<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // table already exists → do nothing
    }

    public function down(): void
    {
        // optional: Schema::dropIfExists('commande_produit');
    }
};
