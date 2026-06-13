<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name','email','password','role'
    ];

    protected $hidden = [
        'password','remember_token'
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function masyarakatConversations()
{
    return $this->hasMany(Conversation::class, 'masyarakat_id');
}

public function pemerintahConversations()
{
    return $this->hasMany(Conversation::class, 'pemerintah_id');
}

}
