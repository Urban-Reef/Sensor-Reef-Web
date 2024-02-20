<?php

use App\Models\Session;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reef_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Session::class)->constrained('sessions');
            $table->string('url');
            $table->string('angle');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reef_photos');
    }
};
