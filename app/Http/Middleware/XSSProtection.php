<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        array_walk_recursive($input, function(&$input) {
            if (!is_array($input)) {
                $input = strip_tags($input, '<p><br><strong><em>');
                $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
                $input = $this->removeDangerousStrings($input);
            }
        });

        $request->merge($input);
        return $next($request);
    }

    private function removeDangerousStrings($string)
    {
        $dangerous = [
            'javascript:',
            'javascript\s*:',
            'vbscript:',
            'onload=',
            'onerror=',
            'onclick=',
            'onmouseover=',
            'onmouseout=',
            'onkeydown=',
            'onkeypress=',
            'eval\s*\(',
        ];

        return preg_replace('/' . implode('|', $dangerous) . '/i', '', $string);
    }
}