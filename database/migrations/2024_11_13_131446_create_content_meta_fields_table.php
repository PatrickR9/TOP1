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
        Schema::create('content_meta_fields', function (Blueprint $table) {
            $table->id();
            $table->string('label', 255);
            $table->text('text_before_field')->nullable();
            $table->text('text_after_field')->nullable();
            $table->text('description')->nullable();
            $table->string('required')->default('["0"]');
            $table->string('required_theme')->default('["0"]');
            $table->string('required_concept')->default('["0"]');
            $table->text('type')->default('["text"]');
            $table->text('data_source')->nullable();
            $table->string('css_class', 255);
            $table->text('code_to_insert')->nullable();
            $table->tinyInteger('display')->default(0); # 0 = hidden field, x = [1-5] display on step_x
            $table->tinyInteger('active')->default(0);
            $table->text('contribution_check')->nullable(); # for unit only
            $table->text('contribution_warnings')->nullable(); # for unit only
            $table->text('contribution_check_theme')->nullable(); # for theme only
            $table->text('contribution_warnings_theme')->nullable(); # for theme only
            $table->text('contribution_check_concept')->nullable(); # for concept only
            $table->text('contribution_warnings_concept')->nullable(); # for concept only
            $table->tinyInteger('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_meta_fields');
    }
};
