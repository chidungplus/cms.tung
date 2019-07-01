<?php

namespace Zent\Module\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use DataTables;
use App\Models\ModuleCategory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use View;
use Entrust;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('module');
        View::share('display_name', $display_name);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::select('modules.*', 'module_categories.name as module_category_name')
                    ->join('module_categories', 'modules.module_category_id', '=', 'module_categories.id')
                    ->orderBy('modules.id', 'desc')->get();

        foreach ($modules as $key => $module) {
            $module->status = ($module->status) == 1 ? trans('global.active') : trans('global.deactive');
        }

        return view('module::backend.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'name'  =>  $request->display_name,
            'display_name'  =>  $request->display_name
        ];

        Module::create($data);

        return redirect()->route('module.index')->with('create_success', trans('global.create_success'));
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
        $module = Module::find($id);
        $module_cates = ModuleCategory::all();

        return view('module::backend.edit', compact('module', 'id', 'module_cates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Module::find($id)->update($request->all());
        return redirect()->route('module.index')->with('update_success', trans('global.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $name = Module::find($request->id)->name;

        if (Module::checkModuleExistsByNameInFolder($name))
        {
            Storage::disk('module')->deleteDirectory($name);
        }

        Module::deleteModuleByName($name);
        Schema::dropIfExists($name . 's');

        return response()->json([ 'err' => false ]);
    }
    /**
     * Comment here.
     *
     * @return here
     * @author ThanhTung
     */
    public function home()
    {
        return view('module::frontend.index');
    }
    
    /**
     * 
     */
    public static function getList(Request $request)
    {
        $modules = Module::select('modules.*', 'module_categories.name as module_category_name')
                        ->join('module_categories', 'modules.module_category_id', '=', 'module_categories.id')
                        ->orderBy('modules.id', 'desc');

        return DataTables::of($modules)
                ->addIndexColumn()
                ->editColumn('note', function ($module) {
                    return !is_null($module->note) ? $module->note : trans('global.not_updated');
                })
                ->addColumn('action', function($module) {
                    $txt = "";

                    if (Entrust::can('module-edit'))
                    {
                        $txt .= '<button data-id="'.$module->id.'" href="#" type="button" class="btn btn-warning pd-0 wd-30 ht-20" data-tooltip="tooltip" data-placement="left" title="'.trans('global.edit').'"/><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                    }

                    if (Entrust::can('module-delete'))
                    {
                        $txt .= '<button data-id="'.$module->id.'" href="#" type="button" class="btn btn-danger pd-0 wd-30 ht-20" data-tooltip="tooltip" data-placement="right" title="'.trans('global.delete').'"/><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    }

                    return $txt;
                })
                ->editColumn('status', function ($module) {
                    return $module->status == 1 ? trans('global.active_icon') : trans('global.deactive_icon');
                })
                ->editColumn('created_at', function ($module) {
                    return date('H:i | d-m-Y', strtotime($module->created_at));
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
    }
}
