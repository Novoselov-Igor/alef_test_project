<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lecture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'topic',
        'description',
    ];

    /**
     * The school classes that have this lecture in their curriculum.
     * This is a many-to-many relationship through the class_lecture_plan pivot table.
     *
     * @return BelongsToMany<SchoolClass>
     */
    public function schoolClasses(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_lecture_plan')
            ->withPivot('order', 'completed_at');
    }

    /**
     * The students who have attended this lecture.
     *
     * @return BelongsToMany<Student>
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'class_lecture_plan', 'lecture_id', 'school_class_id')
            ->wherePivot('lecture_id', $this->id)
            ->withPivot('completed_at')
            ->withTimestamps();
    }
}
