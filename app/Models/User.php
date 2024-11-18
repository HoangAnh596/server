<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    // const ADMIN_ROLE = 1;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'slug',
        'email','password',
        'image', 'content',
        'title_img', 'alt_img',
        'facebook', 'twitter', 'instagram',
        'skype', 'linkedin'
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

    // public function role($role)
    // {
    //     return ($role == User::ADMIN_ROLE) ? "Quản trị viên" : "Người dùng";
    // }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', (array)$roles)->exists();
    }

    public function permissions()
    {
        return $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->unique('id');
    }

    public function hasPermission($permission)
    {
        return $this->permissions()->contains('key_code', $permission);
    }

    public function checkPermissionAccess($permissionCheck)
    {
        // B1: lấy đc tất cả các quyền của user đang login hệ thống
        // B2: So sánh gtri dựa vào router hiện tại xem có tồn tại trong các quyền mà mình lấy đc hay không
        $roles = auth()->user()->roles;
        
        foreach ($roles as $role) {
            $permissions  = $role->permissions;
            if ($permissions->contains('key_code', $permissionCheck)) {
                return true;
            }
        }

        return false;
    }
}
