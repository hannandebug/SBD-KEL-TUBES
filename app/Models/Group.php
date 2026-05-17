<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Group extends Model
{
    use HasFactory;

    protected $table = 'group_list';
    protected $primaryKey = 'id_group';
    public $incrementing = false;
    protected $keyType = 'bigint';
    public $timestamps = true;

    protected $fillable = [
        'id_group',
        'group_name',
        'group_description',
        'city',
        'country',
        'is_newgroup',
        'member_count',
        'group_photo',
        'average_rating',
        'category',
    ];

    /**
     * Get photo URL for the group
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->group_photo) {
            return $this->group_photo;
        }
        return 'https://secure.meetupstatic.com/next/images/fallbacks/redesign/group-cover-4-wide.webp?w=1200';
    }

    /**
     * Get the group details
     */
    public function detail(): HasOne
    {
        return $this->hasOne(GroupDetail::class, 'id_group', 'id_group');
    }

    /**
     * Get the members of the group
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'member_group',
            'id_group',
            'id_member'
        )->withPivot('role', 'joined_at')->withTimestamps();
    }

    /**
     * Get the topics of the group
     */
    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(
            Topic::class,
            'group_topic',
            'id_group',
            'id_topic'
        )->withTimestamps();
    }

    /**
     * Get the events of the group
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'id_group', 'id_group');
    }

    /**
     * Get the reviews of the group
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'id_group', 'id_group');
    }
}
