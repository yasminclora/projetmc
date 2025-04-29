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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('commande_id')->constrained()->onDelete('cascade');
            $table->decimal('montant', 10, 2); // 10 chiffres au total, 2 après la virgule
            $table->string('methode')->default('carte'); // carte, virement, especes, etc.
            $table->string('reference')->unique(); // Référence unique du paiement
            $table->string('statut')->default('initie'); // initie, valide, echoue, rembourse
            $table->text('details')->nullable(); // Réponse brute de l'API de paiement
            $table->timestamp('date_paiement')->nullable();
            $table->timestamps();



              // Index pour les performances
              $table->index(['user_id', 'commande_id']);
              $table->index('reference');
              $table->index('statut');
          });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
