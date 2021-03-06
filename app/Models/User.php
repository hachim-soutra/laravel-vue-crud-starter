<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class User extends Authenticatable // implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'phone','city_id','role_id','admin_id','last_activity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *com
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends = [
        'username'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'city_id'           => 'array'
    ];

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoAttribute()
    {
        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '.jpg?s=200&d=mm';
    }
    public function getUsernameAttribute()
    {
        return $this->nom . " " . $this->prenom;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assigning User role
     *
     * @param \App\Models\Role $role
     */
    public function assignRole(Role $role)
    {
        return $this->roles()->save($role);
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', 'Admin')->exists();
    }

    public function isUser()
    {
        return $this->roles()->where('name', 'User')->exists();
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function country()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class,'id');
    }

    public function rammasage()
    {
        if (auth()->user()->roles->first() && auth()->user()->roles->first()->id == 1){
            return Order::where('order_status_id', 3)
                ->whereNull('shipping_id')
                ->count();
        }else {
            return Order::whereIn('city_id',auth()->user()->city_id)->where('order_status_id', 3)->whereNull('shipping_id')
                ->count();
        }
    }
}
