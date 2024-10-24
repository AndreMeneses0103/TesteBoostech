<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('email', 255)->unique();
            $table->string('senha');
            $table->enum('cargo', ['user', 'admin'])->default('user');
            $table->unsignedBigInteger('referencia_pessoa_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('referencia_pessoa_id')
                ->references('id')->on('pessoas')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas');
    }
};
