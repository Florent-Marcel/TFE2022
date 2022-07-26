<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public function getFilamentName(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function canAccessFilament(): bool
    {
        return $this->is_admin;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'firstname',
        'lastname',
        'is_blocked',
        'is_admin',
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

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function temporaryTickets(){
        return $this->hasMany(TemporaryTicket::class);
    }

    public function softDeleteRGPD(){
        $this->email = "deleted.user@".$this->id;
        $this->firstname = "deleted";
        $this->lastname = "deleted";
        $this->is_blocked = true;

        $this->save();
        $this->delete();
    }
}
