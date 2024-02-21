<?php

use App\Models\Point;
use App\Models\MonitoringSession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('biodiversity_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Point::class)->constrained('points');
            $table->foreignIdFor(MonitoringSession::class)->constrained('sessions');
            $table->string('photo');
            $table->string('species')->nullable();
            $table->integer('count');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('biodiversity_entries');
    }
};
