<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Models\Lecture;
use App\Services\LectureService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LectureController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param LectureService $lectureService
     */
    public function __construct(protected LectureService $lectureService)
    {
    }

    /**
     * Display a listing of the lectures.
     * API Method 13: Get all lectures
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $lectures = $this->lectureService->getAllLectures();
            return response()->json($lectures);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Internal server error'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Store a newly created lecture in storage.
     * API Method 15: Create lecture
     *
     * @param StoreLectureRequest $request
     * @return JsonResponse
     */
    public function store(StoreLectureRequest $request): JsonResponse
    {
        try {
            $lecture = $this->lectureService->createLecture($request->validated());
            return response()->json($lecture, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Lecture creation failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display the specified lecture.
     * API Method 14: Get information about specific lecture
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $lecture = $this->lectureService->getLectureById((int) $id);
            return response()->json($lecture);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                ['error' => 'Lecture not found'],
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
     * Update the specified lecture in storage.
     * API Method 16: Update lecture
     *
     * @param UpdateLectureRequest $request
     * @param Lecture $lecture
     * @return JsonResponse
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture): JsonResponse
    {
        try {
            $this->lectureService->updateLecture($lecture, $request->validated());
            return response()->json($lecture->fresh());
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Lecture update failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Remove the specified lecture from storage.
     * API Method 17: Delete lecture
     *
     * @param Lecture $lecture
     * @return JsonResponse
     */
    public function destroy(Lecture $lecture): JsonResponse
    {
        try {
            $this->lectureService->deleteLecture($lecture);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Lecture deletion failed'],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
