<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Difficulty;
use Illuminate\Http\Request;

class DifficultyController extends Controller
{
    public function index() {
        return Difficulty::all();
    }
}
