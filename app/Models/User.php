<?php

namespace App\Models;

use App\Models\News;
use App\Models\Role\Admin;
use App\Models\Role\Development;
use App\Models\Role\Director;
use App\Models\Role\Expansition;
use App\Models\Role\Miniral;
use App\Models\Role\ourStaff;
use App\Models\Slider;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'position',
        'image',
        'phone_no',
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
        'password' => 'hashed',
    ];
    public function director() { return $this->hasOne(Director::class); }
    public function development(){ return $this->hasOne(Development::class); }
    public function expansion(){ return $this->hasOne(Expansition::class); }
    public function miniral(){ return $this->hasOne(Miniral::class); }
    public function admin(){ return $this->hasOne(Admin::class); }
    public function ourStaf(){ return $this->hasOne(ourStaff::class); }
    public function slider(){ return $this->hasOne(Slider::class); }


    // protected static function boot()
    // {
    //     parent::boot();
    
    //     static::creating(function ($user) {
    //         if (empty($user->role)) {
    //             $user->role = 'ourStaff';
    //         }
    //     });
    // }
    
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'author_id');
    }
    public function news(): HasMany
    {
        return $this->hasMany(news::class, 'author_id');
    }
        public function webContents(): HasMany
    {
        return $this->hasMany(WebContent::class, 'author_id');
    }
    public function departmentContents(): HasMany
    {
        return $this->hasMany(DepartmentContent::class, 'author_id');
    }

    public function previousWorks(): HasMany
    {
        return $this->hasMany(PreviousWork::class, 'author_id');
    }
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class, 'author_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(AnnouncEvent::class,'author_id');
    }

    public function allmessages(): HasMany
    {
        return $this->hasMany(Allmessage::class,'author_id');
    }
    public function sponsers(): HasMany
    {
        return $this->hasMany(Sponser::class,'author_id');
    }
    public function testimonail(): HasMany
    {
        return $this->hasMany(Testimonail::class,'author_id');
    }
    public function banner(): HasMany
    {
        return $this->hasMany(Banner::class,'author_id');
    }
    public function staff(){
        return $this->hasMany(staff::class,'user_id');
    }
    public function testimonails()
{
    return $this->hasMany(Testimonail::class, 'author_id');
}
}
        