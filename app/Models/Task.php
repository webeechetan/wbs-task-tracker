<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends Model
{
    use HasFactory;

    protected function client() : Attribute
    {
        return Attribute::make(
            set : fn ($value) => ucfirst($value),
        );
    }

}
