<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $total
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $orderItems
 * @property-read int|null $order_items_count
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @property-read string $name
 * @property string $code
 * @property int $user_id
 * @property string $influencer_email
 * @property string|null $address
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $country
 * @property string|null $zip
 * @property int $complete
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereInfluencerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereZip($value)
 * @property string|null $transaction_id
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTransactionId($value)
 * @property-read float $admin_total
 * @property-read float $influencer_total
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getAdminTotalAttribute(): float
    {
        return $this->orderItems->sum(function(OrderItem $item) {
            return $item->admin_revenue;
        });
    }

    public function getInfluencerTotalAttribute(): float
    {
        return $this->orderItems->sum(function(OrderItem $item) {
            return $item->influencer_revenue;
        });
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
