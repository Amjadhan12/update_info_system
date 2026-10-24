<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $expire = "2027-08-02";
        if ($expire <= date("Y-m-d")) {
            echo "<h1 style='text-align:center;color:red;font-weight:bold;margin-top:100px;'>Invalid License</h1><p style='text-align:center'>Contact With <a href='https://www.mtechsh.com/'>MTECHSH.COM</a></p>";
            die;
        }

        return $next($request);
    }
}
