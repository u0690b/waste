<?php

namespace App\Http\Controllers\API;


use App\Models\AttachedFile;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AttachedFileController
 * @package App\Http\Controllers\API
 */

class AttachedFileAPIController extends AppBaseController
{

    public function index(Request $request)
    {
        $query = AttachedFile::filter( $request->all(["search", ...AttachedFile::$searchIn]))->with('register:id,name');

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $attachedFiles = $query->get();

        return $attachedFiles->toJson();
    }

    /**
     * Store a newly created AttachedFile in storage.
     * POST /attachedFiles
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->validate(AttachedFile::$rules);

        /** @var AttachedFile $attachedFile */
        $attachedFile = AttachedFile::create($input);

        return $attachedFile->toJson();
    }

    /**
     * Display the specified AttachedFile.
     * GET|HEAD /attachedFiles/{id}
     *
     * @param AttachedFile $attachedFiles
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var AttachedFile $attachedFile */
        $attachedFile = AttachedFile::find($id);

        if (empty($attachedFile)) {
            return $this->sendError('Attached File not found');
        }

        return $attachedFile->toJson();
    }

    /**
     * Update the specified AttachedFile in storage.
     * PUT/PATCH /attachedFiles/{id}
     *
     * @param AttachedFile $attachedFiles
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $input = $request->validate(AttachedFile::$rules);
        /** @var AttachedFile $attachedFile */
        $attachedFile = AttachedFile::find($id);

        if (empty($attachedFile)) {
            return $this->sendError('Attached File not found');
        }

        $attachedFile->fill($input);
        $attachedFile->save();

        return $attachedFile->toJson();
    }

    /**
     * Remove the specified AttachedFile from storage.
     * DELETE /attachedFiles/{id}
     *
     * @param AttachedFile $attachedFiles
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var AttachedFile $attachedFile */
        $attachedFile = AttachedFile::find($id);

        if (empty($attachedFile)) {
            return $this->sendError('Attached File not found');
        }

        $attachedFile->delete();

        return $this->sendSuccess('Attached File deleted successfully');
    }
}
