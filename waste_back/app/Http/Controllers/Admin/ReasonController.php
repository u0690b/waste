<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Response;

class ReasonController extends Controller
{
    /**
     * Display a listing of the Reason.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function index()
    {
        $reasons = Reason::filter(Request::all(["search", ...Reason::$searchIn]))->with('place:id,name')
            ->orderBy(Request::input('orderBy') ?? 'id', Request::input('dir') ?? 'asc');
        
        if (Request::has('only')) {
            return json_encode($reasons->cursorPaginate(Request::input('per_page'),['id', 'name']));
        }

        return Inertia::render('Admin/reasons/Index', [
            'filters' => Request::only(["search", ...Reason::$searchIn, 'orderBy', 'dir']),
            'datas' => $reasons
                ->paginate(Request::input('per_page'))
                ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new Reason.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function create()
    {
        return Inertia::render('Admin/reasons/Create', ['host' => config('app.url')]);
    }

    /**
     * Store a newly created Reason in storage.
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function store()
    {
        $rule = Reason::$rules;
        $input =  Request::validate($rule);
        $reason = Reason::create($input);
        return redirect(Request::header('back') ?? route('admin.reasons.show', $reason->getKey()))->with('success', 'Амжилттай үүсгэлээ.');
    }

    /**
     * Show the form for editing the specified UserModel.
     *
     * @param Reason $reason
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function show(Reason $reason)
    {
        $reason->load('place:id,name');
        return Inertia::render('Admin/reasons/Show', [
            'data' =>  $reason,
        ]);
    }

    /**
     * Show the form for editing the specified Reason.
     *
     * @param Reason $reason
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function edit(Reason $reason)
    {
        $reason->load('place:id,name');
        return Inertia::render('Admin/reasons/Edit', [
            'data' =>  $reason,
        ]);
    }

    /**
     * Update the specified Reason in storage.
     *
     * @param Reason $reason
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function update(Reason $reason)
    {
        $rule = Reason::$rules;
        $input =  Request::validate($rule);
        $reason->update($input);
        
        return redirect(Request::header('back') ?? route('admin.reasons.show', $reason->getKey()))->with('success', 'Ажилттай хадгаллаа.');
    }

    /**
     * Remove the specified Reason from storage.
     *
     * @param Reason $reason
     *
     * @throws \Exception
     *
     * @return \Inertia\Response|Response|string|bool
     */
    public function destroy(Reason $reason)
    {
        $reason->delete();
        return redirect(Request::header('back') ?? route('admin.reasons.index'))->with('success', 'Мэдээлэл устгагдлаа.');
    }
}
