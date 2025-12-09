<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'address',
        'gender',
        'bio',
        'photo',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function moneyDonations()
    {
        return $this->hasMany(MoneyDonation::class);
    }

    public function goodsDonations()
    {
        return $this->hasMany(GoodsDonation::class);
    }

    public function volunteerDonations()
    {
        return $this->hasMany(VolunteerDonation::class);
    }

    // Role methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
}
