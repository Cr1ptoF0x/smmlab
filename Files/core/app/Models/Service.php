<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use GlobalStatus;

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function provider()
    {
        return $this->belongsTo(ApiProvider::class, 'api_provider_id', 'id');
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class, 'service_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function userServices()
    {
        return $this->hasMany(UserService::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_services');
    }

    public function scopeDoesntHaveUserService($query, $userId)
    {
        return $query->whereDoesntHave('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function scopeWithDripfeed($query)
    {
        return $query->where('dripfeed', Status::YES);
    }

    public function scopeWithoutDripfeed($query)
    {
        return $query->where('dripfeed', Status::NO);
    }
}
