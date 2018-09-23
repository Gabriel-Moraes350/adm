<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $query = "CREATE TABLE roles(
            id INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
            name varchar(255) not null unique,
             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
        deleted_at TIMESTAMP NULL DEFAULT null
)";
        DB::statement($query);


        $query = "
        CREATE TABLE user_roles(
        id INT(11) UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
        role_id INT(11) UNSIGNED,
        user_id INT(11) UNSIGNED,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
        deleted_at TIMESTAMP NULL DEFAULT null
        add constraint fk_user_role foreign key (user_id) references user(id),
        add constraint fk_role_user foreign key (role_id) references role(id)
      )";
        DB::statement($query);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('user_roles');
//        Schema::dropIfExists('roles');
    }
}
