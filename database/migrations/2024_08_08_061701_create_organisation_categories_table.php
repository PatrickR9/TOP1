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
        Schema::create('organisation_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->bigInteger('parent')->nullable();
            $table->foreignIdFor(Organisation::class);            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisation_categories');
    }
};
/*CREATE TABLE IF NOT EXISTS `mydb`.`organisation_categories` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `parent` INT UNSIGNED NULL,
  `organisations_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_organisation_categories_organisations1_idx` (`organisations_id` ASC) VISIBLE,
  CONSTRAINT `fk_organisation_categories_organisations1`
    FOREIGN KEY (`organisations_id`)
    REFERENCES `mydb`.`organisations` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB*/