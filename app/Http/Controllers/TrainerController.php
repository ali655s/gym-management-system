<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\View\View;

class TrainerController extends Controller
{
    /**
     * Display a listing of all active coaches/trainers.
     */
    public function index(): View
    {
        $trainers = Trainer::active()->get();

        return view('pages.trainers', compact('trainers'));
    }
}
