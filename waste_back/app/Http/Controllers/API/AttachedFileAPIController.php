<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAttachedFileAPIRequest;
use App\Http\Requests\API\UpdateAttachedFileAPIRequest;
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
    /**
     * Display a listing of the AttachedFile.
     * GET|HEAD /attachedFiles
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $query = AttachedFile::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $attachedFiles = $query->get();

        return $this->sendResponse($attachedFiles->toArray(), 'Attached Files retrieved successfully');
    }

    /**
     * Store a newly created AttachedFile in storage.
     * POST /attachedFiles
     *
     * @return Response
     */
    public function store(CreateAttachedFileAPIRequest $request)
    {
        $input = $request->all();

        /** @var AttachedFile $attachedFile */
        $attachedFile = AttachedFile::create($input);

        return $this->sendResponse($attachedFile->toArray(), 'Attached File saved successfully');
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

        return $this->sendResponse($attachedFile->toArray(), 'Attached File retrieved successfully');
    }

    /**
     * Update the specified AttachedFile in storage.
     * PUT/PATCH /attachedFiles/{id}
     *
     * @param AttachedFile $attachedFiles
     *
     * @return Response
     */
    public function update($id, UpdateAttachedFileAPIRequest $request)
    {
        /** @var AttachedFile $attachedFile */
        $attachedFile = AttachedFile::find($id);

        if (empty($attachedFile)) {
            return $this->sendError('Attached File not found');
        }

        $attachedFile->fill($request->all());
        $attachedFile->save();

        return $this->sendResponse($attachedFile->toArray(), 'AttachedFile updated successfully');
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
