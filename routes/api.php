<?php

use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\SchoolClassController;
use App\Http\Controllers\API\LectureController;
use Illuminate\Support\Facades\Route;

// Students (methods 1-5)
Route::apiResource('students', StudentController::class);

// School Classes (methods 6-12)
Route::apiResource('school-classes', SchoolClassController::class);

// Lectures (methods 13-17)
Route::apiResource('lectures', LectureController::class);

// Curriculum special routes (methods 8-9)
Route::get('school-classes/{schoolClass}/curriculum', [SchoolClassController::class, 'getCurriculum']);
Route::put('school-classes/{schoolClass}/curriculum', [SchoolClassController::class, 'updateCurriculum']);
