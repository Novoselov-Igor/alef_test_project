<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolClassRequest;
use App\Http\Requests\UpdateSchoolClassRequest;
use App\Http\Requests\UpdateCurriculumRequest;
use App\Models\SchoolClass;
use App\Services\SchoolClassService;
use App\Services\CurriculumService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SchoolClassController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param SchoolClassService $schoolClassService
     * @param CurriculumService $curriculumService
     */
    public function __construct(
        protected SchoolClassService $schoolClassService,
        protected CurriculumService $curriculumService
    ) {
    }

    /**
     * Display a listing of the classes.
     * API Method 6: Get all classes
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $classes = $this->schoolClassService->getAllClasses();
            return response()->json($classes);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Internal server error'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Store a newly created class in storage.
     * API Method 10: Create class
     *
     * @param StoreSchoolClassRequest $request
     * @return JsonResponse
     */
    public function store(StoreSchoolClassRequest $request): JsonResponse
    {
        try {
            $class = $this->schoolClassService->createClass($request->validated());
            return response()->json($class, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Class creation failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified class.
     * API Method 7: Get information about specific class
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $class = $this->schoolClassService->getClassById((int) $id);
            return response()->json($class);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                ['error' => 'Class not found'],
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
     * Update the specified class in storage.
     * API Method 11: Update class
     *
     * @param UpdateSchoolClassRequest $request
     * @param SchoolClass $schoolClass
     * @return JsonResponse
     */
    public function update(UpdateSchoolClassRequest $request, SchoolClass $schoolClass): JsonResponse
    {
        try {
            $this->schoolClassService->updateClass($schoolClass, $request->validated());
            return response()->json($schoolClass->fresh());
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Class update failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified class from storage.
     * API Method 12: Delete class
     *
     * @param SchoolClass $schoolClass
     * @return JsonResponse
     */
    public function destroy(SchoolClass $schoolClass): JsonResponse
    {
        try {
            $this->schoolClassService->deleteClass($schoolClass);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Class deletion failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Get curriculum for specific class.
     * API Method 8: Get curriculum for specific class
     *
     * @param SchoolClass $schoolClass
     * @return JsonResponse
     */
    public function getCurriculum(SchoolClass $schoolClass): JsonResponse
    {
        try {
            $curriculum = $this->schoolClassService->getCurriculum($schoolClass);
            return response()->json($curriculum);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Failed to get curriculum'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Update curriculum for specific class.
     * API Method 9: Create/update curriculum for specific class
     *
     * @param UpdateCurriculumRequest $request
     * @param SchoolClass $schoolClass
     * @return JsonResponse
     */
    public function updateCurriculum(UpdateCurriculumRequest $request, SchoolClass $schoolClass): JsonResponse
    {
        try {
            $this->curriculumService->updateCurriculum($schoolClass, $request->validated()['lectures']);
            return response()->json(['message' => 'Curriculum updated successfully']);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Curriculum update failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
