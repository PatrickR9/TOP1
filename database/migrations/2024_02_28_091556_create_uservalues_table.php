<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uservalues', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->unique();
            $table->string('firstname', 150)->nullable();
            $table->string('lastname', 150)->nullable();
            $table->string('street', 250)->nullable();
            $table->string('zip', 15)->nullable();
            $table->string('city', 250)->nullable();
            $table->string('country', 2)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('email', 250)->unique()->nullable();
            $table->string('website', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uservalues');
    }
};

/*CREATE TABLE IF NOT EXISTS `mydb`.`persons` (
    `id` INT NOT NULL,
    `firstname` VARCHAR(150) NULL,
    `lastname` VARCHAR(150) NULL,
    `street` VARCHAR(250) NULL,
    `zip` VARCHAR(15) NULL,
    `city` VARCHAR(250) NULL,
    `country` VARCHAR(2) NULL,
    `birthdate` DATE NULL,
    `email` VARCHAR(250) NULL,
    `website` VARCHAR(500) NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
  ENGINE = InnoDB*/