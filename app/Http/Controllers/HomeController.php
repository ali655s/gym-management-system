<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Member;
use App\Models\Partner;
use App\Models\Trainer;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the public homepage.
     */
    public function index(): View
    {
        $trainers = Trainer::active()->get();
        $partners = Partner::active()->get();
        $testimonials = config('testimonials.items', []);

        $stats = [
            'members' => Member::count() > 0 ? Member::count() + 2450 : 2500,
            'branches' => Branch::active()->count(),
            'trainers' => Trainer::active()->count(),
            'years' => 12,
        ];

        $featuredBranches = Branch::active()
            ->with(['membershipPlans' => fn($q) => $q->active()])
            ->get();

        return view('pages.home', compact('trainers', 'partners', 'testimonials', 'stats', 'featuredBranches'));
    }
}
