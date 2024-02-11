<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class SistemaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        try {
            if (Schema::hasTable('roles')) {
                $roles = Role::all();
                $permissions = config('sistema')['permissions'];

                $routesAndRoles = [];

                foreach ($permissions as $permission) {
                    foreach ($permission['routes'] as $route) {
                        $rolesThatHaveAccess = $roles->filter(function ($role, $key) use ($permission) {
                            return in_array($permission, $role->permissions);
                        });
                        $routesAndRoles[$route] = $rolesThatHaveAccess->modelKeys();
                    }
                }

                foreach ($routesAndRoles as $route => $roles) {
                    Gate::define($route, function (User $user) use ($route, $roles) {
                        if (in_array($route, config('sistema.ignoreRoutes'))) {
                            return true;
                        }
                        return count(array_intersect($user->roles->pluck('id')->toArray(), $roles)) > 0;
                    });
                }
                Gate::define('is-admin', fn (User $user) => $user->hasAnyAdminRole());
            }

            Gate::before(function ($user) {
                if ($user->is_admin) {
                    return true;
                }
            });
        } catch (\Exception $ex) {
        }
    }
}
