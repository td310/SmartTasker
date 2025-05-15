<?php

namespace App\Models;

use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'project_id', 'slug', 'code', 'name', 'priority', 'status', 'deadline', 'description'
    ];

    protected function casts(): array
    {
        return [
            'status' => StatusType::class,
            'deadline' => 'date'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}