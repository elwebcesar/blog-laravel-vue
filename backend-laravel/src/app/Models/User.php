<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function avatar()
    {
        return $this->belongsTo(Images::class, 'id', 'from_id')->where('from_table', 'users');
    }

    public function menuNavbar()
    {
        return $this->hasMany(Permit::class, 'user_id', 'id')->where(function (Builder $q) {
            $q->where('status', 1);
        })->whereHas('module', function (Builder $q) {
            $q->where('status', 1);
            $q->whereIn('show_on', ['navbar', 'all']);
            $q->where('status', 1);
            $q->orderBy('desc', 'asc');
        });
    }

    public function permits()
    {
        return $this->hasMany(Permit::class, 'user_id', 'id')
            ->where('status', 1)
            ->whereHas('module', function (Builder $q) {
                $q->where('modules.status', 1);
                $q->where('modules.type', 'widget');
            })->with(['module' => function ($q) {
                $q->orderBy('desc', 'asc');
            }]);
    }

    public function isPermitUrl($data)
    {
        return $this->hasOne(Permit::class, 'user_id', 'id')->where('url_module', $data['url'])->whereHas('module', function (Builder $q) {
            $q->where('type', 'module');
        })->first();
    }

    public function permisos()
    {
        return $this->hasMany(Permit::class, 'user_id', 'id')
            ->where('status', 1)
            ->whereHas('module', function (Builder $q) {
                $q->where('modules.status', 1);
            });
    }
}
