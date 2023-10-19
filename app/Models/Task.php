<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Task extends Model
{
    use HasFactory;

   
    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

}
