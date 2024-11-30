<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Editorial;
use App\Models\Organisation;
use App\Models\Mediapool;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['thema', 'einheit', 'element', 'konzept'])->nullable();
            $table->foreignIdFor(Organisation::class);
            $table->foreignIdFor(Editorial::class); # author_id = user_id
            $table->foreignIdFor(User::class, 'author_id'); 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
