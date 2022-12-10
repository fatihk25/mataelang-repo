<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sensor() {
        return $this->hasMany(Sensor::class);
    }

    public function organization() {
        return $this->belongsTo(Organization::class);
    }
}
