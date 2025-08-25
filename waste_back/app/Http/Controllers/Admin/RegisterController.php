<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Register;
use Auth;
use Date;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;
use Storage;

class RegisterController extends Controller
{
    /**
     * Display a listing of the Register.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $input = Request::all(["search", "status_id"]);
        $user = Auth::user();

        if (!$input['status_id']) {
            $input['status_id'] = 2;
        }




        $registers = Register::filter($input)
            ->with('aimag_city:id,name')
            ->with('bag_horoo:id,name')
            ->with('comf_user:id,name')
            ->with('reason:id,name')
            ->with('reg_user:id,regnum,firstname,lastname')
            ->with('soum_district:id,name')
            ->with('status:id,name')
            ->with('attached_images:id,register_id,path')
            ->with('attached_video:id,register_id,path');

        if (!($user->roles == 'admin')) {
            $registers = $registers->where('aimag_city_id', $user->aimag_city_id);

            if ($user->aimag_city_id == 7) {
                $registers = $registers->where('soum_district_id', $user->soum_district_id);
            }

            if ($user->roles == 'da') {
                $registers = $registers->orWhere(function ($query) use ($user, $input) {
                    $query->where('comf_user_id', '=', $user->id)
                        ->where('status_id', '=', $input['status_id']);
                });
            } else {
                $registers = $registers->where('comf_user_id', '=', $user->id)
                    ->where('status_id', '=', $input['status_id']);

            }
        }


        if ($input['status_id'] != 2) { //ilgeesensees busad shiuljuulj irsen baibal hariyalal hargalzahgui huleen avah
            $registers = $registers->orWhere(function ($query) use ($user, $input) {
                $query->where('comf_user_id', '=', $user->id)
                    ->where('status_id', '=', $input['status_id']);
            });

        }

        $registers = $registers->orderByDesc('updated_at')->orderByDesc('id');
        if (Request::has('only')) {
            return json_encode($registers->paginate(Request::input('per_page'), ['id', 'name']));
        }
        return Inertia::render('Admin/registers/Index', [
            'filters' => $input,
            'datas' => $registers
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new Register.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/registers/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Register in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Register::$rules;
        $input = Request::validate($rule);
        $register = Register::create($input);
        return redirect(Request::header('back') ?? route('admin.registers.show', $register->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Register $register
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Register $register)
    {
        $register->load('aimag_city:id,name')->load('allocated:id,name')->load('bag_horoo:id,name')->load('comf_user:id,name')->load('reason:id,name')->load('reg_user:id,regnum,firstname,lastname')->load('resolve:id,name')->load('soum_district:id,name')->load('status:id,name');
        return Inertia::render('Admin/registers/Show', [
            'data' => $register,
        ]);
    }

    /**
     * Show the form for editing the specified Register.
     *
     * @param Register $register
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Register $register)
    {
        $register->load('aimag_city:id,name')->load('allocated:id,name')->load('bag_horoo:id,name')->load('comf_user:id,name')->load('reason:id,name')->load('reg_user:id,regnum,firstname,lastname')->load('resolve:id,name')->load('soum_district:id,name')->load('status:id,name');
        return Inertia::render('Admin/registers/Edit', [
            'data' => $register,
        ]);
    }

    /**
     * Update the specified Register in storage.
     *
     * @param Register $register
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Register $register)
    {
        $rule = Register::$rules;
        $input = Request::validate($rule);
        $register->update($input);

        return redirect(Request::header('back') ?? route('admin.registers.show', $register->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Register from storage.
     *
     * @param Register $register
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Register $register)
    {
        $register->delete();
        return redirect(Request::header('back') ?? route('admin.registers.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }



    public function allocation(Register $register)
    {
        $register
            ->load('aimag_city:id,name')
            ->load('bag_horoo:id,name')
            ->load('comf_user:id,name')
            ->load('reason:id,name')
            ->load('reg_user:id,regnum,firstname,lastname')
            ->load('allocated:id,name')

            ->load('soum_district:id,name')
            ->load('status:id,name')
            ->load('attached_images:id,register_id,path')
            ->load('attached_video:id,register_id,path');
        return Inertia::render('Admin/registers/Allocation', [
            'data' => $register,
            'host' => config('app.url'),
        ]);
    }
    public function allocation_store(Register $register)
    {
        $input = Request::validate(['comf_user_id' => 'required']);
        $input['status_id'] = 3;
        $input['allocate_by'] = Auth::user()->id;
        $input['reg_at'] = Date::now();

        $register->update($input);
        ;
        $register->sendAllocationWasteNotify();

        return Redirect::route('admin.registers.show', $register->id)->with('success', 'Register updated.');
    }

    public function show_resolve(Register $register)
    {
        $register
            ->load('aimag_city:id,name')
            ->load('bag_horoo:id,name')
            ->load('comf_user:id,name')
            ->load('reason:id,name')
            ->load('reg_user:id,regnum,firstname,lastname')
            ->load('soum_district:id,name')
            ->load('status:id,name')
            ->load('attached_images:id,register_id,path')
            ->load('attached_video:id,register_id,path');
        return Inertia::render('Admin/registers/Resolve', [
            'data' => $register,
            'host' => config('app.url'),
        ]);
    }


    public function resolve(Register $register)
    {
        $input = Request::validate([
            'resolve_desc' => 'required|string|max:2000',
            'resolve_id' => 'required|integer',
            'image' => 'nullable|file',
            "comf_user_name" => "required|string",
        ]);


        try {
            DB::beginTransaction();

            $input['comf_user_id'] = Auth::user()->id;
            $input['status_id'] = 4;
            $input['resolved_at'] = Date::now();


            $register->fill($input);
            if ($input['image'] instanceof UploadedFile) {

                if ($file = $input['image']->store('/public/uploads/hyanalt')) {
                    $register->resolve_image = Storage::url($file);
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


        return Redirect::route('admin.registers.show', $register->id)->with('success', 'Register updated.');
    }
}
