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
        Schema::create('content2_meta_fields_autosaves', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('autosave_version');
            $table->unsignedBigInteger('content_id');
            $table->unsignedBigInteger('content_meta_field_id');
            $table->text('value')->nullable();
            $table->tinyInteger('version_type')->default(0); # 0 = edited version, 1 = backup version, 100 = live version
            $table->unsignedSmallInteger('sort');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content2_meta_fields_autosaves');
    }
};
