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
        // Solution 1 (recommandée) : Utiliser un ENUM avec des valeurs précises
        $table->enum('statut', ['attente', 'payee', 'expediee', 'annulee', 'livree'])
              ->default('attente')
              ->change();
        
        // OU Solution 2 : Utiliser un string avec une longueur fixe
        // $table->string('statut', 20)->default('en_attente')->change();
    });
}


    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            //
        });
    }
};
