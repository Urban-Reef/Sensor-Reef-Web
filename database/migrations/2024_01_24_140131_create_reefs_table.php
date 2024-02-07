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
        Schema::create('reefs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('longitude', 9, 6);
            $table->decimal('latitude', 8, 6);
            $table->string('diagram')->nullable();
            $table->timestamp('placed_on')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reefs');
    }
};
