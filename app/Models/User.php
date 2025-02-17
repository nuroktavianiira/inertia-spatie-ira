<?php

namespace App\Models;

// Import kelas-kelas yang diperlukan dari Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    // Menggunakan trait HasFactory untuk memungkinkan pembuatan instance model secara otomatis
    use HasFactory, Notifiable, HasRoles;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Artinya, atribut ini bisa diisi menggunakan metode create() atau fill().
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Atribut yang harus disembunyikan saat model dikonversi ke array atau JSON.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mendefinisikan casting atribut, yaitu mengonversi tipe data tertentu secara otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Mengonversi menjadi objek datetime
            'password' => 'hashed', // Laravel akan secara otomatis menghash password
        ];
    }

    /**
     * Mengambil semua izin (permissions) yang dimiliki pengguna dalam bentuk array asosiatif.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUserPermissions()
    {
        // Mengambil semua izin yang dimiliki pengguna dan mengubahnya menjadi array asosiatif
        return $this->getAllPermissions()->mapWithKeys(fn($permission) => [$permission['name'] => true]);
    }
}
