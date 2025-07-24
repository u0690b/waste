<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Register;

use App\Services\FirebaseMessagingService;
use Auth;
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
     * @return Response
     */
    public function index()
    {
        Request::validate([
            'start' => 'sometimes|date',
            'end' => 'sometimes|date',
        ]);
        if (Request::has('start')) {
            $start = Request::input('start');
        } else {
            $start = Date::now()->startOfMonth()->toDateString();
        }
        if (Request::has('end')) {
            $end = Request::input('end');
        } else {

            $end = Date::now()->toDateString();
        }

        $chartData = DB::select(
            "select r.name reason,p.position org,DATE(re.created_at) ognoo,st.name stat,CASE WHEN ac.name='Улаанбаатар' then sd.name else ac.name end region,count(*) niit "
                . " from registers re"
                .   " inner join reasons r on r.id = re.reason_id "
                .   " inner join  users p on p.id = re.reg_user_id "
                .   " inner join aimag_cities ac on ac.id = re.aimag_city_id"
                .   " inner join soum_districts sd on sd.id = re.soum_district_id"
                .   " INNER JOIN statuses st ON st.id = re.status_id"
                .   " where DATE(re.created_at) between ? and ? "
                . " group by DATE(re.created_at),r.name, p.position,st.name,CASE WHEN ac.name='Улаанбаатар' then sd.name else ac.name end",
            [$start, $end]
        );
        $etgeed = DB::select(
            " select  trim(name) name,count(*) niit from registers"
                .   " where whois='Хуулийн этгээд' and DATE(created_at) between ? and ? "
                . " group by trim(name)"
                . " order by niit desc "
                . " limit 10  ",
            [$start, $end]
        );
        $irgen = DB::select(
            " select  trim(name) name,count(*) niit from registers"
                .   " where whois='Иргэн' and DATE(created_at) between ? and ? "
                . " group by trim(name) "
                . " order by niit desc "
                . " limit 10  ",
            [$start, $end]
        );
        $view = 'DashboardGuest';
        if (Auth::user()) {
            $view = 'Dashboard';
        }
        return Inertia::render($view, [
            'filters' => [
                'start' => $start,
                'end' => $end,
            ],

            'chart' =>  $chartData,
            'etgeed' => $etgeed,
            'irgen' => $irgen,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Display a listing of the Register.
     *
     * @return Response
     */
    public function map()
    {
        $input = Request::all(Register::$searchIn);
        if (!$input['soum_district_id']) {
            $input['soum_district_id'] = Auth::user()->soum_district->toArray();
        }
        $registers = Register::filter($input);



        return Inertia::render('Admin/cluster_map/Index', [
            'filters' =>  $input,
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
     * @return Response
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
     * @return Response
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
            'data' =>  $register,
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
