<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoModeGuard
{
    /**
     * Intercept and prevent destructive actions in public demo environments.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.demo_mode', env('DEMO_MODE', false))) {
            $isDelete = $request->isMethod('delete');
            $isCriticalSetting = $request->is('admin/setting*') 
                || $request->is('admin/user*')
                || $request->is('admin/aset/delete*')
                || $request->is('admin/album/delete*')
                || $request->is('admin/manifes/delete*')
                || $request->is('admin/vendor/delete*');

            if ($isDelete || $isCriticalSetting) {
                $message = '🔒 [Demo Mode]: Aksi modifikasi & hapus data dinonaktifkan pada website live demo publik demi menjaga integritas data.';

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 403);
                }

                return back()->with('error', $message);
            }
        }

        return $next($request);
    }
}
