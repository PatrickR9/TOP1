<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Content;
use App\Models\GroupCategory;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_has_group_categories', function (Blueprint $table) {
            $table->foreignIdFor(Content::class);
            $table->foreignIdFor(GroupCategory::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_has_group_categories');
    }
};

/*CREATE TABLE IF NOT EXISTS `mydb`.`contents_has_group_categories` (
  `contents_id` INT NOT NULL,
  `group_categories_id` INT NOT NULL,
  PRIMARY KEY (`contents_id`, `group_categories_id`),
  INDEX `fk_contents_has_group_categories_group_categories1_idx` (`group_categories_id` ASC) VISIBLE,
  INDEX `fk_contents_has_group_categories_contents1_idx` (`contents_id` ASC) VISIBLE,
  CONSTRAINT `fk_contents_has_group_categories_contents1`
    FOREIGN KEY (`contents_id`)
    REFERENCES `mydb`.`contents` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_contents_has_group_categories_group_categories1`
    FOREIGN KEY (`group_categories_id`)
    REFERENCES `mydb`.`group_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB*/