<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    const NOT_STARTED = 1;
    const IN_PROGRESS = 2;
    const DONE = 3;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function getStatusAttribute($status)
    {
        if ($status == self::NOT_STARTED) {
            return 'Not Started';
        }
        if ($status == self::IN_PROGRESS) {
            return 'In Progress';
        }
        if ($status == self::DONE) {
            return 'Done';
        }
    }
}
