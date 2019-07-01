<?php

namespace Zent\Permission\Http\Controllers;

use Yajra\DataTables\DataTables;
use Zent\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use DataTable;
use App\Models\Module;
use View;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('permission');
        View::share('display_name', $display_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permission::backend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permission::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Permission::create($request->all());

        Session::flash('create_success', trans('global.create_success'));

        return redirect()->route('permission.index');
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
        $permission = Permission::find($id);

        return view('permission::backend.edit', compact('permission', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Permission::find($id)->update($request->all());

        Session::flash('update_success', trans('global.update_success'));

        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Permission::find($request->id)->delete();

        Session::flash('delete_success', trans('global.delete_success'));

        return response()->json([ 'err' => false ]);
    }

    /**
     * Return view front end.
     *
     */
    public function home()
    {
        return view('permission::frontend.index');
    }

    /**
     *
     */
    public static function getListPermission(Request $request)
    {
        $permissions = Permission::orderBy('id', 'desc')->get();

        return DataTables::of($permissions)
            ->addIndexColumn()
            ->editColumn('created_at', function ($role) {
                return date('H:i | d-m-Y', strtotime($role->created_at));
            })
            ->toJson();
    }
}
