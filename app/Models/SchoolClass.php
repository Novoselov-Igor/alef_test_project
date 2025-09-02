<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolClass extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    /**
     * Get all students in this class.
     *
     * @return HasMany<Student>
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * The lectures that belong to the class's curriculum.
     *
     * @return BelongsToMany<Lecture>
     */
    public function lectures(): BelongsToMany
    {
        return $this->belongsToMany(Lecture::class, 'class_lecture_plan')
            ->withPivot('order', 'completed_at')
            ->orderByPivot('order');
    }
}
