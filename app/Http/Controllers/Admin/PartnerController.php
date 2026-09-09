<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PartnerController extends Controller
{
    /**
     * Display a listing of gym partners.
     */
    public function index(Request $request): View
    {
        $query = Partner::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $partners = $query->latest()->paginate(10)->withQueryString();

        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new partner.
     */
    public function create(): View
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created partner in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // دمج قيمة boolean صريحة للـ is_active قبل الـ Validation
        $request->merge([
            'is_active' => $request->boolean('is_active'),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'website' => ['nullable', 'url', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        Partner::create($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner brand added successfully!');
    }

    /**
     * Show the form for editing the specified partner.
     */
    public function edit(Partner $partner): View
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified partner in storage.
     */
    public function update(Request $request, Partner $partner): RedirectResponse
    {
        // دمج قيمة boolean صريحة للـ is_active قبل الـ Validation
        $request->merge([
            'is_active' => $request->boolean('is_active'),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'website' => ['nullable', 'url', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        if ($request->hasFile('logo')) {
            if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
                Storage::disk('public')->delete($partner->logo);
            }
            $validated['logo'] = $request->file('logo')->store('partners', 'public');
        }

        $partner->update($validated);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner updated successfully!');
    }

    /**
     * Remove the specified partner from storage.
     */
    public function destroy(Partner $partner): RedirectResponse
    {
        if ($partner->logo && Storage::disk('public')->exists($partner->logo)) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully!');
    }
}
