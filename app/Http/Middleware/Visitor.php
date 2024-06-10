<?php

namespace App\Http\Middleware;

use App\Models\Utility\Visitor as UtilityVisitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Visitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if login
        if (auth()->check()) {
            // check jika ip dan type ada dan sama maka update activity
            $data = UtilityVisitor::where('ip_address', $request->ip())->where('type', 'visitor')->first();
            if($data){
                $data->activity = json_encode([
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'input' => $request->all(),
                ]);
                $data->save();
            }else{
                $data = new UtilityVisitor();
                $data->type = 'visitor';
                $data->ip_address = $request->ip();
                $data->user_agent = $request->userAgent();
                $data->activity = json_encode([
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'input' => $request->all(),
                ]);
                $data->active = 'yes';
                $data->save();
            }
        }else{
            // check jika ip dan type ada dan sama maka update activity
            $data = UtilityVisitor::where('ip_address', $request->ip())->where('type', 'guest')->first();
            if($data){
                $data->activity = json_encode([
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'input' => $request->all(),
                ]);
                $data->save();
            }else{
                $data = new UtilityVisitor();
                $data->type = 'guest';
                $data->ip_address = $request->ip();
                $data->user_agent = $request->userAgent();
                $data->activity = json_encode([
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'input' => $request->all(),
                ]);
                $data->active = 'yes';
                $data->save();
            }
        }

        // delete database 3 bulan yang lalu
        UtilityVisitor::where('created_at', '<', now()->subMonths(3))->delete();

        return $next($request);
    }
}
