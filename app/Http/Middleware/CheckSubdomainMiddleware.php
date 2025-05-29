<?php

namespace App\Http\Middleware;

use App\Models\Page;
use App\Models\Subdomain;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubdomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $mainUrl = env('MAIN_URL', 'app.test');
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        // Busca o subdomínio no banco
        $subdomainModel = Subdomain::where('domain', "$subdomain.$mainUrl")->first();

        if (! $subdomainModel &&  $mainUrl !== $request->getHost()) {
            abort(404, 'Subdomain not found');
        }

        if ($subdomainModel) {
            $request->attributes->set('subdomain_id', $subdomainModel->id);
        }

        $pageId = $request->route('page');



        if ($pageId) {
            $page = Page::where('subdomain_id', $subdomainModel?->id)
                ->where(function ($query) use ($pageId) {
                    $query->where('id', $pageId);
                    $query->orWhere('slug', $pageId);
                })
                ->first();
            if (! $page) {
                abort(404, 'Page not found');
            }
        }


        return $next($request);
    }
}
