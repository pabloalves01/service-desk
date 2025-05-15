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
        Schema::create('corporacao_aniversariantes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('setor_id');
            $table->foreign('setor_id')->references('id')->on('corporacao_setores');
            $table->date('data_nascimento');
            $table->string('dia');
            $table->string('mes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corporacao_aniversariantes');
    }
};
