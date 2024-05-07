<?php

namespace App\Models\Orders;

use App\Models\Equipment\Equipment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentOrder extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_orders';
    protected $guarded = [];
    public $timestamps = true;

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'id')->withTrashed();
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrdersStatus::class, 'status_code', 'code')
            ->where('locale', '=', app()->getLocale());
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id')->withTrashed();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id')->withTrashed();
    }

    public function master(): BelongsTo
    {
        return $this->belongsTo(User::class, 'master_id')->withTrashed();
    }
}
