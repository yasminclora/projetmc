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
        Schema::create('notifications', function (Blueprint $table) {
           
            $table->uuid('id')->primary();  // Utilisation de UUID
            $table->string('type');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->morphs('notifiable');  // Création des colonnes notifiable_id et notifiable_type
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
