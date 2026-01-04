<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    public function ticketVersions(): HasMany
    {
        return $this->hasMany(TicketVersion::class);
    }
}
