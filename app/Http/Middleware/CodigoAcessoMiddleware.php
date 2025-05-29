<?php

namespace App\Http\Middleware;

use App\Models\Subdomain;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CodigoAcessoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $subdomainId = $request->get('subdomain_id');

        $mainUrl = env('MAIN_URL', 'app.test');
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        $subdomain = Subdomain::where('domain', "$subdomain.$mainUrl")->first();

        if ($subdomain && empty($subdomain->codigo)) {
            return $next($request);
        }

        if (! Session::get('codigo_acesso')) {

            Session::put('subdomainId', $subdomainId);

            return redirect()->route('acesso');
        }


        if ($subdomain) {
            $canpass = strtoupper($subdomain->codigo) == strtoupper(Session::get('codigo_acesso'));

            if (!$canpass) {
                return redirect()->route('acesso');
            }
        }

        return $next($request);
    }
}
