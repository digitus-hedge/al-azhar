<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Concerns\LogsActivity;
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,LogsActivity;

    /**
     * Module keys a "staff" role user can be granted. Keep this in sync
     * with the checkboxes in the Staff form's Login Access card and with
     * the `module:` route middleware applied in routes/web.php.
     */
    public const MODULES = [
        'news-notices' => 'News & Notices',
        'events'       => 'Events',
        'gallery'      => 'Gallery',
        'enquiries'    => 'Admission Enquiries',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'permissions',
    ];

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
            'password'          => 'hashed',
            'permissions'       => 'array',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaffRole(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Whether this user may access the given module. Admins always can;
     * staff users need the module key present in their `permissions` array.
     */
    public function hasModule(string $module): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return in_array($module, $this->permissions ?? [], true);
    }
}
