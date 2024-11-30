<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ContentGroup;
use App\Models\Editorial;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('editorial_has_content_groups', function (Blueprint $table) {
            $table->foreignIdFor(Editorial::class);
            $table->foreignIdFor(ContentGroup::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editorial_has_content_groups');
    }
};
/*
CREATE TABLE IF NOT EXISTS `mydb`.`editorials_has_content_groups` (
  `editorials_id` INT NOT NULL,
  `content_groups_id` INT NOT NULL,
  PRIMARY KEY (`editorials_id`, `content_groups_id`),
  INDEX `fk_editorials_has_content_groups_content_groups1_idx` (`content_groups_id` ASC) VISIBLE,
  INDEX `fk_editorials_has_content_groups_editorials1_idx` (`editorials_id` ASC) VISIBLE,
  CONSTRAINT `fk_editorials_has_content_groups_editorials1`
    FOREIGN KEY (`editorials_id`)
    REFERENCES `mydb`.`editorials` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_editorials_has_content_groups_content_groups1`
    FOREIGN KEY (`content_groups_id`)
    REFERENCES `mydb`.`content_groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB*/