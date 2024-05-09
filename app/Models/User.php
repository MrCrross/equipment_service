<?php

namespace App\Models;

use App\Traits\HistoryModelTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Panoscape\History\HasHistories;
use Panoscape\History\HasOperations;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use HasOperations;
    use HasHistories;
    use HistoryModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login',
        'phone',
        'email',
        'password',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function autocomplete(): Collection
    {
        $result = collect([
            (object)[
                'value' => '',
                'label' => __('datatable.no_selected')
            ]
        ]);

        return $result->merge(
            self::query()
                ->select('id as value', 'name as label')
                ->orderBy('name')
                ->get()
        );
    }

    public function getModelLabel(): string
    {
        return $this->email;
    }

    public function historyMetaFields(): array
    {
        return [
            'name' => [
                'name' => __('users.fields.name'),
            ],
            'phone' => [
                'name' => __('users.fields.phone'),
            ],
            'login' => [
                'name' => __('users.fields.login'),
            ],
            'email' => [
                'name' => __('users.fields.email'),
            ],
        ];
    }
}
