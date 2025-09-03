<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SchoolClassService
{
    /**
     * Get all classes
     *
     * @return Collection<int, SchoolClass>
     */
    public function getAllClasses(): Collection
    {
        return SchoolClass::all();
    }

    /**
     * Get class by ID
     *
     * @param int $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return SchoolClass|\Illuminate\Database\Eloquent\Builder<SchoolClass>
     */
    public function getClassById(int $id): SchoolClass
    {
        $class = SchoolClass::with('students')->find($id);

        if (!$class) {
            throw new ModelNotFoundException("Class not found with id: {$id}");
        }

        return $class;
    }

    /**
     * Create new class
     *
     * @param array $data
     * @return SchoolClass
     */
    public function createClass(array $data): SchoolClass
    {
        return SchoolClass::create($data);
    }

    /**
     * Update class data
     *
     * @param \App\Models\SchoolClass $class
     * @param array $data
     * @return bool
     */
    public function updateClass(SchoolClass $class, array $data): bool
    {
        return $class->update($data);
    }

    /**
     * Delete class
     *
     * @param \App\Models\SchoolClass $class
     * @return bool|null
     */
    public function deleteClass(SchoolClass $class): bool
    {
        // Открепляем студентов перед удалением класса (требование ТЗ п.12)
        $class->students()->update(['school_class_id' => null]);

        return $class->delete();
    }

    /**
     * Get curriculum
     *
     * @param \App\Models\SchoolClass $class
     * @return Collection<int, \App\Models\Lecture>
     */
    public function getCurriculum(SchoolClass $class): Collection
    {
        return $class->lectures()->orderByPivot('order')->get();
    }
}
