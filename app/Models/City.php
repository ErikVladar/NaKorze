<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'name',
        'postal_code',
    ];

    /**
     * Get the personal information records for this city.
     */
    public function personalInformation(): HasMany
    {
        return $this->hasMany(PersonalInformation::class);
    }
}
