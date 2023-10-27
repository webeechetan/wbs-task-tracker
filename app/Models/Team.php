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

    public static function getTeam(){
        $id = auth()->user()->id;
        return Team::where('lead_id',$id)->get();
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

}
