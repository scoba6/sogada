<?php

use App\Enums\ProdStatut;
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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupe_id')->constrained('groupes')->default(0);
            $table->string('libpro')->nullable(false)->default('libpro');
            $table->string('despro')->nullable(true)->default('desc');
            $table->string('imgpro')->nullable();
            $table->string('ugspro')->unique()->nullable();
            $table->string('codbar')->unique()->nullable();
            $table->integer('seupro')->nullable(false)->default(1);
            $table->integer('vstock')->nullable(false)->default(0);
            $table->date('datval')->nullable(false)->default(now());
            $table->boolean('statut')->nullable(false)->default(true);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
