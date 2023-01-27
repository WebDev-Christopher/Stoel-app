<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Uuid;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
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
        'admin',
    ];

    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function getAllUsers()
    {
        return $this::all();
    }

    public function updateUser($id, $username, $email) {
        return $this::where('id', $id)->update(['username'=> $username, 'email'=> $email]);
    }

    public function updateUserPassword($id, $password) {
        return $this::where('id', $id)->update(['password'=> $password]);
    }

    public function updateUserAdmin($id, $admin) {
        return $this::where('id', $id)->update(['admin'=> $admin]);
    }

    public function updateUserVerification($id, $verify) {
        return $this::where('id', $id)->update(['email_verify_at'=> $verify]);
    }
}
