<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExerciseAdmin;
use App\Models\Exercise;
use App\Models\Image as ExerciseImage;
use App\Models\Media;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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

            $video = Media::create([
                'type' => 'video',
                'filename' => $filename,
            ]);

            $exercise->video_id = $video->id;

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

            $beginImage = Media::create([
                'type' => 'image',
                'filename' => $filename,
            ]);

            $exercise->begin_image_id = $beginImage->id;
        }

        if ($request->endingImage) {

            $uploadedFile = $request->endingImage;
            $filename = time() . $uploadedFile->getClientOriginalName();

            if (!Storage::disk('local')->exists('exercises/img')) {
                Storage::makeDirectory('exercises/img');
            }

            $path = storage_path('app/exercises/img/' . $filename);

            //Image::make($uploadedFile)->heighten(400)->save($path);

            Image::make($uploadedFile)->resize(597, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);

            $endImage = Media::create([
                'type' => 'image',
                'filename' => $filename,
            ]);

            $exercise->end_image_id = $endImage->id;

        }

        $exercise->save();

        return $exercise;
    }
}
