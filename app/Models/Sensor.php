<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Sensor extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function SensorHeartbeat()
    {
        return $this->hasMany(SensorHeartbeat::class);
    }

    public function asset() {
        return $this->belongsTo(Asset::class);
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}