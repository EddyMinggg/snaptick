<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckHasMerchant
{
    public function handle(Request $request, Closure $next): Response
    {
        // 只攔截已登入的用戶
        if ($request->user()) {
            // 若用戶尚未建立商戶資料，導向 setup 頁面
            if (is_null($request->user()->merchant)) {
                return redirect()->route('merchant.setup');
            }
        }

        return $next($request);
    }
}
