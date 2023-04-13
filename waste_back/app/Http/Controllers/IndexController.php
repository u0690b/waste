<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Services\FCMService;
use Auth;
use Date;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class IndexController extends Controller
{
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

    public function sendNotificationrToUser()
    {
        // get a user to get the fcm_token that already sent.               from mobile apps 
        // $user = User::findOrFail($id);

        return FCMService::send(
            // 'cQ2U5OIzTMqnvzXvFGdKXH:APA91bEQDPO-wKgTjDfme8kn8rHg4sbZNYqtF644aZQbl4--8sFHnpopp5p0KzFOgdIkuNePxL6vEfdsg3tWVEcgRsLQup60x9aBMn1y2f_X9xiXG898CXLjBDdCA74wmUzzl-Eq7xx8',
            'eqbd6FFjTlSqD4VsmkMOYV:APA91bG6ucMv6aLraf5EWdd8L2Kq6YCGkUnDsweK9AER_Xb55BJ9hD9cZfTveWe3ZyzXPxntLSTsAKLSBN8WGdqypX5AW4IBTM4iIPabpA8p4dI_rohp8HhvN-HPh36z7ToLJdePd1wx',
            [
                'title' => 'your title',
                'body' => 'your body',
            ],
            [
                'chat' => 'your body',
            ]
        );
    }
}
