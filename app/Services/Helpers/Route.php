<?php

namespace App\Services\Helpers;

use Illuminate\Routing\Route as RoutingRoute;

class Route extends RoutingRoute
{
    /**
     * Get or set the middlewares attached to the route.
     *
     * @param  array|string|null  $middleware
     * @return $this|array
     */
    public function middleware($middleware = null)
    {
        $this->assignPermissionMiddlewareOnlyForRouteResource();

        return parent::middleware($middleware);
    }

    /**
     * Assign permission middleware only for action of route resource
     *
     * @return void
     */
    private function assignPermissionMiddlewareOnlyForRouteResource()
    {
        if (isset($this->action['namespace']) && $this->action['namespace']  !== 'App\Http\Controllers\Admin') {
            return;
        }

        $controller = $this->action['controller'] ?? null;
        if (!$controller || !is_string($controller)) {
            return;
        }

        $action = explode('@', $this->action['controller'])[1] ?? null;
        if (!$action || !is_string($action)) {
            return;
        }

        foreach ($this->action['middleware'] ?? [] as $key => $middleware) {
            if (is_string($key)
                && strpos($middleware, 'permission') !== false
                && $action !== $key
            ) {
                unset($this->action['middleware'][$key]);
            }
        }
    }
}
