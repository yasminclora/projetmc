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
    Schema::table('commandes', function (Blueprint $table) {
        // Solution 1: Agrandir le champ string
        $table->string('statut', 20)->change();
        
        // OU Solution 2 (meilleure): Utiliser un ENUM
        // $table->enum('statut', ['en_attente', 'payée', 'expédiée', 'annulée', 'completée'])->change();
    });
}

public function down()
{
    Schema::table('commandes', function (Blueprint $table) {
        $table->string('statut', 10)->change(); // Rétablir l'ancienne valeur
    });
}
};
