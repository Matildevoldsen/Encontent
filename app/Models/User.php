<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        static::updated(function ($user) {
            if ($password = Arr::get($user->getChanges(), 'password')) {
                $user->storeCurrentPasswordInHistory($password);
            }
        });

        static::created(function ($user) {
            $user->storeCurrentPasswordInHistory($user->password);
        });
    }

    /**
     * @param $password
     */
    protected function storeCurrentPasswordInHistory($password) {
        $this->passwordHistory()->create(compact('password'));
    }

    public function passwordHistory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PasswordHistory::class)
            ->latest();
    }
}
