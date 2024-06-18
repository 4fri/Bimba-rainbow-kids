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
        Schema::create('dt_documents', function (Blueprint $table) {
            $table->id();
            $table->string('type_name', 50);
            $table->string('request_name', 50);
            $table->string('validation', 100);
            $table->enum('prerequisite', ['yes', 'no'])->default('no');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dt_documents');
    }
};
