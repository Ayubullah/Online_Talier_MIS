<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
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
            'password' => 'hashed',
        ];
    }

    /**
     * Get the employee associated with this user.
     */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'F_user_id', 'id');
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has an employee record.
     */
    public function hasEmployeeRecord(): bool
    {
        return $this->employee !== null;
    }

    /**
     * Get the user's employee role if they have one.
     */
    public function getEmployeeRole(): ?string
    {
        return $this->employee?->role;
    }

    /**
     * Check if user is both admin and has employee record.
     */
    public function isAdminEmployee(): bool
    {
        return $this->isAdmin() && $this->hasEmployeeRecord();
    }

    /**
     * Scope to get only admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope to get users with employee records.
     */
    public function scopeWithEmployee($query)
    {
        return $query->whereHas('employee');
    }

    /**
     * Get available user roles.
     */
    public static function getAvailableRoles()
    {
        return ['user', 'admin', 'agent'];
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user is an agent.
     */
    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Get role display name.
     */
    public function getRoleDisplayAttribute()
    {
        $roles = [
            'admin' => 'Administrator',
            'agent' => 'Agent',
            'user' => 'User',
        ];

        return $roles[$this->role] ?? $this->role;
    }
}
