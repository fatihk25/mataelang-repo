<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    public function asset() {
        return $this->hasMany(Asset::class);
    }

    public function sensor() {
        return $this->hasMany(Sensor::class);
    }

    public function role() {
        return $this->hasMany(Role::class);
    }

    public function organization_member() {
        return $this->hasMany(OrganizationMember::class);
    }
}
