<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends BaseModel
{
    use HasFactory;

    const ADDRESS_PATH_NAME = 'metadata/address.json';
    const ADDRESS_VERSION_PATH_NAME = 'metadata/address-version.json';

    /**
     * Get the districts for the province.
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
