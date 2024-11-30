<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ContentGroup;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45)->nullable();
            $table->bigInteger('parent')->nullable();
            $table->foreignIdFor(ContentGroup::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_categories');
    }
};
/*CREATE TABLE IF NOT EXISTS `mydb`.`group_categories` (
    `id` INT NOT NULL,
    `name` VARCHAR(45) NULL,
    `parent` INT UNSIGNED NULL,
    `content_groups_id` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_group_categories_content_groups1_idx` (`content_groups_id` ASC) VISIBLE,
    CONSTRAINT `fk_group_categories_content_groups1`
      FOREIGN KEY (`content_groups_id`)
      REFERENCES `mydb`.`content_groups` (`id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
  ENGINE = InnoDB*/