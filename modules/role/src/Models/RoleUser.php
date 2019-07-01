<?php

namespace Zent\Role\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'role_id',
    ];

    protected $table = "role_users";

    /**
     * Get array role of user
     * @return array
     */
    public static function getArrayRole($user_id)
    {
        $data = array();

        $roles = self::select('role_id')->where('user_id', $user_id)->get();

        foreach ($roles as $key => $role)
        {
            $data[$key] = $role->role_id;
        }

        return $data;

    }

    /**
     *
     */
    public static function checkRoleUserExist($data)
    {
        $check = self::where([
                    'user_id'       =>  $data['user_id'],
                    'role_id'       =>  $data['role_id']
                ])->count();

        return $check > 0 ? true : false;
    }

    /**
     *
     */
    public static function remove($data)
    {
        return self::where([
                    'user_id'       =>  $data['user_id'],
                    'role_id'       =>  $data['role_id']
                ])->delete();
    }
}
