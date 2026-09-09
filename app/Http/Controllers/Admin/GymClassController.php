<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\GymClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GymClassController extends Controller
{
    /**
     * Display a listing of gym classes.
     */
    public function index(Request $request): View
    {
        $query = GymClass::with('branch');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('trainer_name', 'like', "%{$search}%")
                    ->orWhere('days', 'like', "%{$search}%");
            });
        }

        $classes = $query->latest()->paginate(10)->withQueryString();
        $branches = Branch::orderBy('name')->get();

        return view('admin.gym-classes.index', compact('classes', 'branches'));
    }

    /**
     * Show the form for creating a new class.
     */
    public function create(): View
    {
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('admin.gym-classes.create', compact('branches'));
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'is_active' => $request->boolean('is_active'),
        ]);

        $validated = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'trainer_name' => ['required', 'string', 'max:255'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'days' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        GymClass::create($validated);

        return redirect()->route('admin.gym-classes.index')
            ->with('success', 'Class created successfully!');
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(GymClass $gymClass): View
    {
        $branches = Branch::orderBy('name')->get();
        $class = $gymClass; // تم تعريفه باسم $class ليوافق المكتوب في ملف الـ Blade

        return view('admin.gym-classes.edit', compact('class', 'branches'));
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, GymClass $gymClass): RedirectResponse
    {
        $request->merge([
            'is_active' => $request->boolean('is_active'),
        ]);

        $validated = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'trainer_name' => ['required', 'string', 'max:255'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'days' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        $gymClass->update($validated);

        return redirect()->route('admin.gym-classes.index')
            ->with('success', 'Class updated successfully!');
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(GymClass $gymClass): RedirectResponse
    {
        $gymClass->delete();

        return redirect()->route('admin.gym-classes.index')
            ->with('success', 'Class deleted successfully!');
    }
}
