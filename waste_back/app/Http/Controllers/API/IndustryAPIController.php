<?php

namespace App\Http\Controllers\API;


use App\Models\Industry;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class IndustryController
 * @package App\Http\Controllers\API
 */

class IndustryAPIController extends AppBaseController
{
    /**
     * Display a listing of the Industry.
     * GET|HEAD /industries
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index(Request $request)
    {
        $query = Industry::filter( $request->all(["search", ...Industry::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $industries = $query->get();

        return $industries->toJson();
    }

    /**
     * Store a newly created Industry in storage.
     * POST /industries
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store(Request $request)
    {
        $input = $request->validate(Industry::$rules);

        /** @var Industry $industry */
        $industry = Industry::create($input);

        return $industry->toJson();
    }

    /**
     * Display the specified Industry.
     * GET|HEAD /industries/{id}
     *
     * @param Industry $industries
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show($id)
    {
        /** @var Industry $industry */
        $industry = Industry::find($id);

        if (empty($industry)) {
            return $this->sendError('Industry not found');
        }

        return $industry->toJson();
    }

    /**
     * Update the specified Industry in storage.
     * PUT/PATCH /industries/{id}
     *
     * @param Industry $industries
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(Industry::$rules);
        /** @var Industry $industry */
        $industry = Industry::find($id);

        if (empty($industry)) {
            return $this->sendError('Industry not found');
        }

        $industry->fill($input);
        $industry->save();

        return $industry->toJson();
    }

    /**
     * Remove the specified Industry from storage.
     * DELETE /industries/{id}
     *
     * @param Industry $industries
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy($id)
    {
        /** @var Industry $industry */
        $industry = Industry::find($id);

        if (empty($industry)) {
            return $this->sendError('Industry not found');
        }

        $industry->delete();

        return $this->sendSuccess('Industry deleted successfully');
    }
}
