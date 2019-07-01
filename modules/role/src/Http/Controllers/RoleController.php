<?php

namespace Zent\Role\Http\Controllers;

use Zent\Role\Models\Role;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Module;
use View;
use DataTables;
use Zent\Role\Models\RoleUser;
use Illuminate\Support\Facades\DB;
use Zent\Permission\Models\Permission;
use Zent\Permission\Models\PermissionRole;
use Entrust;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('role');
        View::share('display_name', $display_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('role::backend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['name']   =   $data['display_name'];

        Role::create($data);

        return redirect()->route('role.index')->with('create_success', trans('global.create_success'));
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
        $role = Role::find($id);

        return view('role::backend.edit', compact('role', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Role::find($id)->update($request->all());

        Session::flash('update_success', trans('global.update_success'));

        return redirect()->route('role.index');
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
            RoleUser::where('role_id', $request->id)->delete();
            Role::find($request->id)->delete();

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
        return view('role::frontend.index');
    }
    
    /**
     * 
     */
    public static function getListRole()
    {
        $roles = Role::orderBy('id', 'desc')->get();

        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function ($role) {
                $txt = "";

                if (Entrust::can('role-permission-role'))
                {
                    $txt .= '<button data-id="'.$role->id.'" href="#" type="button" class="btn btn-success pd-0 wd-30 ht-20 btn-permission" data-tooltip="tooltip" data-placement="top" title="'.trans('global.permission').'"/><i class="fa fa-sliders" aria-hidden="true"></i></button>';
                }

                if (Entrust::can('role-edit'))
                {
                    $txt .= '<button data-id="'.$role->id.'" href="#" type="button" class="btn btn-warning pd-0 wd-30 ht-20 btn-edit" data-tooltip="tooltip" data-placement="top" title="'.trans('global.edit').'"/><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                }

                if (Entrust::can('role-delete'))
                {
                    $txt .= '<button data-id="'.$role->id.'" href="#" type="button" class="btn btn-danger pd-0 wd-30 ht-20 btn-delete" data-tooltip="tooltip" data-placement="top" title="'.trans('global.delete').'"/><i class="fa fa-trash" aria-hidden="true"></i></button>';
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
    public static function permissionRole($role_id)
    {
        return View('role::backend.permission_role', compact('role_id'));
    }
    
    /**
     * 
     */
    public static function getListPermissionRole(Request $request)
    {
        $permissions = Permission::orderBy('id', 'desc')->get();

        $permission_roles = PermissionRole::getArrayPermission($request->id);

        foreach ($permissions as $permission)
        {
            $permission->checked = in_array($permission->id, $permission_roles) ? "checked" : null;
        }

        return DataTables::of($permissions)
            ->addIndexColumn()
            ->addColumn('action', function ($permission){
                $txt = "";

                if (Entrust::can('role-permission-update'))
                {
                    $txt .= '<input type="checkbox" name="" data-id="'.$permission->id.'" class="btn-permission-role" '.$permission->checked.'>';
                }

                return $txt;
            })
            ->editColumn('created_at', function ($permission) {
                return date('H:i | d-m-Y', strtotime($permission->created_at));
            })
            ->editColumn('description', function ($permission) {
                return !is_null($permission->description) ? $permission->description : trans('global.not_updated');
            })
            ->toJson();
    }
    
    /**
     * 
     */
    public static function updatePermissionRole(Request $request)
    {
        DB::beginTransaction();

        try {

            $data = [
                'permission_id' => $request->permission_id,
                'role_id'       => $request->role_id
            ];

            $check = PermissionRole::checkPermissionRoleExist($data);

            if (!$check)
            {
                PermissionRole::create($data);
                $msg = trans('global.create_success');
            } else
            {
                PermissionRole::remove($data);
                $msg = trans('global.delete_success');
            }

            DB::commit();
            return response()->json([ 'err' => false, 'msg' =>  $msg]);

        } catch (\Exception $e) {
            return response()->json(['err'  =>  true, 'msg' =>  $e->getMessage()]);
        }
    }
}
