<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttachedFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class AttachedFileController extends Controller
{
    /**
     * Display a listing of the AttachedFile.
     *
     * @return Response
     */
    public function index()
    {
        $attachedFiles = AttachedFile::filter(Request::all(["search", ...AttachedFile::$searchIn]))->with('register:id,name');
        if (Request::has('only')) {
            return json_encode($attachedFiles->paginate(Request::input('per_page'),['id', 'name']));
        }
        return Inertia::render('Admin/attached_files/Index', [
            'filters' => Request::only(["search", ...AttachedFile::$searchIn]),
            'datas' => $attachedFiles
                ->paginate(Request::input('per_page'))
                ->withQueryString()
                ->through(fn ($row) => $row->only('id','register','register_id','path','type')),
            'host' => config('app.url'),
        ]);
    }

    /**
     * Show the form for creating a new AttachedFile.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Admin/attached_files/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created AttachedFile in storage.
     *
     * @return Response
     */
    public function store()
    {
        AttachedFile::create(Request::validate(AttachedFile::$rules));
        return Redirect::route('admin.attached_files.index')->with('success', 'AttachedFile created.');
    }

    /**
     * Show the form for editing the specified AttachedFile.
     *
     * @param AttachedFile $attachedFile
     *
     * @return Response
     */
    public function edit(AttachedFile $attachedFile)
    {
        return Inertia::render('Admin/attached_files/Edit', [
            'data' =>  $attachedFile,
            'host' => config('app.url'),
        ]);
    }

    /**
     * Update the specified AttachedFile in storage.
     *
     * @param AttachedFile $attachedFile
     *
     * @return Response
     */
    public function update(AttachedFile $attachedFile)
    {
        $attachedFile->update(Request::validate(AttachedFile::$rules));
        return Redirect::route('admin.attached_files.index')->with('success', 'AttachedFile updated.');
    }

    /**
     * Remove the specified AttachedFile from storage.
     *
     * @param AttachedFile $attachedFile
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(AttachedFile $attachedFile)
    {
        $attachedFile->delete();
        return Redirect::route('admin.attached_files.index')->with('success', 'AttachedFile deleted.');
    }
}
