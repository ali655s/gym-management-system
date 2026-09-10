<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\View\View;

class BranchController extends Controller
{
    /**
     * Display a listing of all active branches.
     */
    public function index(): View
    {
        $branches = Branch::active()
            ->with(['membershipPlans' => fn($q) => $q->active()])
            ->get();

        return view('pages.branches', compact('branches'));
    }
}
