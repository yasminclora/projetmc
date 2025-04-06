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
        Schema::table('commande_items', function (Blueprint $table) {
            // Ajoutez ces colonnes si elles n'existent pas
            if (!Schema::hasColumn('commande_items', 'article_id')) {
                $table->unsignedBigInteger('article_id')->after('commande_id');
            }
            
            if (!Schema::hasColumn('commande_items', 'article_type')) {
                $table->string('article_type', 50)->after('article_id');
            }
            
            // Ajoutez un index composite
            $table->index(['article_id', 'article_type']);
        });
    }
    
    public function down()
    {
        Schema::table('commande_items', function (Blueprint $table) {
            $table->dropColumn(['article_id', 'article_type']);
        });
    
    }
};
