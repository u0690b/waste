<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Models\User;
use App\Services\FCMService;
use Auth;
use Date;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Log;
use Response;
use Storage;

class RegisterController extends Controller
{
    /**
     * Display a listing of the Register.
     *
     * @return Response
     */
    public function index()
    {
        $input = Request::all(["search", ...Register::$searchIn]);
        $user = Auth::user();

        if (!$input['status_id']) {
            $input['status_id'] = 2;
        }

        if (!($user->roles == 'admin' || $user->roles == 'zaa')) {
            $input['soum_district_id'] = $user->soum_district_id;
        }
        if ($user->roles == 'onb' || $user->roles == 'hd') {
            $input['bag_horoo_id'] = $user->bag_horoo_id;
        }



        $registers = Register::filter($input)
            ->with('aimag_city:id,name')
            ->with('bag_horoo:id,name')
            ->with('comf_user:id,name')
            ->with('reason:id,name')
            ->with('reg_user:id,name')
            ->with('soum_district:id,name')
            ->with('status:id,name')
            ->with('attached_images:id,register_id,path')
            ->with('attached_video:id,register_id,path');


        if (!$input['status_id'] || $input['status_id'] == 2) {
            if ($user->roles == 'onb') {
                $registers = $registers->where('reg_user_id', $user->id);
            }
        } elseif ($input['status_id'] == 3) {
            if ($user->roles != 'mha') {
                $registers = $registers->where(function ($registers) use ($user) {
                    $registers->where('comf_user_id', '=', $user->id)
                        ->orWhere('reg_user_id', '=', $user->id);
                });
            }
        } elseif ($input['status_id'] == 4) {
            if ($user->roles != 'mha') {
                $registers = $registers->where(function ($registers) use ($user) {
                    $registers->where('comf_user_id', '=', $user->id)
                        ->orWhere('reg_user_id', '=', $user->id);
                });
            }
        }
        $registers = $registers->orderByDesc('updated_at')->orderByDesc('id');
        if (Request::has('only')) {
            return json_encode($registers->paginate(Request::input('per_page'), ['id', 'name']));
        }
        return Inertia::render('Admin/registers/Index', [
            'filters' =>   $input,
            'datas' => $registers
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new Register.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/registers/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Register in storage.
     *
     * @return Response
     */
    public function store()
    {
        Register::create(Request::validate(Register::$rules));

        return Redirect::route('admin.registers.index')->with('success', 'Register created.');
    }

    /**
     * Show the form for editing the specified Register.
     *
     * @param Register $register
     *
     * @return Response
     */
    public function edit(Register $register)
    {
        return Inertia::render('Admin/registers/Edit', [
            'data' =>  $register,
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
    public function allocation(Register $register)
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
        return Inertia::render('Admin/registers/Allocation', [
            'data' =>  $register,
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
    public function allocation_store(Register $register)
    {
        $input = Request::validate(['comf_user_id' => 'required']);
        $input['status_id'] = 3;
        $register->update($input);;
        $register->sendAllocationWasteNotify();

        return Redirect::route('admin.registers.index')->with('success', 'Register updated.');
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
            ->load('resolve:id,name')
            ->load('soum_district:id,name')
            ->load('status:id,name')
            ->load('attached_images:id,register_id,path')
            ->load('attached_video:id,register_id,path');
        return Inertia::render('Admin/registers/Show', [
            'data' =>  $register,
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
    public function show_resolve(Register $register)
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
        return Inertia::render('Admin/registers/Resolve', [
            'data' =>  $register,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Resolve the specified Register in storage.
     * PUT/PATCH /registers/{id}
     *
     * @param Register $registers
     *
     * @return Response
     */
    public function resolve(Register $register)
    {
        $input = Request::validate([
            'resolve_desc' => 'required|string|max:2000',
            'resolve_id' => 'required|integer',
            'image' => 'nullable|file',
        ]);


        try {
            DB::beginTransaction();

            $input['comf_user_id'] = Auth::user()->id;
            $input['status_id'] = 4;
            $input['resolved_at'] = Date::now();


            $register->fill($input);
            if ($input['image'] instanceof UploadedFile) {

                if ($file =  $input['image']->store('/public/uploads/hyanalt')) {
                    $register->resolve_image =  Storage::url($file);
                }
            }

            $register->save();
            // $register->update($input);

            DB::commit();
            $register->sendResolvedWasteNotify();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }



        return Redirect::route('admin.registers.index')->with('success', 'Register updated.');
    }
    /**
     * Update the specified Register in storage.
     *
     * @param Register $register
     *
     * @return Response
     */
    public function update(Register $register)
    {
        $register->update(Request::validate(Register::$rules));
        return Redirect::route('admin.registers.index')->with('success', 'Register updated.');
    }

    /**
     * Remove the specified Register from storage.
     *
     * @param Register $register
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(Register $register)
    {
        $register->delete();
        return Redirect::route('admin.registers.index')->with('success', 'Register deleted.');
    }
}
