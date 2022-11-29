<?php

namespace App\Http\Controllers\API;


use App\Models\Register;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

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
        $query = Register::filter($request->all(["search", ...Register::$searchIn]))->with('aimag_city:id,name')->with('bag_horoo:id,name')->with('reason:id,name')->with('soum_district:id,name')->with('status:id,name')->with('user:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $registers = $query->get();

        return $registers;
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

        /** @var Register $register */
        $register = Register::create($input);

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
