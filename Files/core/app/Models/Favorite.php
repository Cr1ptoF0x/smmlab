<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    function scopeUser($query, $userId)
    {
        $query->where('user_id', $userId);
    }
}
