<?php

namespace App\Http\Controllers\API;


use App\Models\BagHoroo;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\JsonResponse;
use Log;
use Response;

/**
 * Class BagHorooController
 * @package App\Http\Controllers\API
 */

class BagHorooAPIController extends AppBaseController
{
    /**
     * Display a listing of the BagHoroo.
     * GET|HEAD /bagHoroos
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $input = $request->validate(['date' => 'nullable|date']);
        if (isset($input['date'])) {
            $count =   BagHoroo::where('updated_at', '>', $input['date'])->orWhere('created_at', '>', $input['date'])->count();
            if ($count <= 0) {
                return [];
            }
        }
        $query = BagHoroo::filter($request->all(["search", ...BagHoroo::$searchIn]));

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $bagHoroos = $query->get();
        $json = $bagHoroos->toJson(JSON_UNESCAPED_UNICODE);
        Log::info($json);
        return  $json;
    }

    /**
     * Store a newly created BagHoroo in storage.
     * POST /bagHoroos
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(BagHoroo::$rules);

        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::create($input);

        return $bagHoroo;
    }

    /**
     * Display the specified BagHoroo.
     * GET|HEAD /bagHoroos/{id}
     *
     * @param BagHoroo $bagHoroos
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::find($id);

        if (empty($bagHoroo)) {
            return $this->sendError('Bag Horoo not found');
        }

        return $bagHoroo;
    }

    /**
     * Update the specified BagHoroo in storage.
     * PUT/PATCH /bagHoroos/{id}
     *
     * @param BagHoroo $bagHoroos
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(BagHoroo::$rules);
        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::find($id);

        if (empty($bagHoroo)) {
            return $this->sendError('Bag Horoo not found');
        }

        $bagHoroo->fill($input);
        $bagHoroo->save();

        return $bagHoroo;
    }

    /**
     * Remove the specified BagHoroo from storage.
     * DELETE /bagHoroos/{id}
     *
     * @param BagHoroo $bagHoroos
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var BagHoroo $bagHoroo */
        $bagHoroo = BagHoroo::find($id);

        if (empty($bagHoroo)) {
            return $this->sendError('Bag Horoo not found');
        }

        $bagHoroo->delete();

        return $this->sendSuccess('Bag Horoo deleted successfully');
    }
}
