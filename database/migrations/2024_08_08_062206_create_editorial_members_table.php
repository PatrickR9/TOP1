<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Editorial;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('editorial_members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Editorial::class);
            $table->enum('role', ['guest', 'author', 'corrector', 'editor', 'administrator'])->nullable();
            $table->enum('status', ['invited', 'active'])->nullable();
            $table->string('invitation_code', 150)->nullable();
            $table->dateTime('invitation_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editorial_members');
    }
};

/*
 CREATE TABLE IF NOT EXISTS `mydb`.`editorial_members` (
  `id` INT NOT NULL,
  `users_id` INT NOT NULL,
  `editorials_id` INT NOT NULL,
  `role` ENUM('guest', 'author', 'corrector', 'editor', 'administrator') NULL,
  `status` ENUM('invited', 'active') NULL,
  `invitation_code` VARCHAR(150) NULL,
  `invitation_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_editorial_members_users1_idx` (`users_id` ASC) VISIBLE,
  INDEX `fk_editorial_members_editorials1_idx` (`editorials_id` ASC) VISIBLE,
  CONSTRAINT `fk_editorial_members_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `mydb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_editorial_members_editorials1`
    FOREIGN KEY (`editorials_id`)
    REFERENCES `mydb`.`editorials` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB

 */