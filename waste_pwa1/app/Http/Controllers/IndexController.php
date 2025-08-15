<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Register;
use Auth;
use Cache;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;
use League\OAuth2\Client\Provider\GenericProvider;
use Request;
use Storage;

class IndexController extends Controller
{
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

        return Inertia::render('Dashboard', [

            'chart' => $totalReportRegionStat,
            'totalReportStat' => $totalReportStat,
            'totalReportPrevMonthStat' => $totalReportPrevMonthStat[0],
            'totalClearStat' => $totalClearStat,
            'totalClearPrevMonthStat' => $totalClearPrevMonthStat,
            'totalUsers' => $totalUsers,
            'lastMonth' => $lastMonth,
        ]);
    }


    public function create()
    {
        return Inertia::render('waste/Create');
    }
}
