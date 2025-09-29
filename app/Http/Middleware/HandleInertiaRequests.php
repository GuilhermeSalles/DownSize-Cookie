<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'admin' => fn() => $request->user('admin')
                    ? [
                        'id' => $request->user('admin')->id,
                        'name' => $request->user('admin')->name,
                        'email' => $request->user('admin')->email,
                        'photo' => $request->user('admin')->profile_image,
                        'role' => $request->user('admin')->role,
                    ]
                    : null,
            ],
            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'status' => fn() => $request->session()->get('status'),
            ],
        ]);
    }
}
