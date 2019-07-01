<?php

namespace Zent\Account\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use DB;

class Account extends Model
{
    use SoftDeletes;
    /*
     * Tables
     */
    
    protected $table = "accounts";

    /*
     * Fillables
     */
    
    protected $fillable = ['group_account_id', 'username', 'password', 'password_new', 'user_id', 'status', 'email', 'mobile', 'message', 'is_submit'];

    /*
     * Soft Deletes
     */
    
    protected $dates = ['deleted_at'];

    const STATUS_CHANGE_SUCCESS = 0;
    const CHANGE_PASSWORD_SUCCESS = "Đã đổi mật khẩu thành công";
    const SUBMITTED_CHANGE_PASSWORD = "Đã thực hiện đổi mật khẩu";
    const NOT_SUBMITTED_CHANGE_PASSWORD = "Chưa thực hiện đổi mật khẩu";

    // not changed >= 1

    /**
     * @param $res
     */
    public static function handleResponse($id, $res, $new_password)
    {
        // dd($res);
        try {
            DB::beginTransaction();
            
            $data = array();
            $data['status'] = isset($res['status']) ? $res['status'] : null;
            $data['mobile'] = isset($res['phone']) ? $res['phone'] : null;
            $data['email'] = isset($res['email']) ? $res['email'] : null;
            $data['message'] = isset($res['message']) ? $res['message'] : null;
            $data['password_new'] = $data['status'] == 0 ? $new_password : null;
            $data['is_submit'] = 1;

            // Nếu status == 0 -> đã đổi được pass -> thì không update nữa

            if (Account::find($id)->status != 0)
            {
                $result = Account::find($id)->update($data);
                Log::info('Change password account id '.$id.' by api success !');
            }

            DB::commit();

        } catch ( \Exception $e)
        {
            Log::error($e->getMessage());
        }

    }
}
