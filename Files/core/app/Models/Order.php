<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use GlobalStatus;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function provider()
    {
        return $this->belongsTo(ApiProvider::class, 'api_provider_id', 'id');
    }

    public function refills()
    {
        return $this->hasMany(Refill::class);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::ORDER_PENDING) {
                $html = '<span class="text--small badge fw-normal badge--warning">' . trans('Pending') . '</span>';
            } elseif ($this->status == Status::ORDER_PROCESSING) {
                $html = '<span><span class="text--small badge fw-normal badge--primary">' . trans('Processing') .  '</span>';
            } elseif ($this->status == Status::ORDER_COMPLETED) {
                $html = '<span class="text--small badge fw-normal badge--success">' . trans('Completed') . '</span><br>' . diffForHumans($this->updated_at) . '</span>';
            } elseif ($this->status == Status::ORDER_CANCELLED) {
                $html = '<span><span class="text--small badge fw-normal badge--danger">' . trans('Cancelled') . '</span><br>' . diffForHumans($this->updated_at) . '</span>';
            } else {
                $html = '<span class="text--small badge fw-normal badge--dark">' . trans('Refunded') . '</span>';
            }
            return $html;
        });
    }


    //Scopes
    public function scopePending($query)
    {
        $query->where('status', Status::ORDER_PENDING);
    }

    public function scopeProcessing($query)
    {
        $query->where('status', Status::ORDER_PROCESSING);
    }

    public function scopeCompleted($query)
    {
        $query->where('status', Status::ORDER_COMPLETED);
    }

    public function scopeCancelled($query)
    {
        $query->where('status', Status::ORDER_CANCELLED);
    }

    public function scopeRefunded($query)
    {
        $query->where('status', Status::ORDER_REFUNDED);
    }

    public function scopeDripfeedOrder($query)
    {
        $query->where('dripfeed', Status::YES);
    }

    public function scopeDirectOrder($query)
    {
        $query->where('dripfeed', Status::NO);
    }

    public function scopePendingApiOrders($query)
    {
        return $query->pending()
            ->where('api_order', '!=', 0)
            ->where('api_order_id', 0)
            ->whereHas('service', function ($service) {
                $service->withoutDripfeed();
            });
    }

    public function scopePendingDripfeedApiOrders($query)
    {
        return $query->pending()
            ->where('api_order', '!=', 0)
            ->where('api_order_id', 0)
            ->whereHas('service', function ($service) {
                $service->withDripfeed();
            });
    }
}
