<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Topic extends Model
{
    use HasFactory;

    protected $table = 'topic';
    protected $primaryKey = 'id_topic';
    public $incrementing = false;
    protected $keyType = 'bigint';
    public $timestamps = true;

    protected $fillable = [
        'id_topic',
        'topic_name',
    ];

    /**
     * Get the groups with this topic
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(
            Group::class,
            'group_topic',
            'id_topic',
            'id_group'
        )->withTimestamps();
    }
}
