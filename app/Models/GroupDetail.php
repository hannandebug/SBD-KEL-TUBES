<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupDetail extends Model
{
    use HasFactory;

    protected $table = 'group_detail';
    protected $primaryKey = 'id_group_detail';
    public $timestamps = true;

    protected $fillable = [
        'id_group_detail',
        'id_group',
        'founded_date',
        'group_timezone',
        'join_mode',
        'is_private',
        'leadership_members',
        'pending_members',
        'id_member',
        'host_name',
        'photo_album',
        'welcome_message',
        'total_ratings',
    ];

    protected $casts = [
        'founded_date' => 'datetime',
        'is_private' => 'boolean',
    ];

    /**
     * Get the group
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'id_group', 'id_group');
    }

    /**
     * Get the group organizer
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_member', 'id_member');
    }
}
