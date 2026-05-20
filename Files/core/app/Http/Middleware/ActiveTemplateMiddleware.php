<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Page;
use App\Models\Order;
use App\Constants\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


class ActiveTemplateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $viewShare['activeTemplate']     = activeTemplate();
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        view()->share($viewShare);

        view()->composer(['Template::partials.header', 'Template::partials.footer'], function ($view) {
            $view->with([
                'pages' => Page::where('is_default', Status::NO)->where('tempname', activeTemplate())->orderBy('id', 'DESC')->get()
            ]);
        });

        view()->composer(['Template::partials.sidenav'], function ($view) {
            $view->with([
                'pendingOrders'         => Order::where('user_id', auth()->user()->id)->directOrder()->pending()->count(),
                'pendingDripfeedOrders' => Order::where('user_id', auth()->user()->id)->dripfeedOrder()->pending()->count()
            ]);
        });

        View::addNamespace('Template', resource_path('views/templates/' . activeTemplateName()));
        return $next($request);
    }
}
