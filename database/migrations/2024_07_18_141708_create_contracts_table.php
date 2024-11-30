<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Organisation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organisation::class);
            $table->dateTime('date_start')->nullable();
            $table->enum('status', ['draft', 'active'])->nullable();
            $table->longText('contract')->nullable();
            $table->string('representative_name', 250)->nullable();
            $table->string('representative_sing_image', 250)->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
