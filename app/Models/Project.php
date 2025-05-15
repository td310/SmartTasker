<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Project extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'slug', 'code', 'name', 'description'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }
    public function removeMember(User $user)
    {
        return $this->members()->detach($user);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user', 'user_id', 'project_id')->withTimestamps();
    }
}