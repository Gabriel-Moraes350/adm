<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 24 Sep 2018 00:49:02 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Article
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Article extends Eloquent
{
	protected $fillable = [
		'name',
		'description',
		'image'
	];
}
