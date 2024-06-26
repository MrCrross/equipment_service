<?php

namespace App\Models\Orders;

use App\Models\Equipment\Equipment;
use App\Models\User;
use App\Traits\HistoryModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Panoscape\History\HasHistories;

class EquipmentOrder extends Model
{
    use SoftDeletes;
    use HasHistories;
    use HistoryModelTrait;
    use HasFactory;

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
            ->where('language', '=', app()->getLocale());
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

    public function getModelLabel(): string
    {
        return '"' . $this->equipment->short_name . ' ' . $this->equipment->serial . ' ' . Carbon::parse($this->created_at)->format('d.m.Y H:i') . '"';
    }

    public function historyMetaFields(): array
    {
        return [
            'equipment_id' => [
                'name' => __('equipment.headers.main.single'),
                'table' => [
                    'name' => 'equipment',
                    'value' => 'id',
                    'label' => 'short_name'
                ],
            ],
            'master_id' => [
                'name' => __('orders.fields.master'),
                'table' => [
                    'name' => 'users',
                    'value' => 'id',
                    'label' => 'name',
                ]
            ],
            'client_id' => [
                'name' => __('orders.fields.client'),
                'table' => [
                    'name' => 'users',
                    'value' => 'id',
                    'label' => 'name',
                ]
            ],
            'client_name' => [
                'name' => __('orders.fields.client'),
            ],
            'phone' => [
                'name' => __('orders.fields.phone'),
            ],
            'price' => [
                'name' => __('orders.fields.price'),
            ],
            'status_code' => [
                'name' => __('orders.fields.status'),
                'table' => [
                    'name' => 'equipment_orders_statuses',
                    'value' => 'code',
                    'label' => 'name',
                    'language' => true,
                ]
            ],
            'description' => [
                'name' => __('orders.fields.description'),
            ],
            'date_repair' => [
                'name' => __('orders.fields.date_repair'),
            ],
        ];
    }
}
