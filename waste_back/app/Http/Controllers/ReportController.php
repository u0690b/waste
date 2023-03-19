<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Document;
use Auth;
use Date;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class ReportController extends Controller
{
    /**
     * Display a listing of the Document.
     *
     * @return Response
     */
    public function index()
    {
        $input = Request::validate(['start_at' => 'nullable|date', 'end_at' => 'nullable|date', 'sh_type' => 'nullable|array']);
        $cols =   implode(',', $input['sh_type'] ?? ['reason_name']);
        $input['sh_type'] = $input['sh_type'] ?? ['reason_name'];
        $input['start_at'] = $input['start_at'] ?? Date::now()->startOfMonth()->toDateString();
        $input['end_at'] = $input['end_at'] ?? Date::now()->toDateString();
        $order = $input['sh_type'] ?? ['reason_name'];
        $order =   $input['sh_type'] ?? ['reason_name'];
        foreach ($order as $key => $value) {
            if (str_ends_with($value, 'name')) {
                $order[$key] = "substr($value, instr($value, '.') + 1)";
            }
        }

        $order =   implode(',', $order);
        $where = " WHERE 1=1 ";
        if ($input['start_at'] &&  $input['end_at'])
            $where .= "  AND   DATE(r.created_at) BETWEEN '" . $input['start_at'] . "' AND '" . $input['end_at'] . "' ";

        $user = Auth::user();
        if (!($user->roles == 'admin' || $user->roles == 'zaa')) {
            $where .= "  AND  r.soum_district_id = " . $user->soum_district_id . " ";
        }
        if ($user->roles == 'onb' || $user->roles == 'hd') {
            $where .= "  AND  r.bag_horoo_id = " . $user->bag_horoo_id . " ";
        }

        if ($user->roles == 'mha' || $user->roles == 'mhb') {
            $where .= "  AND  r.reason_id <= 3 ";
        }

        $status_infos = DB::select("select $cols,  count(*) niit
            from (
                select 
                    r.whois whois,
                    ac.name ac_name,
                    sd.name sd_name,
                    bh.name bh_name,
                    if(r.reason_id<=3,'МХ','АА') org,
                    res.name reason_name,
                    rsl.name resolve_name,
                    st.name status_name,
                    r_user.name reg_user,
                    c_user.name comf_user                   
                from registers r
                    inner JOIN aimag_cities ac on r.aimag_city_id = ac.id
                    inner JOIN soum_districts sd on r.soum_district_id = sd.id
                    inner JOIN bag_horoos bh on r.bag_horoo_id = bh.id
                    left JOIN resolves rsl on r.resolve_id = rsl.id
                    inner JOIN reasons res on r.reason_id = res.id
                    inner JOIN statuses st on r.status_id = st.id
                    inner JOIN users r_user on r.reg_user_id = r_user.id
                    left JOIN users c_user on r.comf_user_id = c_user.id
                        $where
                ) ss
                group by $cols
                ORDER BY $order");


        return Inertia::render('Admin/report/Index', [
            'filters' =>  $input,
            'datas' => $status_infos,
            'host' => config('app.url'),
        ]);
    }
}
