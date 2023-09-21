<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function lead()
    {
        return $this->belongsTo(User::class, 'lead_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }
}
