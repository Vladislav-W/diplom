<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveBomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Удаляем BOM из ответа, если он есть
        if ($response instanceof Response) {
            $content = $response->getContent();
            if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                $response->setContent(substr($content, 3));
            }
        }
        
        return $response;
    }
}
