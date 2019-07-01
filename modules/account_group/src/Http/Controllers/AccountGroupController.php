<?php

namespace Zent\AccountGroup\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Zent\Account\Models\Account;
use Zent\AccountGroup\Models\AccountGroup;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use View;
use Zent\User\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Jobs\ChangePasswordGarena;
use File;
use Response;
use App\Models\Notification;

class AccountGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('account_group');
        View::share('display_name', $display_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accountGroup::backend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accountGroup::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = array();
            parse_str($request->data, $data);

            $data['user_created_id'] = Auth::guard('web')->user()->id;

            AccountGroup::create($data);
            
            Notification::sendNotification(Auth::guard('web')->user()->name . Notification::CREATE_ACCOUNT_GROUP);

            DB::commit();
            return response()->json(['err' => false, 'msg' => trans('global.create_success')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['err' => true, 'msg' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account_group = AccountGroup::find($id);

        return view('accountGroup::backend.edit', compact('account_group', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = array();
            parse_str($request->data, $data);
            AccountGroup::find($data['account_group_id'])->update($data);
            
            Notification::sendNotification(Auth::guard('web')->user()->name . Notification::UPDATE_ACCOUNT_GROUP);

            DB::commit();
            return response()->json(['err' => false, 'msg' => trans('global.update_success')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['err' => true, 'msg' => $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            AccountGroup::find($request->id)->delete();
            Account::where('group_account_id', $request->id)->delete();
            
            Notification::sendNotification(Auth::guard('web')->user()->name . Notification::DELETE_ACCOUNT_GROUP);

            DB::commit();
            return response()->json([ 'err' => false, 'msg' =>  trans('global.delete_success')]);

        } catch (\Exception $e) {
            return response()->json(['err'  =>  true, 'msg' =>  $e->getMessage()]);
        }
    }

    /**
     * Return view front end.
     *
     */
    public function home()
    {
        return view('accountGroup::frontend.index');
    }

    /**
     * DataTables get list accountGroup
     */
    public static function getListAccountGroup()
    {
        $user_id = Auth::guard('web')->user()->id;

        switch ($user_id)
        {
            case 1: // super admin
                $account_groups = AccountGroup::orderBy('id', 'desc')->get();
                break;
            default:
                $account_groups = AccountGroup::orderBy('id', 'desc')->where('user_created_id', $user_id)->get();
                break;
        }

        return DataTables::of($account_groups)
            ->addIndexColumn()
            ->addColumn('action', function ($account_group) {
                $txt = "";

                $txt .= '<button data-id="' . $account_group->id . '" href="#" type="button" class="btn btn-success pd-0 wd-30 ht-20 btn-list-account" data-tooltip="tooltip" data-placement="top" title="Danh sách tài khoản"/><i class="fa fa-list" aria-hidden="true"></i></button>';

                if ($account_group->user_created_id == User::userLogin())
                {
                    // Edit button
                    $txt .= '<button data-id="' . $account_group->id . '" href="#" type="button" class="btn btn-warning pd-0 wd-30 ht-20 btn-edit" data-tooltip="tooltip" data-placement="top" title="' . trans('global.edit') . '"/><i class="fa fa-pencil" aria-hidden="true"></i></button>';

                    // Delete button
                    $txt .= '<button data-id="' . $account_group->id . '" href="#" type="button" class="btn btn-danger pd-0 wd-30 ht-20 btn-delete" data-tooltip="tooltip" data-placement="top" title="' . trans('global.delete') . '"/><i class="fa fa-trash" aria-hidden="true"></i></button>';

                }

                return $txt;
            })
            ->editColumn('created_at', function ($account_group) {
                return date('H:i | d-m-Y', strtotime($account_group->created_at));
            })
            ->editColumn('content', function ($account_group) {
                return !is_null($account_group->content) ? $account_group->content : trans('global.not_updated');
            })
            ->editColumn('status', function ($account_group) {
                return ($account_group->status == 1) ? trans('global.show') : trans('global.hide');
            })
            ->editColumn('user_created_id', function ($account_group) {
                return User::find($account_group->user_created_id)->name;
            })
            ->addColumn('all_account', function ($account_group){
                $number = AccountGroup::countNumberAllAccount($account_group->id);
                return '<span class="nb-all">'.$number.'</span>';
            })
            ->addColumn('changed_account', function ($account_group) {
                $number_submitted = AccountGroup::countSubmitedAccount($account_group->id);
                $number_success = AccountGroup::countSuccessAccount($account_group->id);
                return '<span class="nb-changed">'.$number_success.' - '.$number_submitted.'</span>';
            })
            ->addColumn('not_changed_account', function ($account_group) {
                $number = AccountGroup::countNotSubmitedAccount($account_group->id);
                return '<span class="nb-not-changed">'.$number.'</span>';
            })
            ->rawColumns(['action', 'all_account', 'changed_account', 'not_changed_account'])
            ->toJson();
    }

    public function listAccount($group_account_id)
    {
        if (User::userLogin() != 1) // user -> view only group
        {
            $groups = AccountGroup::where('id', $group_account_id)->where('user_created_id', User::userLogin())->first();
        } else { // super admin -> view all
            $groups = AccountGroup::where('id', $group_account_id)->first();
        }

        if (is_null($groups))
        {
            abort(404);
        }

        $accounts = Account::where('group_account_id', $group_account_id)->orderBy('id', 'desc')->get();

        $number = array();

        $number['all_account'] = AccountGroup::countNumberAllAccount($group_account_id);
        $number['changed'] = AccountGroup::countSubmitedAccount($group_account_id);
        $number['not_changed'] = AccountGroup::countNotSubmitedAccount($group_account_id);
        $number['success'] = AccountGroup::countSuccessAccount($group_account_id);

        $permission = $groups->user_created_id == User::userLogin() ? true : false;

        return view('accountGroup::backend.account', compact('accounts', 'groups', 'number', 'permission'));
    }

    public static function createAccount($group_id)
    {
        $groups = AccountGroup::find($group_id);

        return view('account::backend.create', compact('groups'));
    }

    public static function countAccount(Request $request)
    {
        $number = array();
        $number['all_account'] = Account::where('group_account_id', $request->group_account_id)->count();
        $number['changed'] = Account::where('group_account_id', $request->group_account_id)->where('status', 0)->count();
        $number['not_changed'] = Account::where('group_account_id', $request->group_account_id)->where('status', 1)->count();

        return response()->json(['msg' => false, 'number' => $number]);
    }

    public static function getInfoPassword(Request $request)
    {
        $number= AccountGroup::countNotSubmitedAccount($request->group_account_id);

        $time = gmdate("H:i:s", $number * 6);;

        return response()->json(['msg' => false, 'number' => $number, 'time' => $time]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function changePassword(Request $request)
    {
        $group_id = $request->group_account_id;
        $group = AccountGroup::find($group_id);

        if ($group->user_created_id != User::userLogin())
        {
            return response()->json(['err' => true, 'msg' => 'Không có quyền sử dụng nhóm tài khoản này.']);
        }

        $accounts = Account::where('group_account_id', $group_id)->where('is_submit', 0)->get();

        $res = array();

        if (!is_null($accounts))
        {
            foreach ($accounts as $account)
            {
                $new_password = $request->password_new . rand(1000, 9999);
                // $new_password = $request->password_new;
                $job = (new ChangePasswordGarena($account->id, $account->username, $account->password, $new_password, 'dungnc'));
                dispatch($job);
            }
        }

        $msg = 'Đặt lệnh đổi mật khẩu cho nhóm tài khoản thành công, vui lòng kiểm tra lại sau khi hết thời gian !';

        Notification::sendNotification(Auth::guard('web')->user()->name . Notification::CHANGE_PASSWORD);

        return response()->json(['err' => false, 'msg' => $msg]);
    }

    public function download($group_id, $status)
    {
        if (!Auth::guard('web')->check())
        {
            abort(404);
        }

        $group = AccountGroup::find($group_id);

        if (Auth::guard('web')->id() != 1 && Auth::guard('web')->id() != $group->user_created_id)
        {
            abort(404);
        }

        $group_name = str_slug($group->name);
        $note = null;
        $data = array();
        $string = null;

        switch ($status)
        {
            case 2:
                $note = 'full';
                $accounts = AccountGroup::getAllAccount($group_id);
                break;
            case 1:
                $note = 'submitted'; // da thuc hien doi pass
                $accounts = AccountGroup::getSubmittedAccount($group_id);
                break;
            case 0:
                $note = 'success'; // doi thanh cong
                $accounts = AccountGroup::getSuccessAccount($group_id);
                break;
            case -1:
                $note = 'not-submitted'; // chua thuc hien doi pass
                $accounts = AccountGroup::getNotSubmitedAccount($group_id);

        }

        if (!is_null($accounts))
        {
            foreach ($accounts as $account)
            {
                if ($account->status == 0)
                {
                    $string .= $account->username . '|' . $account->password_new . "\r\n";
                } else {
                    $string .= $account->username . '|' . $account->password . "\r\n";
                }
            }
        }

        $file = date('d-m-Y', strtotime(now())) . '.txt';

        $destinationPath = public_path()."/upload/account/" . $group_name . '-' . $note . '@';

        if ( !is_dir($destinationPath))
        {
            mkdir($destinationPath,0777,true);
        }

        File::put($destinationPath.$file, $string);

        Notification::sendNotification(Auth::guard('web')->user()->name . Notification::DOWNLOAD_LIST_ACCOUNT);

        return response()->download($destinationPath.$file);
    }
}
