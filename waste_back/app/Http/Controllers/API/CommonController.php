<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AimagCity;
use App\Models\BagHoroo;
use App\Models\Place;
use App\Models\Reason;
use App\Models\Register;
use App\Models\Resolve;
use App\Models\SoumDistrict;
use App\Models\Status;
use Auth;
use Carbon\Carbon;
use DB;
use Request;
use Response;

class CommonController extends Controller
{
    /**
     * Display a listing of the Reason.
     *
     * @return Response
     */
    public function index()
    {
        $input = Request::validate([
            'places_date' => 'nullable|date',
            'reasons_date' => 'nullable|date',
            'statuses_date' => 'nullable|date',
            'aimag_cities_date' => 'nullable|date',
            'soum_districts_date' => 'nullable|date',
            'bag_horoos_date' => 'nullable|date',
            'resolves_date' => 'nullable|date',
        ]);

        $initDate = Carbon::createFromFormat('Y-m-d H:i:s', '2000-01-23 11:53:20');

        $places_date = $input['places_date'] ?? $initDate;
        $reasons_date = $input['reasons_date'] ?? $initDate;
        $statuses_date = $input['statuses_date'] ?? $initDate;
        $aimag_cities_date = $input['aimag_cities_date'] ?? $initDate;
        $soum_districts_date = $input['soum_districts_date'] ?? $initDate;
        $bag_horoos_date = $input['bag_horoos_date'] ?? $initDate;
        $resolves_date = $input['resolves_date'] ?? $initDate;
        $haha = DB::select(
            'SELECT 
                (select COUNT(*) FROM registers INNER JOIN reasons ON reasons.id = reason_id WHERE reasons.place_id = 2) total_mh,
                (select COUNT(*) FROM registers INNER JOIN reasons ON reasons.id = reason_id WHERE reasons.place_id = 1) total_za, 
                (SELECT (COUNT(*) / (SELECT COUNT(*) FROM registers INNER JOIN reasons ON reasons.id = reason_id WHERE reasons.place_id = 2)) total FROM registers INNER JOIN reasons ON reasons.id = reason_id WHERE status_id = 3 AND reasons.place_id = 2) AS mh, 
                (SELECT (COUNT(*) / (SELECT COUNT(*) FROM registers INNER JOIN reasons ON reasons.id = reason_id WHERE reasons.place_id = 1)) total FROM registers INNER JOIN reasons ON reasons.id = reason_id WHERE status_id = 3 AND reasons.place_id = 1) AS za'
        );
        return  [
            'places' => Place::where('updated_at', '>', $places_date)->orWhere('created_at', '>', $places_date)->count() ? Place::all() : [],
            'reasons' => Reason::where('updated_at', '>', $reasons_date)->orWhere('created_at', '>', $reasons_date)->count() ? Reason::all() : [],
            'statuses' => Status::where('updated_at', '>', $statuses_date)->orWhere('created_at', '>', $statuses_date)->count() ? Status::all() : [],
            'aimag_cities' => AimagCity::where('updated_at', '>', $aimag_cities_date)->orWhere('created_at', '>', $aimag_cities_date)->count() ? AimagCity::all() : [],
            'soum_districts' => SoumDistrict::where('updated_at', '>', $soum_districts_date)->orWhere('created_at', '>', $soum_districts_date)->count() ? SoumDistrict::all() : [],
            'bag_horoos' => BagHoroo::where('updated_at', '>', $bag_horoos_date)->orWhere('created_at', '>', $bag_horoos_date)->count() ? BagHoroo::all() : [],
            "statistic" => $haha,
            "resolves" => Resolve::where('updated_at', '>', $resolves_date)->orWhere('created_at', '>', $resolves_date)->count() ? Resolve::all() : [],
        ];
    }
}
