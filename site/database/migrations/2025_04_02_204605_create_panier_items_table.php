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
        Schema::create('panier_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panier_id')->constrained();
            $table->unsignedInteger('quantite');
            $table->decimal('prix_unitaire', 8, 2);
            $table->string('article_type'); // App\Models\Robe ou App\Models\Bijoux
            $table->unsignedBigInteger('article_id'); // ID du produit
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panier_items');
    }
};
