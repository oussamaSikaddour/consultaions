<?php

namespace App\Http\Middleware;

use App\Enums\UserableTypesEnum;
use App\Models\GeneralSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $generalSetting = GeneralSetting::first();
        $user = auth()->user();
        if ($generalSetting && $user) {
            if ($generalSetting->maintenance &&
                $user->userable_type === UserableTypesEnum::ADMIN_TYPE) {
                // Maintenance mode and the user is an admin
                return redirect()->route('siteParameters');
            } elseif ($generalSetting->maintenance) {
                // Maintenance mode for non-admin users
                return redirect()->route('maintenanceMode');
            }
        } elseif ($generalSetting && $generalSetting->maintenance) {
            // User is not authenticated and maintenance mode is enabled
            return redirect()->route('maintenanceMode');
        }
        // If no maintenance mode or user is an admin, proceed with the request
        return $next($request);
    }

}
