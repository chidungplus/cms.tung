<?php

namespace Zent\Permission\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "permission_roles";

    // protected $primaryKey = ['permission_id', 'role_id'];

    protected $fillable = [
        'permission_id', 'role_id',
    ];

    public static function getListPermissionByRoleId($role_id)
    {
        return self::where('role_id', $role_id)->get();
    }

    public static function checkPermissionRoleExist($data)
    {
        $check = self::where([
                        'permission_id' =>  $data['permission_id'],
                        'role_id'       =>  $data['role_id']
                    ])->count();

        return $check > 0 ? true : false;
    }

    public static function remove($data)
    {
        return self::where([
                        'permission_id' =>  $data['permission_id'],
                        'role_id'       =>  $data['role_id']
                    ])->delete();
    }

    /**
     * Get array permission of role
     * @return array
     */
    public static function getArrayPermission($role_id)
    {
        $data = array();

        $permissions = self::select('permission_id')->where('role_id', $role_id)->get();

        foreach ($permissions as $key => $permission)
        {
            $data[$key] = $permission->permission_id;
        }

        return $data;

    }
}
