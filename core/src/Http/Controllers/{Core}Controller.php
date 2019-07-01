<?php

namespace Zent\{Core}\Http\Controllers;

use Zent\{Core}\Models\{Core};
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use View;

class {Core}Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('{core_snake_case}');
        View::share('display_name', $display_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('{core}::backend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('{core}::backend.create');
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
            {Core}::create($data);

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
        ${core} = {Core}::find($id);

        return view('{core}::backend.edit', compact('{core}', 'id'));
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
            {Core}::find($data['{core_snake_case}_id'])->update($data);

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
            {Core}::find($request->id)->delete();

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
        return view('{core}::frontend.index');
    }

    /**
     * DataTables get list {core}
     */
    public static function getList{Core}()
    {
        ${core_snake_case}s = {Core}::orderBy('id', 'desc')->get();

        return DataTables::of(${core_snake_case}s)
            ->addIndexColumn()
            ->addColumn('action', function (${core_snake_case}) {
                $txt = "";

    //                if ( Entrust::can(['// here']))
    //                {
                $txt .= '<button data-id="' . ${core_snake_case}->id . '" href="#" type="button" class="btn btn-warning pd-0 wd-30 ht-20 btn-edit" data-tooltip="tooltip" data-placement="top" title="' . trans('global.edit') . '"/><i class="fa fa-pencil" aria-hidden="true"></i></button>';
    //                }

    //                if ( Entrust::can(['// here']))
    //                {
                $txt .= '<button data-id="' . ${core_snake_case}->id . '" href="#" type="button" class="btn btn-danger pd-0 wd-30 ht-20 btn-delete" data-tooltip="tooltip" data-placement="top" title="' . trans('global.delete') . '"/><i class="fa fa-trash" aria-hidden="true"></i></button>';
    //                }

                return $txt;
            })
            ->editColumn('created_at', function (${core_snake_case}) {
                return date('H:i | d-m-Y', strtotime(${core_snake_case}->created_at));
            })
            ->editColumn('content', function (${core_snake_case}) {
                return !is_null(${core_snake_case}->content) ? ${core_snake_case}->content : trans('global.not_updated');
            })
            ->editColumn('status', function (${core_snake_case}) {
                return (${core_snake_case}->status == 1) ? trans('global.show') : trans('global.hide');
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
