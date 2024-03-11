<?php

namespace App\Http\Middleware;

use App\Models\Household;
use App\Models\Recipe;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApplyTenantScopes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * @var Household $household The current household.
         */
        $household = Filament::getTenant();
        Recipe::addGlobalScope(
            fn (Builder $query) => $query->whereHas(
                'household', fn (Builder $query) => $query->where('households.id', $household->id)
            )
        );

        return $next($request);
    }
}
