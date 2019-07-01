<?php

namespace Zent\User\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * @method static create($data)
 */
class User extends Authenticatable
{
    use EntrustUserTrait { restore as private restoreA; }
    use SoftDeletes { restore as private restoreB; }

    /*
     * Tables
     */

    protected $table = "users";

    /*
     * Fillables
     */

    protected $fillable = ['email', 'password', 'status', 'remember_token', 'name', 'gender', 'birthday', 'mobile','type'];

    /*
     * Soft Deletes
     */

    protected $dates = ['deleted_at'];

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function activity_log()
    {
        return $this->hasMany('Zent\ActivityLog\Models\ActivityLog', 'id', 'causer_id');
    }

    public static function userLogin()
    {
        return Auth::guard('web')->user()->id;
    }
}
