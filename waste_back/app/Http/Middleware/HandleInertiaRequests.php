<?php

namespace App\Http\Middleware;

use App\Models\AttachedFile;
use App\Models\Register;
use App\Models\Reason;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy as ZiggyZiggy;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed[]
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'totalStat' => [
                'user' => User::count(),
                'register' => Register::count(),
                'file' => AttachedFile::count(),
                'reason' => Reason::count(),
            ],
            'notifiCount' =>  $request->user() ? $request->user()->notifications()->whereReadAt(null)->count() : null,
            'ziggy' => function () use ($request) {
                return array_merge((new ZiggyZiggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
