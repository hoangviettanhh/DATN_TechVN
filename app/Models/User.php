<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_role',
        'name',
        'email',
        'phone',
        'avatar',
        'password',
        'address',
        'created_by',
        'updated_by',
        'role',
        'status'
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
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'id_role' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];

    protected $attributes = [
        'status' => 1 // 1: active, 0: inactive
    ];

    const ROLES = [
        'admin' => 1,
        'user' => 2
    ];

    public static function getRoles()
    {
        return [
            self::ROLES['admin'] => 'Quản trị viên',
            self::ROLES['user'] => 'Người dùng'
        ];
    }

    public function isAdmin()
    {
        return $this->id_role === self::ROLES['admin'];
    }

    public function isUser()
    {
        return $this->id_role === self::ROLES['user'];
    }

    public static function getUsers($ignoreStatus = false)
    {
        $query = self::query();
        
        if (!$ignoreStatus) {
            $query->where('status', 1);
        }
        
        return $query->orderBy('id_user', 'desc')->get();
    }

    public static function getUser($id)
    {
        return self::findOrFail($id);
    }

    public function deactivate()
    {
        $this->status = 0;
        return $this->save();
    }

    public function activate()
    {
        $this->status = 1;
        return $this->save();
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_user', 'id');
    }
}
