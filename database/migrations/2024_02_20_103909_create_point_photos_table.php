<?php

use App\Models\Point;
use App\Models\Session;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('point_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Point::class)->constrained('points');
            $table->foreignIdFor(Session::class)->constrained('sessions');
            $table->string('url');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_photos');
    }
};
