<?php

namespace Modules\PartnerApiManagement\Entities;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\UserManagement\Entities\User;

class Partner extends Model
{
    use HasUuid, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'api_key',
        'api_secret',
        'customer_id',
        'webhook_url',
        'webhook_secret',
        'is_active',
    ];

    protected $hidden = [
        'webhook_secret',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The "customer" user record that this partner acts as when creating
     * delivery orders through the existing trip/parcel services.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
