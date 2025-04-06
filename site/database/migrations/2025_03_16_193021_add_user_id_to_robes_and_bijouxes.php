<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Vérifie si la colonne n'existe pas avant de l'ajouter
        if (!Schema::hasColumn('robes', 'user_id')) {
            Schema::table('robes', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained();
            });
        }

        if (!Schema::hasColumn('bijouxes', 'user_id')) {
            Schema::table('bijouxes', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained();
            });
        }
    }

    public function down()
    {
        Schema::table('robes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('bijouxes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};