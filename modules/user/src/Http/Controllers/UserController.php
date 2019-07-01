<?php

namespace Zent\User\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Zent\User\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Module;
use View;
use Zent\Role\Models\RoleUser;
use Zent\Role\Models\Role;
use Entrust;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('user');
        View::share('display_name', $display_name);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();

        foreach ( $users as $user) {
            $user->status = $user->status == 1 ? trans('global.active') : trans('global.deactive');
        }

        return view('user::backend.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            parse_str($request->data, $data);
            $data['password'] = bcrypt('123456');

            if ($this->checkUniqueEmail($data['email']))
            {
                return response()->json([ 'err' => true, 'msg' => trans('global.email_exists'), 'type' => 'email']);
            }

            User::create($data);

            return response()->json([ 'err' => false, 'msg' =>  trans('global.create_success')]);
        } catch (\Exception $e) {
            return response()->json([ 'err' => true, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($id != Auth::guard('web')->id())
        {
            abort(404);
        }

        $user = User::find($id);

        return view('user::backend.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('user::backend.edit', compact('user', 'id'));
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
            parse_str($request->data, $data);
            User::find($data['user_id'])->update($data);

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
        User::find($request->id)->delete();

        $msg = trans('global.delete_success');

        return response()->json([ 'err' => false, 'msg' => $msg ]);
    }

    /**
     * Return view front end.
     *
     */
    public function home()
    {
        return view('user::frontend.index');
    }

    public static function getListUser(Request $request)
    {
        $users = User::orderBy('id', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->editColumn('email', function($user) {
                return '<a href="mailto:'.$user->email.'">'.$user->email.'</a>';
            })
            ->editColumn('birthday', function($user) {
                return !is_null($user->birthday) ? $user->birthday : trans('global.not_updated');
            })
            ->editColumn('gender', function($user) {
                switch ($user->gender)
                {
                    case 1:
                        return trans('global.male_icon');
                    case 0:
                        return trans('global.female_icon');
                    default:
                        return "???";
                }
            })
            ->editColumn('type', function($user) {
                switch ($user->type)
                {
                    case 1:
                        return '<span style="font-weight: bold">'.trans('global.admin').'</span>';
                    case 0:
                        return trans('global.user');
                    default:
                        return "";
                }
            })
            ->addColumn('action', function($user) {
                $txt = "";

                if (Entrust::can('user-role-view'))
                {
                    $txt .= '<button data-id="'.$user->id.'" href="#" type="button" class="btn btn-success pd-0 wd-30 ht-20 btn-role" data-tooltip="tooltip" data-placement="left" title="'.trans('global.role').'"/><i class="fa fa-handshake-o" aria-hidden="true"></i></i></button>';
                }

                if (Entrust::can('user-edit'))
                {
                    $txt .= '<button data-id="'.$user->id.'" href="#" type="button" class="btn btn-warning pd-0 wd-30 ht-20 btn-edit" data-tooltip="tooltip" data-placement="top" title="'.trans('global.edit').'"/><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                }

                if (Entrust::can('user-delete'))
                {
                    $txt .= '<button data-id="'.$user->id.'" href="#" type="button" class="btn btn-danger pd-0 wd-30 ht-20 btn-delete" data-tooltip="tooltip" data-placement="right" title="'.trans('global.delete').'"/><i class="fa fa-trash" aria-hidden="true"></i></button>';
                }

                return $txt;
            })
            ->editColumn('status', function ($user) {
                switch ($user->status)
                {
                    case 1:
                        return trans('global.active_icon');
                    case 0:
                        return trans("global.deactive_icon");
                    default:
                        return "???";
                }
            })
            ->rawColumns(['name','gender', 'type', 'status', 'action', 'email'])
            ->toJson();
    }

    public static function checkUniqueEmail($email)
    {
        $flag = User::where('email', $email)->withTrashed()->count();

        return $flag > 0 ? true : false;
    }
    
    /**
     * 
     */
    public static function roleUser($user_id)
    {
        $user = User::find($user_id);

        return View('user::backend.role_user', compact('user'));
    }
    
    /**
     * 
     */
    public static function getListRoleUser(Request $request)
    {
        $roles = Role::orderBy('id', 'desc')->get();

        $role_users = RoleUser::getArrayRole($request->user_id);

        foreach ($roles as $role)
        {
            $role->checked = in_array($role->id, $role_users) ? "checked" : null;
        }

        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function ($role){
                $txt = "";

                if (Entrust::can('user-role-update'))
                {
                    $txt .= '<input type="checkbox" name="" data-id="'.$role->id.'" class="btn-role-user" '.$role->checked.'>';
                }

                return $txt;
            })
            ->editColumn('created_at', function ($role) {
                return date('H:i | d-m-Y', strtotime($role->created_at));
            })
            ->editColumn('description', function ($role) {
                return !is_null($role->description) ? $role->description : trans('global.not_updated');
            })
            ->toJson();
    }
    
    /**
     * 
     */
    public static function updateRoleUser(Request $request)
    {
        DB::beginTransaction();

        try {

            $data = [
                'user_id'       => $request->user_id,
                'role_id'       => $request->role_id
            ];

            $check = RoleUser::checkRoleUserExist($data);

            if (!$check)
            {
                RoleUser::create($data);
                $msg = trans('global.create_success');
            } else
            {
                RoleUser::remove($data);
                $msg = trans('global.delete_success');
            }

            DB::commit();
            return response()->json([ 'err' => false, 'msg' =>  $msg]);

        } catch (\Exception $e) {
            return response()->json(['err'  =>  true, 'msg' =>  $e->getMessage()]);
        }
    }

    public function profile(Request $request)
    {
        DB::beginTransaction();

        try {
            parse_str($request->data, $data);

            if ($data['user_id'] != Auth::guard('web')->id())
            {
                return response()->json(['err' => true, 'msg' => trans('global.not_user')]);
            }

            User::find($data['user_id'])->update($data);
            $msg = trans('global.update_success');

            DB::commit();
            return response()->json(['err' => false, 'msg' => $msg]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['err' => true, 'msg' => $e->getMessage()]);
        }

    }

    public function setting($id)
    {
        if ($id != Auth::guard('web')->id())
        {
            abort(404);
        }

        $user = User::find($id);

        return view('user::backend.setting', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->user_id != User::userLogin())
            {
                return response()->json(['err' => true, 'msg' => 'Permission denied']);
            }

            parse_str($request->data, $data);

            $current_password = Auth::guard('web')->user()->password;

            if ( !Hash::check($data['current_password'], $current_password))
            {
                return response()->json(['err' => true, 'msg' => 'Mật khẩu hiện tại không đúng']);
            }

            if( $data['password'] != $data['password_confirmation'])
            {
                return response()->json(['err' => true, 'msg' => 'Mật khẩu xác nhận không đúng']);
            }

            $user = User::find($request->user_id);
            $user->update([
                'password'  =>  bcrypt($data['password'])
            ]);

            DB::commit();
            return response()->json(['err' => false, 'msg' => 'Đổi mật khẩu thành công !']);

        } catch (\Exception $e)
        {
            return response()->json(['err' => true, 'msg' => $e->getMessage()]);
        }



    }

}
