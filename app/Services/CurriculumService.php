<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SchoolClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CurriculumService
{
    /**
     * Update the curriculum for a school class
     *
     * @param SchoolClass $class
     * @param array<int, array{id: int, order: int}> $lecturesData
     * @return void
     */
    public function updateCurriculum(SchoolClass $class, array $lecturesData): void
    {
        DB::transaction(function () use ($class, $lecturesData) {
            $class->lectures()->detach();

            $curriculumData = [];
            foreach ($lecturesData as $lectureData) {
                $curriculumData[$lectureData['id']] = [
                    'order' => $lectureData['order'],
                    'completed_at' => null
                ];
            }

            $class->lectures()->attach($curriculumData);
        });
    }

    /**
     * Mark specific lecture as completed for a student
     *
     * @param SchoolClass $class
     * @param int $lectureId
     * @param int $studentId
     * @return void
     * @throws ModelNotFoundException
     */
    public function markLectureAsCompleted(SchoolClass $class, int $lectureId, int $studentId): void
    {
        DB::transaction(function () use ($class, $lectureId, $studentId) {
            $lecture = $class->lectures()->where('lecture_id', $lectureId)->first();

            if (!$lecture) {
                throw new ModelNotFoundException("Lecture not found in class curriculum");
            }

            $lecture->students()->updateExistingPivot($studentId, [
                'completed_at' => now()
            ]);
        });
    }
}
