<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Register;
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
            "select r.name reason,p.name org,DATE(re.created_at) ognoo,st.name stat,CASE WHEN ac.name='Улаанбаатар' then sd.name else ac.name end region,count(*) niit "
                . " from registers re"
                .   " inner join reasons r on r.id = re.reason_id "
                .   " inner join  places p on p.id = r.place_id"
                .   " inner join aimag_cities ac on ac.id = re.aimag_city_id"
                .   " inner join soum_districts sd on sd.id = re.soum_district_id"
                .   " INNER JOIN statuses st ON st.id = re.status_id"
                .   " where DATE(re.created_at) between ? and ? "
                . " group by DATE(re.created_at),r.name, p.name,st.name,CASE WHEN ac.name='Улаанбаатар' then sd.name else ac.name end",
            [$start, $end]

        );
        $etgeed = DB::select(
            " select  concat(trim(register),' ',trim(name)) name,count(*) niit from registers"
                .   " where DATE(created_at) between ? and ? "
                . " group by concat(trim(register),' ',trim(name)) "
                . " limit 10 ",
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
        return Inertia::render('Admin/cluster_map/Index', [
            'filters' => Request::only(["search", ...Register::$searchIn]),
            'datas' => $registers
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id', 'name', 'register', 'chiglel', 'aimag_city', 'aimag_city_id', 'soum_district', 'soum_district_id', 'bag_horoo', 'bag_horoo_id', 'address', 'description', 'reason', 'reason_id', 'zuil_zaalt', 'resolve_desc', 'long', 'lat', 'reg_user', 'reg_user_id', 'comf_user', 'comf_user_id', 'status', 'status_id')),
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
}
