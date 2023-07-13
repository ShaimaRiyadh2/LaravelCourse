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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->unique();//len by default 190

            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->enum('type',['old','new'])->default('new');
            $table->index('name');
            //$table->timestamps();//2 cols(created at, updated at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
