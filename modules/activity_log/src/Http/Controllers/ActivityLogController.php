<?php

namespace Zent\ActivityLog\Http\Controllers;

use Zent\ActivityLog\Models\ActivityLog;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use View;
use Zent\User\Models\User;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.user');

        $display_name = Module::getDisplayName('activity_log');
        View::share('display_name', $display_name);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('activityLog::backend.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activityLog::backend.create');
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
            ActivityLog::create($data);

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
        $activityLog = ActivityLog::find($id);

        return view('activityLog::backend.edit', compact('activityLog', 'id'));
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
            ActivityLog::find($data['activity_log_id'])->update($data);

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
            ActivityLog::find($request->id)->delete();

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
        return view('activityLog::frontend.index');
    }

    /**
     * DataTables get list activityLog
     */
    public static function getListActivityLog()
    {
        $activity_logs = ActivityLog::orderBy('id', 'desc')->get();

        return DataTables::of($activity_logs)
            ->addIndexColumn()
            ->editColumn('userId', function ($activity_log) {
                $user = User::find($activity_log->userId);
                return !is_null($user) ? $user->name : null;
            })
            ->editColumn('route', function ($activity_log) {
                return '<a href="'.$activity_log->route.'">'.$activity_log->route.'</a>';
            })
            ->editColumn('methodType', function ($activity) {
                $string  = "";

                if(strtoupper($activity->methodType)=='GET'){
                    $string = "<span class='dt-method' style='background-color: #659be0;'>".$activity->methodType."</span>";
                }elseif (strtoupper($activity->methodType)=='POST') {
                    $string = "<span class='dt-method' style='background-color: orange;'>".$activity->methodType."</span>";
                }elseif (strtoupper($activity->methodType)=='DELETE') {
                    $string = "<span class='dt-method' style='background-color: red;'>".$activity->methodType."</span>";
                }elseif (strtoupper($activity->methodType)=='PUT') {
                    $string = "<span class='dt-method' style='background-color: blue;'>".$activity->methodType."</span>";
                }elseif (strtoupper($activity->methodType)=='PATCH') {
                    $string = "<span class='dt-method' style='background-color: green;'>".$activity->methodType."</span>";
                }

                return $string;
            })
            ->editColumn('userAgent', function($activity){
                $userAgentDetails = self::details($activity->userAgent);

                $data = self::getUserAgent($userAgentDetails);

                return "<i class='fa ".$data['platformIcon']."'><span>".$userAgentDetails['platform']."</span></i><i class='fa ".$data['browserIcon']."'><span>".$userAgentDetails['browser']."</span></i><sup>".$userAgentDetails['version']."</sup>";
            })
            ->rawColumns(['methodType', 'route', 'userAgent'])
            ->toJson();
    }

    /**
     *
     */
    public static function getUserAgent($userAgentDetails){
        $platform       = $userAgentDetails['platform'];
        $browser        = $userAgentDetails['browser'];

        switch ($platform) {

            case 'Windows':
                $platformIcon = 'fa-windows';
                break;

            case 'iPad':
                $platformIcon = 'fa-';
                break;

            case 'iPhone':
                $platformIcon = 'fa-';
                break;

            case 'Macintosh':
                $platformIcon = 'fa-apple';
                break;

            case 'Android':
                $platformIcon = 'fa-android';
                break;

            case 'BlackBerry':
                $platformIcon = 'fa-';
                break;

            case 'Unix':
            case 'Linux':
                $platformIcon = 'fa-linux';
                break;

            default:
                $platformIcon = 'fa-';
                break;
        }

        switch ($browser) {

            case 'Chrome':
                $browserIcon  = 'fa-chrome';
                break;

            case 'Firefox':
                $browserIcon  = 'fa-';
                break;

            case 'Opera':
                $browserIcon  = 'fa-opera';
                break;

            case 'Safari':
                $browserIcon  = 'fa-safari';
                break;

            case 'Internet Explorer':
                $browserIcon  = 'fa-edge';
                break;

            default:
                $browserIcon  = 'fa-';
                break;
        }

        $data = [
            'platformIcon' => $platformIcon,
            'browserIcon' => $browserIcon,
        ];

        return $data;
    }

    /**
     * Get the user's agents details.
     *
     * @param $ua
     *
     * @return array
     */
    public static function details($ua)
    {
        $ua = is_null($ua) ? $_SERVER['HTTP_USER_AGENT'] : $ua;
        // Enumerate all common platforms, this is usually placed in braces (order is important! First come first serve..)
        $platforms = 'Windows|iPad|iPhone|Macintosh|Android|BlackBerry|Unix|Linux';
        // All browsers except MSIE/Trident and..
        // NOT for browsers that use this syntax: Version/0.xx Browsername
        $browsers = 'Firefox|Chrome|Opera';
        // Specifically for browsers that use this syntax: Version/0.xx Browername
        $browsers_v = 'Safari|Mobile'; // Mobile is mentioned in Android and BlackBerry UA's
        // Fill in your most common engines..
        $engines = 'Gecko|Trident|Webkit|Presto';
        // Regex the crap out of the user agent, making multiple selections and..
        $regex_pat = "/((Mozilla)\/[\d\.]+|(Opera)\/[\d\.]+)\s\(.*?((MSIE)\s([\d\.]+).*?(Windows)|({$platforms})).*?\s.*?({$engines})[\/\s]+[\d\.]+(\;\srv\:([\d\.]+)|.*?).*?(Version[\/\s]([\d\.]+)(.*?({$browsers_v})|$)|(({$browsers})[\/\s]+([\d\.]+))|$).*/i";
        // .. placing them in this order, delimited by |
        $replace_pat = '$7$8|$2$3|$9|${17}${15}$5$3|${18}${13}$6${11}';
        // Run the preg_replace .. and explode on |
        $ua_array = explode('|', preg_replace($regex_pat, $replace_pat, $ua, PREG_PATTERN_ORDER));
        if (count($ua_array) > 1) {
            $return['platform'] = $ua_array[0];  // Windows / iPad / MacOS / BlackBerry
            $return['type'] = $ua_array[1];  // Mozilla / Opera etc.
            $return['renderer'] = $ua_array[2];  // WebKit / Presto / Trident / Gecko etc.
            $return['browser'] = $ua_array[3];  // Chrome / Safari / MSIE / Firefox
            /*
               Not necessary but this will filter out Chromes ridiculously long version
               numbers 31.0.1234.122 becomes 31.0, while a "normal" 3 digit version number
               like 10.2.1 would stay 10.2.1, 11.0 stays 11.0. Non-match stays what it is.
            */
            if (preg_match("/^[\d]+\.[\d]+(?:\.[\d]{0,2}$)?/", $ua_array[4], $matches)) {
                $return['version'] = $matches[0];
            } else {
                $return['version'] = $ua_array[4];
            }
        } else {
            return false;
        }
        // Replace some browsernames e.g. MSIE -> Internet Explorer
        switch (strtolower($return['browser'])) {
            case 'msie':
            case 'trident':
                $return['browser'] = 'Internet Explorer';
                break;
            case '': // IE 11 is a steamy turd (thanks Microsoft...)
                if (strtolower($return['renderer']) == 'trident') {
                    $return['browser'] = 'Internet Explorer';
                }
                break;
        }
        switch (strtolower($return['platform'])) {
            case 'android':    // These browsers claim to be Safari but are BB Mobile
            case 'blackberry': // and Android Mobile
                if ($return['browser'] == 'Safari' || $return['browser'] == 'Mobile' || $return['browser'] == '') {
                    $return['browser'] = "{$return['platform']} mobile";
                }
                break;
        }
        return $return;
    }
}
