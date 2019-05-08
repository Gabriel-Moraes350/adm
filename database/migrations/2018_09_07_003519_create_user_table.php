<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = "CREATE TABLE IF NOT EXISTS `user` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`login` VARCHAR(100) NOT NULL unique ,
	`password` VARCHAR(255) NOT NULL,
	`remember_token` VARCHAR(255),
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
";

        DB::statement($query);

        $query = "INSERT INTO user (id, name, login, password) values (1, 'teste', 'adm@gmail.com','". \Illuminate\Support\Facades\Hash::make('123123') ."')";

        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('user');
    }
}
