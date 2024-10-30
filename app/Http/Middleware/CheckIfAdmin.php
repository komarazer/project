<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // เช็คว่าเป็นผู้ใช้ที่ล็อกอินหรือไม่
        if (backpack_auth()->guest()) {
            return $this->respondToUnauthorizedRequest($request);
        }

        // เช็คว่า admin_dashboard_access เป็น 1 หรือไม่
        $user = backpack_user();
        if ($user->role->admin_dashboard_access !== 1) {
            return $this->respondToUnauthorizedRequest($request);
        }

        return $next($request);
    }

    /**
     * ส่งคำตอบสำหรับการเข้าถึงที่ไม่ได้รับอนุญาต
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    private function respondToUnauthorizedRequest($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(trans('backpack::base.unauthorized'), 401);
        } else {
            return redirect()->guest(backpack_url('login'));
        }
    }
}