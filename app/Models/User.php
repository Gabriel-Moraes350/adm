<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Sep 2018 00:58:06 +0000.
 */

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $login
 * @property string $password
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'user';
    use Notifiable;
	public $timestamps = false;

	protected $hidden = [
		'password', 'remember_token'
	];

	protected $fillable = [
		'name',
		'login',
		'password'
	];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

	public function getRolesArray() : array
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')->pluck('roles.id')->toArray();
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

}
