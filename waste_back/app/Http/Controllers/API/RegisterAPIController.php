<?php

namespace App\Http\Controllers\API;


use App\Models\Register;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\AttachedFile;
use App\Models\User;
use App\Services\FCMService;
use Auth;
use Date;
use DB;
use Illuminate\Http\UploadedFile;
use Response;
use Storage;

/**
 * Class RegisterController
 * @package App\Http\Controllers\API
 */

class RegisterAPIController extends AppBaseController
{
    /**
     * Display a listing of the Register.
     * GET|HEAD /registers
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->only(["search", ...Register::$searchIn]);
        $user = Auth::user();


        if (!($user->roles == 'admin' || $user->roles == 'zaa')) {
            $input['soum_district_id'] = $user->soum_district_id;
        }
        if ($user->roles == 'onb' || $user->roles == 'hd') {
            $input['bag_horoo_id'] = $user->bag_horoo_id;
        }

        if (!$input['status_id']) {
            $input['status_id'] = 2;
        }
        $query = Register::filter($input)

            ->with('reg_user:id,name')
            ->with('comf_user:id,name')
            ->with('attached_images:id,register_id,path')
            ->with('attached_video:id,register_id,path');

        if (!$input['status_id'] || $input['status_id'] == 2) {
            if ($user->roles == 'onb') {
                $query = $query->where('reg_user_id', $user->id);
            }
        } elseif ($input['status_id'] == 3) {
            if ($user->roles != 'mha') {
                $query = $query->where('reg_user_id', $user->id);
                $query = $query->orWhere(function ($query) use ($user) {

                    $query->where('status_id', '=', 3)
                        ->Where('comf_user_id', '=', $user->id);
                });
            }
        } elseif ($input['status_id'] == 4) {
            if ($user->roles != 'mha') {
                $query = $query->where(function ($query) use ($user) {
                    $query->where('comf_user_id', '=', $user->id)
                        ->orWhere('reg_user_id', '=', $user->id);
                });
            }
        }

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $total = $query->toBase()->getCountForPagination();
        $pagination = $query->orderByDesc('updated_at')->orderByDesc('id')->cursorPaginate(null, ['*'], 'cursor', $request->input('next_cursor'))->toArray();
        $pagination['total'] = $total;
        return $pagination;
    }

    private function saveFiles(Register $model, $files, $type)
    {

        foreach ($files as $key => $value) {
            if ($value instanceof UploadedFile) {
                $hashName = $value->hashName();
                if ($file =  $value->storeAs('/public/uploads/hyanalt', $hashName, [])) {
                    $url =  Storage::url($file);
                    AttachedFile::create([
                        'register_id' => $model->id,
                        'path' =>  $url,
                        'type' => $type,
                    ]);
                }
            }
        }
    }

    /**
     * Store a newly created Register in storage.
     * POST /registers
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(Register::$rules);
        $input['reg_user_id'] = $request->user()->id;
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

        return $register->toJson();
    }

    /**
     * Display the specified Register.
     * GET|HEAD /registers/{id}
     *
     * @param Register $registers
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Register $register */
        $register = Register::find($id);
        $register->load('reg_user:id,name');
        $register->load('comf_user:id,name');
        $register->load('attached_images:id,register_id,path');
        $register->load('attached_video:id,register_id,path');;
        if (empty($register)) {
            return $this->sendError('Register not found');
        }

        return $register->toJson();
    }

    /**
     * Update the specified Register in storage.
     * PUT/PATCH /registers/{id}
     *
     * @param Register $registers
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Register::$rules);
        /** @var Register $register */
        $register = Register::find($id);

        if (empty($register)) {
            return $this->sendError('Register not found');
        }

        $register->fill($input);
        $register->save();

        return $register->toJson();
    }

    /**
     * Resolve the specified Register in storage.
     * PUT/PATCH /registers/{id}
     *
     * @param Register $registers
     *
     * @return Response
     */
    public function resolve($id, Request $request)
    {
        $input = $request->validate([
            'resolve_desc' => 'nullable|string|max:2000',
            'resolve_id' => 'nullable|integer',
            'image' => 'nullable|file',
        ]);
        /** @var Register $register */
        $register = Register::find($id);

        if (empty($register)) {
            return $this->sendError('Register not found');
        }

        try {
            DB::beginTransaction();

            /** @var Register $register */
            $input['comf_user_id'] = $request->user()->id;
            $input['status_id'] = 4;
            $input['resolved_at'] = Date::now();

            $register->fill($input);
            if ($request->image instanceof UploadedFile) {

                if ($file =  $input['image']->store('/public/uploads/hyanalt')) {
                    $register->resolve_image =  Storage::url($file);
                }
            }

            $register->save();


            DB::commit();
            $register->sendResolvedWasteNotify();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }




        return $register->toJson();
    }
    /**
     * Show the form for editing the specified Register.
     *
     * @param Register $register
     *
     * @return Response
     */
    public function allocation_store($id, Request $request)
    {
        $input = $request->validate(['comf_user_id' => 'required']);
        $input['status_id'] = 3;
        $input['allocate_by'] = Auth::user()->id;
        /** @var Register $register */
        $register = Register::find($id);
        $register->update($input);
        $register->sendAllocationWasteNotify($request->note);

        return $register->toJson();
    }
    /**
     * Remove the specified Register from storage.
     * DELETE /registers/{id}
     *
     * @param Register $registers
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Register $register */
        $register = Register::find($id);

        if (empty($register)) {
            return $this->sendError('Register not found');
        }

        $register->delete();

        return $this->sendSuccess('Register deleted successfully');
    }
}
