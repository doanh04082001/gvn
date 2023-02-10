<?php

namespace App\Services\Helpers;

use Illuminate\Routing\ResourceRegistrar as RoutingResourceRegistrar;

class ResourceRegistrar extends RoutingResourceRegistrar
{
    /**
     * The default actions for a resourceful controller.
     *
     * @var string[]
     */
    protected $resourceDefaults = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
        'datatable',
    ];

    /**
     * Add the datatable method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array  $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceDatatable($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/datatable';

        unset($options['missing']);

        $action = $this->getResourceAction($name, $controller, 'getDatatable', $options);

        return $this->router->get($uri, $action);
    }
}
