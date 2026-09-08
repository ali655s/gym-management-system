<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BranchController extends Controller
{
    /**
     * Display a listing of branches with search and pagination.
     */
    public function index(Request $request): View
    {
        $query = Branch::withCount(['membershipPlans', 'gymClasses', 'members']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $branches = $query->latest()->paginate(10)->withQueryString();

        return view('admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new branch.
     */
    public function create(): View
    {
        return view('admin.branches.create');
    }

    /**
     * Store a newly created branch in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('map_link')) {
            $mapLink = trim($request->map_link);
            if (!preg_match('~^(?:f|ht)tps?://~i', $mapLink)) {
                $request->merge(['map_link' => 'https://' . $mapLink]);
            }
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'map_link' => ['nullable', 'url', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'map_link.url' => 'The map link must be a valid URL (e.g. https://maps.google.com/?q=...)',
            'image.max' => 'The image size may not exceed 2MB.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('branches', 'public');
        }

        Branch::create($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch created successfully!');
    }

    /**
     * Show the form for editing the specified branch.
     */
    public function edit(Branch $branch): View
    {
        return view('admin.branches.edit', compact('branch'));
    }

    /**
     * Update the specified branch in storage.
     */
    public function update(Request $request, Branch $branch): RedirectResponse
    {
        if ($request->filled('map_link')) {
            $mapLink = trim($request->map_link);
            if (!preg_match('~^(?:f|ht)tps?://~i', $mapLink)) {
                $request->merge(['map_link' => 'https://' . $mapLink]);
            }
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'map_link' => ['nullable', 'url', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'map_link.url' => 'The map link must be a valid URL (e.g. https://maps.google.com/?q=...)',
            'image.max' => 'The image size may not exceed 2MB.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($branch->image && Storage::disk('public')->exists($branch->image)) {
                Storage::disk('public')->delete($branch->image);
            }
            $validated['image'] = $request->file('image')->store('branches', 'public');
        }

        $branch->update($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch updated successfully!');
    }

    /**
     * Remove the specified branch from storage.
     */
    public function destroy(Branch $branch): RedirectResponse
    {
        if ($branch->image && Storage::disk('public')->exists($branch->image)) {
            Storage::disk('public')->delete($branch->image);
        }

        $branch->delete();

        return redirect()->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully!');
    }
}
