<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event_list';
    protected $primaryKey = 'id_event';
    public $incrementing = false;
    protected $keyType = 'bigint';
    public $timestamps = true;

    protected $fillable = [
        'id_event',
        'id_group',
        'event_title',
        'event_type',
        'event_date',
        'event_description',
        'total_rsvps',
        'venue_name',
        'venue_city',
        'venue_country',
        'event_photo',
        'category',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    /**
     * Get photo URL for the event
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->event_photo) {
            return $this->event_photo;
        }
        // Fallback to placeholder
        return 'https://via.placeholder.com/400x300?text=' . urlencode($this->event_title ?? 'Event');
    }

    /**
     * Get the group that hosts this event
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'id_group', 'id_group');
    }

    /**
     * Get the event details
     */
    public function detail(): HasOne
    {
        return $this->hasOne(EventDetail::class, 'id_event', 'id_event');
    }

    /**
     * Get the attendees of the event
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'event_attendance',
            'id_event',
            'id_member'
        )->withPivot('rsvps_status', 'attended_at')->withTimestamps();
    }

    /**
     * Get the hosts of the event
     */
    public function hosts(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'event_hosts',
            'id_event',
            'id_member'
        )->withPivot('role')->withTimestamps();
    }

    /**
     * Get the reviews of the event
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'id_event', 'id_event');
    }
}
