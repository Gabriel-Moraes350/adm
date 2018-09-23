<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Sep 2018 00:58:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UserRole
 * 
 * @property int $id
 * @property int $role_id
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class UserRole extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'role_id',
		'user_id'
	];
}
