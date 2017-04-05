<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mnl extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'masternodelist';

	/**
	 * The attributes to be fillable from the model.
	 *
	 * A dirty hack to allow fields to be fillable by calling empty fillable array
	 *
	 * @var array
	 */
	protected $fillable = [];
	protected $guarded = ['id'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];
}
