<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Pusher\Pusher;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Notification extends Model
{   
    use SoftDeletes;

    const CREATE_ACCOUNT_GROUP = ' đã tạo nhóm tài khoản.';
    const UPDATE_ACCOUNT_GROUP = ' đã chỉnh sửa nhóm tài khoản.';
    const DELETE_ACCOUNT_GROUP = ' đã xóa nhóm tài khoản.';
    const CHANGE_PASSWORD = ' đã đặt lệnh đổi mật khẩu cho nhóm tài khoản.';
    const DOWNLOAD_LIST_ACCOUNT = ' đã tải xuống danh sách tài khoản.';

    const CREATE_ACCOUNT = ' đã thêm tài khoản vào nhóm.';
    const DELETE_ACCOUNT = ' đã xóa một tài khoản trong nhóm.';
    protected $table = "notifications";

    protected $fillable = ['msg', 'creator_id'];

    protected $dates = ['deleted_at'];

    public $pusher;
    public $options;

    public static function sendNotification($msg)
    {   
        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        
        self::storeNotify($msg);
        
        return $pusher->trigger('Notify', 'send-message', $msg);
    }

    public static function storeNotify($msg)
    {   
        $notify = [
            'msg'           =>  $msg
        ];

        return self::create($notify);
    }

}
