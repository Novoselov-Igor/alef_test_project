<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param StudentService $studentService
     */
    public function __construct(protected StudentService $studentService)
    {
    }

    /**
     * Display a listing of the students.
     * API Method 1: Get all students
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $students = $this->studentService->getAllStudents();
            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Internal server error'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Store a newly created student in storage.
     * API Method 3: Create student
     *
     * @param StoreStudentRequest $request
     * @return JsonResponse
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        try {
            $student = $this->studentService->createStudent($request->validated());
            return response()->json($student, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Student creation failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified student.
     * API Method 2: Get information about specific student
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $student = $this->studentService->getStudentById((int) $id);
            return response()->json($student);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                ['error' => 'Student not found'],
                Response::HTTP_NOT_FOUND
            );
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Internal server error'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update the specified student in storage.
     * API Method 4: Update student
     *
     * @param UpdateStudentRequest $request
     * @param Student $student
     * @return JsonResponse
     */
    public function update(UpdateStudentRequest $request, Student $student): JsonResponse
    {
        try {
            $this->studentService->updateStudent($student, $request->validated());
            return response()->json($student->fresh());
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Student update failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified student from storage.
     * API Method 5: Delete student
     *
     * @param Student $student
     * @return JsonResponse
     */
    public function destroy(Student $student): JsonResponse
    {
        try {
            $this->studentService->deleteStudent($student);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Student deletion failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
