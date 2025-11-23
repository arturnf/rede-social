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
            $table->id();

            // 1. Usuário que Recebe (Destinatário)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. Usuário que Executou a Ação (Ator/Remetente)
            $table->foreignId('actor_id')->nullable()->constrained('users')->onDelete('set null');

            $table->text('link')->nullable();
            $table->string('type'); 
            $table->text('message'); 
            $table->boolean('is_read')->default(false)->index();
            $table->timestamp('read_at')->nullable();

            
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
