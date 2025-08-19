<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Register;

use App\Services\FirebaseMessagingService;
use Auth;
use Cache;
use Date;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndexController extends Controller
{
    protected $messagingService;

    public function __construct(FirebaseMessagingService $messagingService)
    {
        $this->messagingService = $messagingService;
    }

    /**
     * Display a listing of the Register.
     *
     * @return  \Inertia\Response
     */
    public function index()
    {

        $totalReportStat = DB::scalar(
            "SELECT COUNT(*) AS count FROM registers",
        );

        $totalReportRegionStat = $value = Cache::remember('totalReportRegionStat', 43200, function () {
            return DB::select(
                "  select st.name stat,CASE WHEN ac.name='Улаанбаатар' then concat(sd.name,' дүүрэг') else  concat(ac.name,' аймаг') end region,count(*) niit
                    from registers re
                    inner join reasons r on r.id = re.reason_id
                    inner join  users p on p.id = re.reg_user_id
                    inner join aimag_cities ac on ac.id = re.aimag_city_id
                    inner join soum_districts sd on sd.id = re.soum_district_id
                    INNER JOIN statuses st ON st.id = re.status_id
                    group by st.name,CASE WHEN ac.name='Улаанбаатар' then concat(sd.name,' дүүрэг') else concat(ac.name,' аймаг') end
                    "
            );
        });

        $totalReportPrevMonthStat = $value = Cache::remember('totalReportPrevMonthStat', 43200, function () {
            return DB::select(
                "SELECT
                    current.count AS current_month,
                    previous.count AS previous_month,
                    ROUND((current.count - previous.count) / previous.count * 100, 2) AS percentage_change
                FROM
                    (SELECT COUNT(*) AS count FROM registers
                    WHERE created_at >= DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01')) AS current,
                    (SELECT COUNT(*) AS count FROM registers
                    WHERE created_at >= DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH), '%Y-%m-01')
                    AND created_at < DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01')) AS previous;
                    "
            );
        });
        $totalClearStat = DB::scalar(
            "SELECT COUNT(*) AS count FROM registers where status_id = 4",
        );

        $totalClearPrevMonthStat = Cache::remember('totalClearPrevMonthStat', 43200, function () {
            return DB::scalar(
                "SELECT COUNT(*) AS count FROM registers where status_id = 4 and created_at >= DATE_FORMAT(CURRENT_DATE(), '%Y-%m-01')"
            );
        });
        $totalUsers = DB::scalar(
            " SELECT COUNT(*) AS count FROM users  "

        );
        $lastMonth = Cache::remember('lastMonth', 43200, function () {
            return DB::select(
                "SELECT DATE_FORMAT(created_at, '%Y-%m') AS ymonth, DATE_FORMAT(created_at, '%m') AS month, count(*) count from registers
                        where created_at >= DATE_FORMAT(DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH), '%Y-%m-01')
                        group by DATE_FORMAT(created_at, '%Y-%m'),DATE_FORMAT(created_at, '%m')
                        order by ymonth ; "
            );
        });

        $view = 'DashboardGuest';
        if (Auth::user()) {
            $view = 'Dashboard';
        }
        return Inertia::render($view, [
            'filters' => [],
            'chart' => $totalReportRegionStat,
            'totalReportStat' => $totalReportStat,
            'totalReportPrevMonthStat' => $totalReportPrevMonthStat[0],
            'totalClearStat' => $totalClearStat,
            'totalClearPrevMonthStat' => $totalClearPrevMonthStat,
            'totalUsers' => $totalUsers,
            'lastMonth' => $lastMonth,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Display a listing of the Register.
     *
     * @return  \Inertia\Response
     */
    public function map()
    {
        $input = Request::all(Register::$searchIn);
        if (!$input['aimag_city_id']) {
            $input['aimag_city_id'] = Auth::user()->aimag_city->toArray();
        } else if ($input['aimag_city_id'] == 7) {
            $input['soum_district_id'] = Auth::user()->soum_district->toArray();
        }

        $registers = Register::filter($input);



        return Inertia::render('Admin/cluster_map/Index', [
            'filters' => $input,
            'datas' => $registers->get([
                'long',
                'lat',
                'name',
                'status_id',
                'id',
            ]),
            'host' => config('app.url'),
        ]);
    }


    /**
     * Display a listing of the Register.
     *
     * @return \Inertia\Response|Response|bool|string
     */
    public function register()
    {
        $registers = Register::filter(Request::all(["search", ...Register::$searchIn]))
            ->with('aimag_city:id,name')
            ->with('bag_horoo:id,name')
            ->with('comf_user:id,name')
            ->with('reason:id,name')
            ->with('reg_user:id,name')
            ->with('soum_district:id,name')
            ->with('status:id,name')
            ->with('attached_images:id,register_id,path')
            ->with('attached_video:id,register_id,path');
        if (Request::has('only')) {
            return json_encode($registers->paginate(Request::input('per_page'), ['id', 'name']));
        }
        return Inertia::render('Register', [
            'filters' => Request::only(["search", ...Register::$searchIn]),
            'datas' => $registers
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
            'host' => config('app.url'),
        ]);
    }
    /**
     * Show the form for editing the specified Register.
     *
     * @param Register $register
     *
     * @return \Inertia\Response
     */
    public function show(Register $register)
    {
        $register
            ->load('aimag_city:id,name')
            ->load('bag_horoo:id,name')
            ->load('comf_user:id,name')
            ->load('reason:id,name')
            ->load('reg_user:id,name')
            ->load('soum_district:id,name')
            ->load('status:id,name')
            ->load('attached_images:id,register_id,path')
            ->load('attached_video:id,register_id,path');
        return Inertia::render('RegisterShow', [
            'data' => $register,
            'host' => config('app.url'),
        ]);
    }

    public function storage($filename)
    {
        $path = 'public/' . $filename;

        if (!Storage::exists($path)) {
            abort(404, 'File not found.');
        }

        $fullPath = Storage::path($path);

        $mime = Storage::mimeType($path);
        $size = filesize($fullPath);

        $start = 0;
        $end = $size - 1;

        if ($range = Request::header('Range')) {
            preg_match('/bytes=(\d+)-(\d*)/', $range, $matches);
            $start = intval($matches[1]);
            if (!empty($matches[2])) {
                $end = intval($matches[2]);
            }
        } else {
            $file = Storage::get($path);
            return response($file, 200)
                ->header('Content-Type', $mime);
        }

        $length = $end - $start + 1;
        $headers = [
            'Content-Type' => $mime,
            'Content-Length' => $length,
            'Content-Range' => "bytes $start-$end/$size",
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=86400',
        ];

        $response = new StreamedResponse(function () use ($fullPath, $start, $length) {
            $handle = fopen($fullPath, 'rb');
            fseek($handle, $start);
            echo fread($handle, $length);
            fclose($handle);
        }, 206, $headers);

        return $response;
    }

    public function sendNotificationrToUser($token)
    {
        $deviceToken = $token ?? 'clQ0Ey4SS7HK_KAq1w1ANY:APA91bFxm6ybOPm1uTNIcLKcmX6lz-nrhkHw27BQ4I2UqTnkSdtnVAs5APJtNZUSbpXqYh3bkdiMRdaW-S__cXA49mQK4vV1p7YJc_A1eZUPZeQ-0CjtOqk';
        $title = 'Hello from Laravel!';
        $body = 'This is a test push notification.';
        $customData = ['id' => '101', 'type' => 'register']; // Optional data

        $result = $this->messagingService->sendNotificationToDevice($deviceToken, $title, $body, $customData);

        if ($result && $result['success']) {
            return response()->json(['message' => 'Notification sent successfully!', 'messageId' => $result['messageId']]);
        } else {
            return response()->json(['error' => 'Failed to send notification', 'details' => $result['error'] ?? 'Unknown error'], 500);
        }
    }
}
