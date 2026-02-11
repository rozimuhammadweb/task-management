<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_by',
        'deadline',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];


    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_users')->withPivot('assigned_by', 'assigned_at')->withTimestamps();
    }

    public function comments(): HasMany|Task
    {
        return $this->hasMany(TaskComment::class);
    }

    public function histories(): HasMany|Task
    {
        return $this->hasMany(TaskHistory::class);
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', TaskStatus::WAITING->value);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', TaskStatus::IN_PROGRESS->value);
    }

    public function scopeDone($query)
    {
        return $query->where('status', TaskStatus::DONE->value);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('assignedUsers', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function isOverdue(): bool
    {
        return $this->deadline && $this->deadline->isPast() && $this->status !== TaskStatus::DONE->value;
    }

    public function isAssignedTo(User $user): bool
    {
        return $this->assignedUsers()->where('user_id', $user->id)->exists();
    }
}
