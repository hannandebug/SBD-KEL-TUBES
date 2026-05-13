<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventDetail extends Model
{
    use HasFactory;

    protected $table = 'event_detail';
    protected $primaryKey = 'id_event_detail';
    public $timestamps = true;

    protected $fillable = [
        'id_event_detail',
        'id_event',
        'event_status',
        'event_endtime',
        'rsvp_state',
        'venue_address',
    ];

    protected $casts = [
        'event_endtime' => 'datetime',
    ];

    /**
     * Get the event
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'id_event', 'id_event');
    }
}
