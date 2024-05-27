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
            $table->string('libpro')->nullable(false)->default('libpro');
            $table->string('codbar')->nullable(false)->default('codbar');
            $table->string('imgpro')->nullable();
            $table->integer('seupro')->nullable(false)->default(1);
            $table->integer('vstock')->nullable(false)->default(0);
            $table->enum('statut', [ProdStatut::DIS, ProdStatut::IND])->default(ProdStatut::DIS)->nullable(false)->default(0)->change();
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
