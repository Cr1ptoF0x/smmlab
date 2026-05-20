<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Refill extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::YES) {
                $html = '<span class="text--small badge fw-normal badge--success">' . trans('Success') . '</span>';
            } elseif ($this->status == Status::NO) {
                $html = '<span><span class="text--small badge fw-normal badge--warning">' . trans('Pending') .  '</span>';
            }
            return $html;
        });
    }

    public function scopeAuthUserRefill($query)
    {
        return $query->whereHas('order', function ($order) {
            $order->where('user_id', auth()->id());
        });
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::NO);
    }

    public function scopeProviderRequestPending($query)
    {
        return $query->where('request_to_provider', Status::NO);
    }
}
