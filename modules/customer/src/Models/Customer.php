<?php

namespace Zent\Customer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create($data)
 */
class Customer extends Model
{

    use SoftDeletes;
    /*
     * Tables
     */

    protected $table = "customers";

    /*
     * Fillables
     */

    protected $fillable = ['email', 'password', 'status', 'remember_token', 'name', 'gender', 'birthday', 'mobile','type'];

    /*
     * Soft Deletes
     */

    protected $dates = ['deleted_at'];
}
