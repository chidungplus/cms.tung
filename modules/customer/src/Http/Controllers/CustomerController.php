<?php

namespace Zent\Customer\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Zent\Customer\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Module;
use Illuminate\Support\Facades\View;
use Entrust;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('customer');
        View::share('display_name', $display_name);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();

        foreach ( $customers as $customer) {
            $customer->status = $customer->status == 1 ? trans('global.active') : trans('global.deactive');
        }

        return view('customer::backend.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer::backend.create');
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

            Customer::create($data);

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
        $customer = Customer::find($id);

        return view('customer::backend.edit', compact('customer', 'id'));
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
            Customer::find($data['customer_id'])->update($data);

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
            Customer::find($request->id)->delete();
            $msg = trans('global.delete_success');

            DB::commit();
            return response()->json(['err' => false, 'msg' => $msg]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['err' => true, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * Return view front end.
     *
     */
    public function home()
    {
        return view('customer::frontend.index');
    }

    public static function getListCustomer(Request $request)
    {
        $customers = Customer::orderBy('id', 'desc');

        return DataTables::of($customers)
            ->addIndexColumn()
            ->editColumn('email', function($customer) {
                return '<a href="mailto:'.$customer->email.'">'.$customer->email.'</a>';
            })
            ->editColumn('birthday', function($customer) {
                return !is_null($customer->birthday) ? $customer->birthday : trans('global.not_updated');
            })
            ->editColumn('gender', function($customer) {
                switch ($customer->gender)
                {
                    case 1:
                        return trans('global.male_icon');
                    case 0:
                        return trans('global.female_icon');
                    default:
                        return "???";
                }
            })
            ->editColumn('type', function($customer) {
                switch ($customer->type)
                {
                    case 1:
                        return '<span style="font-weight: bold">'.trans('global.customer_vip').'</span>';
                    case 0:
                        return trans('global.customer_normal');
                    default:
                        return "";
                }
            })
            ->addColumn('action', function($customer) {
                $txt = "";

                if (Entrust::can('customer-edit'))
                {
                    $txt .= '<button data-id="'.$customer->id.'" href="#" type="button" class="btn btn-warning pd-0 wd-30 ht-20 btn-edit" data-tooltip="tooltip" data-placement="top" title="'.trans('global.edit').'"/><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                }

                if (Entrust::can('customer-delete'))
                {
                    $txt .= '<button data-id="'.$customer->id.'" href="#" type="button" class="btn btn-danger pd-0 wd-30 ht-20 btn-delete" data-tooltip="tooltip" data-placement="top" title="'.trans('global.delete').'"/><i class="fa fa-trash" aria-hidden="true"></i></button>';
                }

                return $txt;
            })
            ->editColumn('status', function ($customer) {
                switch ($customer->status)
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
        $flag = Customer::where('email', $email)->withTrashed()->count();

        return $flag > 0 ? true : false;
    }

}
