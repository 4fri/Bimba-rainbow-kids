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
        Schema::create('menu_parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id'); // Ensure this is of type uuid
            $table->string('route_name', 50)->nullable()->unique();
            $table->string('menu_name', 50);
            $table->integer('child_id')->nullable()->comment('ambil dari menu parent id');
            $table->timestamps();

            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_parents');
    }
};
