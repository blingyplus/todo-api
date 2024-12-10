<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'details', 'status'];

    const STATUS_NOT_STARTED = 'not_started';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    public static function getAllowedStatuses()
    {
        return [
            self::STATUS_NOT_STARTED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED,
        ];
    }
}
