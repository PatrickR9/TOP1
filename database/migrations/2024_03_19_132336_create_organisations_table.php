<?php

use App\Models\Team;
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
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class);
            $table->string('title', 150)->nullable();
            $table->string('short_title', 45)->nullable();
            $table->string('street', 250)->nullable();
            $table->string('zip', 15)->nullable();
            $table->string('city', 250)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('website', 500)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('logo_for_light_bg', 500)->nullable();
            $table->string('logo_for_dark_bg', 500)->nullable();
            $table->text('cd_colors')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};
