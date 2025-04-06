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
            $table->string('reference')->unique()->after('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('reference');
        });
    }
};
