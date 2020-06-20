<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Todo
 * @package App\Models
 *
 * @property int $id
 * @property string $text
 * @property bool $completed
 * @property bool $urgent
 * @property int $user_id
 * @property User $user
 */

class Todo extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'text',
        'completed',
        'urgent',
        'user_id'
    ];
    /**
     * @var array $casts
     */
    protected $casts = [
        'completed'  => 'bool',
        'urgent'     => 'bool',
        'created_at' => 'datetime'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
