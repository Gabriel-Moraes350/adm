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

        $query = "CREATE TABLE IF NOT EXISTS  roles(
            id INT(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT,
            name varchar(255) not null unique,
            guard_name varchar(255) not null,
             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
             
             updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(),
        deleted_at TIMESTAMP NULL DEFAULT null
)";
        DB::statement($query);

        $query = "INSERT INTO roles
(id, name, guard_name, created_at)
VALUES(1, 'Admin', 'web', '2018-09-24 00:19:26.000')
";

        DB::statement($query);


        $query = "
        CREATE TABLE IF NOT EXISTS user_roles(
        id INT(11) UNSIGNED  PRIMARY KEY AUTO_INCREMENT,
        role_id INT(11) UNSIGNED,
        user_id INT(11) UNSIGNED,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
        deleted_at TIMESTAMP NULL DEFAULT null
      )";
        DB::statement($query);

        $query = "ALTER TABLE user_roles ADD CONSTRAINT fk_role_user FOREIGN KEY (user_id) REFERENCES user(id)";

        DB::statement($query);


        $query = "ALTER TABLE user_roles ADD CONSTRAINT fk_role_role FOREIGN KEY (role_id) REFERENCES roles(id)";

        DB::statement($query);

        $query = "INSERT INTO user_roles
(id, role_id, user_id, created_at, deleted_at)
VALUES(1, 1, 1, '2019-05-08 13:20:02.000', NULL)";
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
