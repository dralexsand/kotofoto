<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuthKeyMiddleware
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return array|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!isset($request->key)) {
            return response()->json([
                'success' => false,
                'error' => 'Некорректный запрос.Отсутствует ключ авторизации'
            ], 400);
        }

        // ToDo Проверка пароля
        // 401


        return $next($request);
    }
}
