<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Content;
use App\Models\Team;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usersites', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class); # Members of administrators can can edit all pages and only he/she can create a standard page. Standard page = any page of the Website, custom_* = sites for material pool
            $table->foreignIdFor(Team::class)->nullable(); # Members of owned team of site owner, if they are "admin" in team
            $table->foreignIdFor(Content::class)->nullable(); # if content_id exists, shown as content site else as stndard site
            $table->string('title', 255)->default('new site');
            $table->string('url',1000);
            $table->tinyInteger('status')->default(0); # 0 = offline, 1 = online
            $table->tinyInteger('type')->default(0);   # 0 = standard (only admin can create or edit ), 1 = custom_standard, 2 = custom_premium ?????
            $table->bigInteger('parentid')->nullable();  # parent site
            $table->unsignedInteger('ordernr')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usersites');
    }
};
/*
CREATE TABLE IF NOT EXISTS `mydb`.`contents` (
  `id` INT NOT NULL,
  `type` ENUM('thema', 'einheit', 'element', 'konzept') NULL,
  `titel` VARCHAR(80) NULL,
  `text` LONGTEXT NULL,
  `users_id` INT NOT NULL,
  `organisations_id` INT UNSIGNED NOT NULL,
  `editorials_id` INT NOT NULL,
  `authors_id` INT NOT NULL,
  `image` VARCHAR(500) NULL,
  `short_text` VARCHAR(250) NULL,
  `exzerpt` MEDIUMTEXT NULL,
  `preparation_time_from` INT UNSIGNED NULL,
  `preparation_time_until` INT UNSIGNED NULL,
  `duration_time_from` INT UNSIGNED NULL,
  `duration_time_until` INT UNSIGNED NULL,
  `bible_passage` VARCHAR(45) NULL,
  `additional_bible_passages` JSON NULL,
  `attachments` JSON NULL,
  `stuff_items` JSON NULL,
  `sub_contents` JSON NULL,
  `alternative_authors` JSON NULL,
  `external_rights` JSON NULL,
  `visibility` ENUM('free', 'restricted') NULL,
  `visibility_date` DATETIME NULL,
  `status` ENUM('draft', 'for_correction', 'corrected', 'active') NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_contents_organisations1_idx` (`organisations_id` ASC) VISIBLE,
  INDEX `fk_contents_editorials1_idx` (`editorials_id` ASC) VISIBLE,
  INDEX `fk_contents_authors1_idx` (`authors_id` ASC) VISIBLE,
  INDEX `fk_contents_users1_idx` (`users_id` ASC) VISIBLE,
  CONSTRAINT `fk_contents_organisations1`
    FOREIGN KEY (`organisations_id`)
    REFERENCES `mydb`.`organisations` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contents_editorials1`
    FOREIGN KEY (`editorials_id`)
    REFERENCES `mydb`.`editorials` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contents_authors1`
    FOREIGN KEY (`authors_id`)
    REFERENCES `mydb`.`persons` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contents_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `mydb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
*/