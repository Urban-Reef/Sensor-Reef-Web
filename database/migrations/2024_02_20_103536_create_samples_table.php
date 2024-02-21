<?php

use App\Models\Point;
use App\Models\MonitoringSession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Point::class)->constrained('points');
            $table->foreignIdFor(MonitoringSession::class)->constrained('sessions');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
