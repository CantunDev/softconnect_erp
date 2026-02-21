<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'surname',
        'phone',
        'email',
        'password',
        'user_file'
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

    protected $appends = ['full_name','avatar_url'];
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->lastname} {$this->surname}";
    }

    public function getAvatarUrlAttribute()
    {
         if ($this->user_file) {
            return asset('storage/' . $this->user_file);
        }
        $name = $this->full_name ?: 'User';
        $initials = urlencode($name);

        return "https://ui-avatars.com/api/?" . http_build_query([
            'name'       => $this->full_name,
            'background' => $this->status_color, //'random'
            'color'      => 'fff',
            'size'       => 128,
            'bold'       => true,
        ]);
    }   

    public function getStatusColorAttribute()
    {
        if ($this->trashed()) {
            return '999999'; // gris
        }
        return '9F7AEA'; // azul
    }
    /**
     * The business that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function business(): BelongsToMany
    {
        return $this->belongsToMany(Business::class, 'users_business', 'user_id', 'business_id');
    }
    
    /**
     * The restaurants that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class, 'users_restaurants', 'user_id', 'restaurant_id');
    }
}
