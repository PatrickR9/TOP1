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
        Schema::create('rio_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->bigInteger('parent')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rio_categories');
    }
};

/*CREATE TABLE IF NOT EXISTS `mydb`.`rio_categories` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `parent` INT UNSIGNED NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB*/
