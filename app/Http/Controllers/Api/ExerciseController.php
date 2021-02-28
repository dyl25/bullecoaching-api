<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExerciseAdmin;
use App\Models\Exercise;
use App\Models\Image as ExerciseImage;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExerciseController extends Controller
{
    public function index()
    {
        return Exercise::all();
    }

    public function store(StoreExerciseAdmin $request): Exercise
    {

        $exercise = Exercise::create([
            'difficulty_id' => $request->difficulty,
            'author_id' => $request->userId,
            'name' => $request->title,
        ]);

        $tagsId = [];

        if ($request->tags) {
            foreach ($request->tags as $tag) {
                $createdTag = Tag::firstOrCreate([
                    'name' => $tag,
                    'slug' => Str::slug($tag)
                ]);

                $tagsId[] = $createdTag->id;
            };
        }

        $exercise->tags()->attach($tagsId);

        if ($request->file('video')) {
            $uploadedFile = $request->file('video');
            $filename = time() . $uploadedFile->getClientOriginalName();

            if (!Storage::disk('local')->exists('exercises/video')) {
                Storage::makeDirectory('exercises/video');
            }

            Storage::putFileAs(
                'exercises/video',
                $uploadedFile,
                $filename
            );

            Video::create([
                'filename' => $filename
            ]);
        }

        if ($request->beginingImage) {

            $uploadedFile = $request->beginingImage;
            $filename = time() . $uploadedFile->getClientOriginalName();

            if (!Storage::disk('local')->exists('exercises/img')) {
                Storage::makeDirectory('exercises/img');
            }

            $path = storage_path('app/exercises/img/' . $filename);

            Image::make($uploadedFile)->resize(597, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);

            ExerciseImage::create([
                'filename' => $filename,
            ]);
        }

        if ($request->image2) {
            foreach ($request->imageGroup as $key => $content) {

                $uploadedFile = $request->imageGroup[$key]['file'];
                $filename = time() . $uploadedFile->getClientOriginalName();

                if (!Storage::disk('local')->exists('exercises/img')) {
                    Storage::makeDirectory('exercises/img');
                }

                $path = storage_path('app/exercises/img/' . $filename);

                //Image::make($uploadedFile)->heighten(400)->save($path);

                Image::make($uploadedFile)->resize(597, 400, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path);

                Content::create([
                    'exercise_id' => $exercise->id,
                    'type' => $contentType,
                    'filename' => $filename,
                    'explenation' => $request->imageGroup[$key]['description']
                ]);
            }
        }

        return $exercise;
    }
}
