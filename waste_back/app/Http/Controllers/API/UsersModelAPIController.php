<?php

namespace App\Http\Controllers\API;


use App\Models\UsersModel;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UsersModelController
 * @package App\Http\Controllers\API
 */

class UsersModelAPIController extends AppBaseController
{
    /**
     * Display a listing of the UsersModel.
     * GET|HEAD /usersModels
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = UsersModel::filter( $request->all(["search", ...UsersModel::$searchIn]))->with('aimag_city:id,name')->with('bag_horoo:id,name')->with('soum_district:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $usersModels = $query->get();

        return $usersModels->toJson();
    }

    /**
     * Store a newly created UsersModel in storage.
     * POST /usersModels
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(UsersModel::$rules);

        /** @var UsersModel $usersModel */
        $usersModel = UsersModel::create($input);

        return $usersModel->toJson();
    }

    /**
     * Display the specified UsersModel.
     * GET|HEAD /usersModels/{id}
     *
     * @param UsersModel $usersModels
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var UsersModel $usersModel */
        $usersModel = UsersModel::find($id);

        if (empty($usersModel)) {
            return $this->sendError('Users Model not found');
        }

        return $usersModel->toJson();
    }

    /**
     * Update the specified UsersModel in storage.
     * PUT/PATCH /usersModels/{id}
     *
     * @param UsersModel $usersModels
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(UsersModel::$rules);
        /** @var UsersModel $usersModel */
        $usersModel = UsersModel::find($id);

        if (empty($usersModel)) {
            return $this->sendError('Users Model not found');
        }

        $usersModel->fill($input);
        $usersModel->save();

        return $usersModel->toJson();
    }

    /**
     * Remove the specified UsersModel from storage.
     * DELETE /usersModels/{id}
     *
     * @param UsersModel $usersModels
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var UsersModel $usersModel */
        $usersModel = UsersModel::find($id);

        if (empty($usersModel)) {
            return $this->sendError('Users Model not found');
        }

        $usersModel->delete();

        return $this->sendSuccess('Users Model deleted successfully');
    }
}
