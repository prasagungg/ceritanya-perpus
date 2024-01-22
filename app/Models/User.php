<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nim',
        'name',
        'email',
        'contact',
        'role',
        // 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];


    // role additional
    public const ROLE_MAHASISWA_ITBS = 'mahasiswa_itbs';
    public const ROLE_MAHASISWA_LUAR = 'mahasiswa_luar';
    public const ROLE_MASYARAKAT_UMUM = 'masyarakat_umum';

    public static function getRolesList($includeMasyarakatUmum = true)
    {
        $roles = [
            self::ROLE_MAHASISWA_ITBS => 'Mahasiswa ITBS',
            self::ROLE_MAHASISWA_LUAR => 'Mahasiswa Luar',
            self::ROLE_MASYARAKAT_UMUM => 'Masyarakat Umum',
            // Add other roles as needed
        ];

        if (!$includeMasyarakatUmum) {
            unset($roles[self::ROLE_MASYARAKAT_UMUM]);
        }

        return $roles;
    }

    public function borrows()
    {
        return $this->hasMany(TransactionBorrow::class, 'user_id');
    }
}
