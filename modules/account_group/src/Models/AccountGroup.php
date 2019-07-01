<?php

namespace Zent\AccountGroup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zent\Account\Models\Account;

class AccountGroup extends Model
{
    use SoftDeletes;
    /*
     * Tables
     */
    
    protected $table = "account_groups";

    /*
     * Fillables
     */
    
    protected $fillable = ['name', 'content', 'status', 'user_created_id'];

    /*
     * Soft Deletes
     */
    
    protected $dates = ['deleted_at'];

    public static function countNumberAllAccount($group_id)
    {
        $accounts = Account::where('group_account_id', $group_id)->count();
        return !is_null($accounts) ? $accounts : null;
    }

    public static function countSubmitedAccount($group_id)
    {
        $accounts = Account::where('group_account_id', $group_id)->where('is_submit', 1)->count();
        return !is_null($accounts) ? $accounts : null;
    }

    public static function countNotSubmitedAccount($group_id)
    {
        $accounts = Account::where('group_account_id', $group_id)->where('is_submit', 0)->count();
        return !is_null($accounts) ? $accounts : null;
    }

    public static function countSuccessAccount($group_id)
    {
        $accounts = Account::where('group_account_id', $group_id)->where('is_submit', 1)->where('status', 0)->count();
        return !is_null($accounts) ? $accounts : null;
    }

    public static function getAllAccount($group_id)
    {
        $accounts = Account::where('group_account_id', $group_id)->get();
        return !is_null($accounts) ? $accounts : null;
    }

    public static function getSubmittedAccount($group_id)
    {
        $accounts = Account::where('group_account_id', $group_id)->where('is_submit', 1)->get();
        return !is_null($accounts) ? $accounts : null;
    }

    public static function getSuccessAccount($group_id)
    {
        $accounts = Account::where('group_account_id', $group_id)->where('is_submit', 1)->where('status', 0)->get();
        return !is_null($accounts) ? $accounts : null;
    }

    public static function getNotSubmitedAccount($group_id)
    {
        $accounts = Account::where('group_account_id', $group_id)->where('is_submit', 0)->get();
        return !is_null($accounts) ? $accounts : null;
    }
}
