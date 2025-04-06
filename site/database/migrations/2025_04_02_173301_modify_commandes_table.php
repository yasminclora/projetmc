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
            // Solution 1 : Rendre le champ nullable
            $table->text('articles')->nullable()->change();
            
            // OU Solution 2 : Définir une valeur par défaut
            $table->text('articles')->default('[]')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
