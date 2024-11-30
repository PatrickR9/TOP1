<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Contract;
use App\Models\User;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('author_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contract::class);
            $table->foreignIdFor(User::class);
            $table->dateTime('sign_date')->nullable();
            $table->string('signed_pdf', 500)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_contracts');
    }
};