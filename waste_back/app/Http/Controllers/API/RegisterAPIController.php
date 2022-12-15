<?php

namespace App\Http\Controllers\API;


use App\Models\Register;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\AttachedFile;
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
        $query = Register::filter($request->all(["search", ...Register::$searchIn]))

            ->with('reg_user:id,name')
            ->with('attached_images:id,register_id,path')
            ->with('attached_video:id,register_id,path');


        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }



        return $query->orderByDesc('id')->cursorPaginate(null, ['*'], 'cursor', $request->input('next_cursor'));
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

        /** @var Register $register */
        $register = Register::create($input);
        $this->saveFiles($register, $input['images'], 'img');
        if (isset($input['video'])) {
            $this->saveFiles($register, [$input['video']], 'video');
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
