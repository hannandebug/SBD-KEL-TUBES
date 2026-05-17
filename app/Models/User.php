<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_member';
    public $incrementing = false;
    protected $keyType = 'bigint';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_member',
        'member_name',
        'member_email',
        'member_city',
        'member_country',
        'member_gr_count',
        'member_ev_count',
        'created_at',
        'updated_at',
        'name',
        'email',
        'password',
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

    public function getPhotoUrlAttribute()
    {
        return 'https://via.placeholder.com/150?text=' . urlencode(substr($this->member_name ?? 'U', 0, 1));
    }

    public function getAvatarAttribute()
    {
        return substr($this->member_name ?? 'U', 0, 1);
    }

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
     * Get the groups that the user is a member of
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            Group::class,
            'member_group',
            'id_member',
            'id_group'
        )->withPivot('role', 'joined_at')->withTimestamps();
    }

    /**
     * Get the events the user is attending
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(
            Event::class,
            'event_attendance',
            'id_member',
            'id_event'
        )->withPivot('rsvps_status', 'attended_at')->withTimestamps();
    }

    /**
     * Get the reviews written by this user
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'id_member', 'id_member');
    }

    /**
     * Get the events hosted by this user
     */
    public function hostedEvents(): BelongsToMany
    {
        return $this->belongsToMany(
            Event::class,
            'event_hosts',
            'id_member',
            'id_event'
        )->withPivot('role')->withTimestamps();
    }
}
