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
        Schema::create('announc_events', function (Blueprint $table) {
            $table->id();
            $table->text('event');
            $table->string('image')->unique();
            $table->string('type');
            $table->string('hidden')->default('yes');
            $table->text('info')->default('');
             $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announc_events');
    }
};
