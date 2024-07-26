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
        // Cek apakah user sudah login
        if (auth()->check()) {
            // Ambil data visitor berdasarkan IP address
            $data = UtilityVisitor::where('ip_address', $request->ip())->first();
            if ($data) {
                // Jika sudah ada data dan user sudah login, ubah type menjadi 'user'
                $data->type = 'user';
                $data->activity = json_encode([
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'input' => $request->all(),
                ]);
                $data->save();
            } else {
                // Jika belum ada data, buat data baru dengan type 'user'
                $data = new UtilityVisitor();
                $data->type = 'user';
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
        } else {
            // Jika user belum login, cek apakah ada data visitor dengan IP address
            $data = UtilityVisitor::where('ip_address', $request->ip())->first();
            if ($data) {
                // Jika sudah ada data, ubah type menjadi 'guest' jika sebelumnya bukan 'user'
                if ($data->type !== 'user') {
                    $data->type = 'guest';
                }
                $data->activity = json_encode([
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'input' => $request->all(),
                ]);
                $data->save();
            } else {
                // Jika belum ada data, buat data baru dengan type 'guest'
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

        // Hapus data visitor yang lebih dari 3 bulan
        UtilityVisitor::where('created_at', '<', now()->subMonths(3))->delete();

        return $next($request);
    }
}
