<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPackage extends Model
{
    protected $fillable = ['ticket_category_id', 'name', 'description'];

    public function category()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function versions()
    {
        return $this->hasMany(TicketVersion::class);
    }
}

