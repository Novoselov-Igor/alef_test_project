<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'school_class_id',
    ];

    /**
     * Get the school class that the student belongs to.
     *
     * @return BelongsTo<SchoolClass, Student>
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    /**
     * The lectures that the student has attended.
     *
     * @return BelongsToMany<Lecture>
     */
    public function lectures(): BelongsToMany
    {
        return $this->belongsToMany(Lecture::class, 'class_lecture_plan')
            ->withPivot('completed_at')
            ->withTimestamps();
    }
}
