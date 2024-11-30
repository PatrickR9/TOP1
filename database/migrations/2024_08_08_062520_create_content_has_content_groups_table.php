<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Content;
use App\Models\ContentGroup;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_has_content_groups', function (Blueprint $table) {
            $table->foreignIdFor(Content::class);
            $table->foreignIdFor(ContentGroup::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_has_content_groups');
    }
};
/*CREATE TABLE IF NOT EXISTS `mydb`.`contents_has_content_groups` (
    `contents_id` INT NOT NULL,
    `content_groups_id` INT NOT NULL,
    PRIMARY KEY (`contents_id`, `content_groups_id`),
    INDEX `fk_contents_has_content_groups_content_groups1_idx` (`content_groups_id` ASC) VISIBLE,
    INDEX `fk_contents_has_content_groups_contents1_idx` (`contents_id` ASC) VISIBLE,
    CONSTRAINT `fk_contents_has_content_groups_contents1`
      FOREIGN KEY (`contents_id`)
      REFERENCES `mydb`.`contents` (`id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
    CONSTRAINT `fk_contents_has_content_groups_content_groups1`
      FOREIGN KEY (`content_groups_id`)
      REFERENCES `mydb`.`content_groups` (`id`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
  ENGINE = InnoDB*/