<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class ApiProvider extends Model
{
    use GlobalStatus;

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'api_provider_id', 'id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('status', Status::ENABLE);
    }
}
