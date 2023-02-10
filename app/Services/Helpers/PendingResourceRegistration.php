<?php

namespace App\Services\Helpers;

use Illuminate\Routing\PendingResourceRegistration as RoutingPendingResourceRegistration;

class PendingResourceRegistration extends RoutingPendingResourceRegistration
{
    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return array_merge(
            parent::resourceAbilityMap(),
            [
                'index' => 'viewAny',
                'show' => 'view',
                'create' => 'create',
                'edit' => 'update',
                'update' => 'update',
                'destroy' => 'delete',
                'datatable' => 'view',
            ]
        );
    }
}
