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
     * @param $password
     */
    public function storeCurrentPasswordInHistory($password) {
        $this->passwordHistory()->create(compact('password'));
    }

    /**
     * Undocumented function
     *
     * @param integer $keep
     * @return void
     */
    public function deletePasswordHistory(int $keep = 5)
    {
        if (!$this->passwordHistory()->first()) {
            return;
        }

        $this->passwordHistory()
            ->where('id', '<=', $this->passwordHistory()->first()->id - $keep)
            ->delete();
    }

    public function passwordHistory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PasswordHistory::class)
            ->latest();
    }
}
