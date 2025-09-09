<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Lecture;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LectureService
{
    /**
     * Get all lectures
     *
     * @return Collection<int, Lecture>
     */
    public function getAllLectures(): Collection
    {
        return Lecture::all();
    }

    /**
     * Get lecture by ID
     *
     * @param int $id
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return Lecture|\Illuminate\Database\Eloquent\Builder<Lecture>
     */
    public function getLectureById(int $id): Lecture
    {
        $lecture = Lecture::with([
            'schoolClasses',
            'students' => function ($query) {
                $query->whereNotNull('class_lecture_plan.completed_at');
            }
        ])->find($id);

        if (!$lecture) {
            throw new ModelNotFoundException("Lecture not found with id: {$id}");
        }

        return $lecture;
    }

    /**
     * Create new lecture
     *
     * @param array $data
     * @return Lecture
     */
    public function createLecture(array $data): Lecture
    {
        return Lecture::create($data);
    }

    /**
     * Update lecture data
     *
     * @param \App\Models\Lecture $lecture
     * @param array $data
     * @return bool
     */
    public function updateLecture(Lecture $lecture, array $data): bool
    {
        return $lecture->update($data);
    }

    /**
     * Delete lecture
     *
     * @param \App\Models\Lecture $lecture
     * @return bool|null
     */
    public function deleteLecture(Lecture $lecture): bool
    {
        return $lecture->delete();
    }
}
