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
        Schema::create('siteblocks_autosaves', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('autosave_version')->default(0);
            $table->unsignedBigInteger('siteblock_id')->nullable();
            $table->unsignedBigInteger('usersite_id')->nullable();
            $table->unsignedBigInteger('content_id')->nullable();
            $table->longText('content');    # html content without classes
            $table->string('tag', 50)->default('');
            $table->text('attribs');
            $table->string('editor_id', 100)->default('');
            $table->text('editor_attribs');
            $table->integer('sort');
            $table->tinyInteger('active')->default('1');
            $table->tinyInteger('version_number')->default(0);
            $table->tinyInteger('version_type')->default(0); # 0 = edited, 1 = backup, 100 = live
            $table->tinyInteger('template')->default(0); # 0 = no, 1 = yes
            $table->string('session_id', 255)->default('');
            $table->timestamp('last_activity')->useCurrent();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siteblocks_autosaves');
    }
};