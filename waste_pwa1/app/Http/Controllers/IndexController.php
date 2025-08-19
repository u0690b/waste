<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AttachedFile;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Register;
use Auth;
use Cache;
use Date;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use League\OAuth2\Client\Provider\GenericProvider;
use Storage;
use Illuminate\Http\Request;
class IndexController extends Controller
{
    public function index()
    {

        $stat = Register::groupBy('status_id')->selectRaw('status_id,count(*) as total')->where('reg_user_id', Auth::user()->id)->get();

        return Inertia::render('Dashboard', [
            'status' => $stat,
        ]);
    }


    public function create()
    {

        return Inertia::render('waste/Create');
    }

    public function draft()
    {
        return Inertia::render('waste/Draft');
    }

    public function send(Request $request)
    {
        $searchIn = Register::$searchIn;
        $input = $request->all(["search", ...$searchIn]);
        $user = Auth::user();

        if (!$input['status_id']) {
            $input['status_id'] = [2, 3];
        }
        $input['reg_user_id'] = $user->id;
        $registers = Register::filter($input)
            ->with('reg_user:id,name')
            ->with('comf_user:id,name')
            ->with('attached_images:id,register_id,path')
            ->with('attached_video:id,register_id,path');


        return Inertia::render('waste/Send', ["datas" => $registers->get()]);
    }
    public function solved(Request $request)
    {
        $searchIn = Register::$searchIn;
        $input = $request->all(["search", ...$searchIn]);
        $user = Auth::user();



        if (!$input['status_id']) {
            $input['status_id'] = [4];
        }
        $input['reg_user_id'] = $user->id;
        $registers = Register::filter($input)

            ->with('reg_user:id,name')
            ->with('comf_user:id,name')
            ->with('attached_images:id,register_id,path')
            ->with('attached_video:id,register_id,path');


        return Inertia::render('waste/Solved', ["datas" => $registers->get()]);
    }

    private function saveFiles(Register $model, $files, $type)
    {

        foreach ($files as $key => $value) {
            if ($value instanceof UploadedFile) {
                $hashName = $value->hashName();
                if ($file = $value->store('images', 'public')) {
                    $url = Storage::url($file);
                    AttachedFile::create([
                        'register_id' => $model->id,
                        'path' => $url,
                        'type' => $type,
                    ]);
                }
            }
        }
    }

    public function store(Request $request)
    {
        $input = $request->validate(Register::$rules);
        $input['reg_user_id'] = Auth::user()->id;
        $input['status_id'] = 2;
        try {
            DB::beginTransaction();

            /** @var Register $register */
            $register = Register::create($input);
            $this->saveFiles($register, $input['images'], 'img');
            if (isset($input['video'])) {
                $this->saveFiles($register, [$input['video']], 'video');
            }
            DB::commit();
            $register->sendCreatedWasteNotify();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return back()->with('success', 'success');
    }

    public function show(Register $register)
    {
        $register
            ->load('aimag_city:id,name')
            ->load('allocated:id,name')
            ->load('bag_horoo:id,name')
            ->load('comf_user:id,name')
            ->load('reason:id,name')
            ->load('reg_user:id,name')
            ->load('resolve:id,name')
            ->load('soum_district:id,name')
            ->load('status:id,name')
            ->load('attached_images:id,register_id,path');
        return Inertia::render('waste/Show', [
            'waste' => $register,
        ]);
    }

    public function notifications(Request $request)
    {
        $input = $request->all(["search", ...Notification::$searchIn]);
        $input['user_id'] = Auth::user()->id;

        Notification::whereReadAt(null)->update(['read_at' => Date::now()]);

        $notifications = Notification::filter($input)
            ->orderBy($request->input('orderBy') ?? 'id', $request->input('dir') ?? 'asc');

        if ($request->has('only')) {
            return json_encode($notifications->cursorPaginate($request->input('per_page'), ['id', 'name']));
        }

        return Inertia::render('waste/Notifications', [
            'filters' => $request->only(["search", ...Notification::$searchIn, 'orderBy', 'dir']),
            'datas' => $notifications
                ->paginate($request->input('per_page'))
                ->withQueryString(),
        ]);
    }
    public function offline()
    {

        return Inertia::render('waste/Offline');
    }

}
