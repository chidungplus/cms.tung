<?php

namespace Zent\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Zent\Account\Models\Account;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use View;
use Zent\AccountGroup\Models\AccountGroup;
use Zent\User\Models\User;
use App\Models\Notification;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('account');
        View::share('display_name', $display_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('account::backend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = AccountGroup::orderBy('id', 'desc')->get();

        return view('account::backend.create', compact('groups'));
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

            parse_str($request->data, $data);
            $arr_account = explode(PHP_EOL, $data['accounts']);

            if (!is_null($arr_account))
            {
                foreach ($arr_account as $value)
                {
                    $account = explode('|', $value);
                    $account = str_replace(PHP_EOL, "", $account);
                    $account = str_replace("\n", "", $account);
                    $account = str_replace("\r", "", $account);

                    $user_name = $account[0];
                    $password  = $account[1];

                    Account::create([
                        'group_account_id' => $data['group_account_id'],
                        'username'         => $user_name,
                        'password'         => $password
                    ]);
                }
            }

            Notification::sendNotification(Auth::guard('web')->user()->name . Notification::CREATE_ACCOUNT);

            DB::commit();
            return response()->json(['err' => false, 'msg' => trans('global.create_success')]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['err' => true, 'msg' => 'Vui lòng nhập đúng định dạng danh sách tài khoản']);
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
        $account = Account::find($id);

        return view('account::backend.edit', compact('account', 'id'));
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
            Account::find($data['account_id'])->update($data);

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
            $account = Account::find($request->id);

            if (!is_null($account))
            {
                $group = AccountGroup::find($account->group_account_id);

                if (is_null($group))
                {
                    abort(404);
                }

                if (User::userLogin() != $group->user_created_id)
                {
                    abort(404);
                }
            }

            Account::find($request->id)->delete();

            Notification::sendNotification(Auth::guard('web')->user()->name . Notification::DELETE_ACCOUNT);

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
        return view('account::frontend.index');
    }

    /**
     * DataTables get list account
     */
    public static function getListAccount(Request $request)
    {
        $accounts = Account::where('group_account_id', $request->group_account_id)->orderBy('id', 'desc')->get();
        $group = AccountGroup::find($request->group_account_id);

        return DataTables::of($accounts)
            ->addIndexColumn()
            ->addColumn('action', function ($account) use ($group){
                $txt = "";

                if ($group->user_created_id == User::userLogin())
                {
                    $txt .= '<button data-id="' . $account->id . '" href="#" type="button" class="btn btn-danger pd-0 wd-30 ht-20 btn-delete" data-tooltip="tooltip" data-placement="top" title="' . trans('global.delete') . '"/><i class="fa fa-trash" aria-hidden="true"></i></button>';
                }

                return $txt;
            })
            ->editColumn('created_at', function ($account) {
                return date('H:i | d-m-Y', strtotime($account->created_at));
            })
            ->editColumn('group_account_id', function ($account) {
                $group = AccountGroup::find($account->group_account_id);
                return !is_null($group) ? $group->name : trans('global.not_updated');
            })
            ->editColumn('status', function ($account) {
                switch ($account->is_submit)
                {
                    case 1; // submit
                        if ($account->status == Account::STATUS_CHANGE_SUCCESS)
                        {
                            return Account::CHANGE_PASSWORD_SUCCESS;
                        } else {
                            return Account::SUBMITTED_CHANGE_PASSWORD;
                        }
                        break;
                    case 0: // not submit
                        return Account::NOT_SUBMITTED_CHANGE_PASSWORD;
                        break;
                }
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
