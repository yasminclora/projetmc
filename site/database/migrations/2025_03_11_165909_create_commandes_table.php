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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('categorie', ['robe', 'bijou', 'mixte']);
            $table->json('articles'); // Stocke les articles commandés
            $table->decimal('total', 10, 2);
            $table->enum('statut', ['en attente', 'validée', 'annulée'])->default('en attente');
          
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
