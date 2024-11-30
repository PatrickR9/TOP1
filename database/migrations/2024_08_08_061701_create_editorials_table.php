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
        Schema::create('editorials', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organisation::class);            
            $table->string('title', 80)->nullable();
            $table->longText('description')->nullable();
            $table->string('short_description', 250)->nullable();
            $table->string('logo', 500)->nullable();
            $table->string('logo_for_light_bg', 500)->nullable();
            $table->string('logo_for_dark_bg', 500)->nullable();
            $table->json('cd_colors')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editorials');
    }
};
/*
CREATE TABLE IF NOT EXISTS `mydb`.`editorials` (
    `id` INT NOT NULL,
    `organisations_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(80) NULL,
    `description` LONGTEXT NULL,
    `short_description` VARCHAR(250) NULL,
    `logo` VARCHAR(500) NULL,
    `logo_for_light_bg` VARCHAR(500) NULL,
    `logo_for_dark_bg` VARCHAR(500) NULL,
    `cd_colors` JSON NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_editorials_organisations_idx` (`organisations_id` ASC) VISIBLE,
    CONSTRAINT `fk_editorials_organisations`
      FOREIGN KEY (`organisations_id`)
      REFERENCES `mydb`.`organisations` (`id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
  ENGINE = InnoDB*/