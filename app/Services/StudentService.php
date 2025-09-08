<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentService
{
    /**
     * Get all students with their school classes loaded
     *
     * @return Collection<int, Student>
     */
    public function getAllStudents(): Collection
    {
        return Student::with('schoolClass')->get();
    }

    /**
     * Get student by ID
     *
     * @param int $id
     * @return Student
     * @throws ModelNotFoundException
     */
    public function getStudentById(int $id): Student
    {
        $student = Student::with([
            'schoolClass',
            'lectures' => function ($query) {
                $query->wherePivotNotNull('completed_at');
            }
        ])->find($id);

        if (!$student) {
            throw new ModelNotFoundException("Student not found with id: {$id}");
        }

        return $student;
    }

    /**
     * Create new student
     *
     * @param array<string, mixed> $data
     * @return Student
     */
    public function createStudent(array $data): Student
    {
        return Student::create($data);
    }

    /**
     * Update student data
     *
     * @param Student $student
     * @param array<string, mixed> $data
     * @return bool
     */
    public function updateStudent(Student $student, array $data): bool
    {
        return $student->update($data);
    }

    /**
     * Delete student
     *
     * @param Student $student
     * @return bool
     */
    public function deleteStudent(Student $student): bool
    {
        return $student->delete();
    }
}
