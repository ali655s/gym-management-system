<?php

namespace App\Http\Controllers;

use App\Models\FranchiseApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FranchiseController extends Controller
{
    /**
     * Display the franchise opportunities page.
     */
    public function index(): View
    {
        return view('pages.franchise');
    }

    /**
     * Store a newly submitted franchise application.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'city' => ['required', 'string', 'max:100'],
            'capital' => ['required', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        $validated['status'] = 'pending';

        FranchiseApplication::create($validated);

        return redirect()->route('franchise.index')
            ->with('success', 'Thank you for your franchise inquiry! Our executive expansion team will review your application and get in touch within 2-3 business days.');
    }
}
