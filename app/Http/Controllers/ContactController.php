<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display the contact us page.
     */
    public function index(): View
    {
        $branches = Branch::active()->get();

        return view('pages.contact', compact('branches'));
    }

    /**
     * Store an incoming contact message.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        $validated['is_read'] = false;

        ContactMessage::create($validated);

        return redirect()->back()
            ->with('success', 'Your message has been received! Our fitness consultants will contact you shortly.');
    }
}
