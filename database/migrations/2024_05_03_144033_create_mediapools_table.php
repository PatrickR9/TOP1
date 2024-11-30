<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\MediapoolCategory;
use App\Models\User;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mediapools', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MediapoolCategory::class);
            $table->foreignIdFor(User::class);
            $table->string('filename', 510);
            $table->string('label', 255)->nullable();
            $table->string('author', 255)->nullable();
            $table->text('uploaded_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediapools');
    }
};
