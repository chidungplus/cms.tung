<?php

namespace Zent\SystemLog\Http\Controllers;

use Zent\SystemLog\Models\SystemLog;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use View;

class SystemLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('system_log');
        View::share('display_name', $display_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('systemLog::backend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('systemLog::backend.create');
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
            SystemLog::create($data);

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
        $systemLog = SystemLog::find($id);

        return view('systemLog::backend.edit', compact('systemLog', 'id'));
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
            SystemLog::find($data['system_log_id'])->update($data);

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
            SystemLog::find($request->id)->delete();

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
        return view('systemLog::frontend.index');
    }

    /**
     * DataTables get list systemLog
     */
    public static function getListSystemLog()
{
    $system_logs = SystemLog::orderBy('id', 'desc')->get();

    return DataTables::of($system_logs)
        ->addIndexColumn()
        ->addColumn('action', function ($system_log) {
            $txt = "";

//                if ( Entrust::can(['// here']))
//                {
            $txt .= '<button data-id="' . $system_log->id . '" href="#" type="button" class="btn btn-warning pd-0 wd-30 ht-20 btn-edit" data-tooltip="tooltip" data-placement="top" title="' . trans('global.edit') . '"/><i class="fa fa-pencil" aria-hidden="true"></i></button>';
//                }

//                if ( Entrust::can(['// here']))
//                {
            $txt .= '<button data-id="' . $system_log->id . '" href="#" type="button" class="btn btn-danger pd-0 wd-30 ht-20 btn-delete" data-tooltip="tooltip" data-placement="top" title="' . trans('global.delete') . '"/><i class="fa fa-trash" aria-hidden="true"></i></button>';
//                }

            return $txt;
        })
        ->editColumn('created_at', function ($system_log) {
            return date('H:i | d-m-Y', strtotime($system_log->created_at));
        })
        ->editColumn('content', function ($system_log) {
            return !is_null($system_log->content) ? $system_log->content : trans('global.not_updated');
        })
        ->editColumn('status', function ($system_log) {
            return ($system_log->status == 1) ? trans('global.show') : trans('global.hide');
        })
        ->rawColumns(['action'])
        ->toJson();
}
}
