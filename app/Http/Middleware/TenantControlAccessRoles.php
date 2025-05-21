<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TenantControlAccessRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if(Gate::allows('has.role', $role)) {
            \abort(403, 'FORBIDDEN');
        };
        //Tenant customer: Não pode acessar o painel de gerenciamento
        //Tenant: acessa o painel de gerenciamento para o gerenciamento de seus clientes
        //Admin: gerencia o projeto tenant, deve ter o gerenciamento dos seus tenants e do sistema
        return $next($request);
    }
}
