<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Sep 2018 00:58:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class Role extends Eloquent
{
    const ROLE_ADMIN = 1;
	use \Illuminate\Database\Eloquent\SoftDeletes;
	public $timestamps = false;

	protected $fillable = [
		'name'
	];
}
