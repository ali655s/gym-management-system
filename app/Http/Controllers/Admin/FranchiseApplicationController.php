<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FranchiseApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FranchiseApplicationController extends Controller
{
    /**
     * Display a listing of franchise applications with search and filtering.
     */
    public function index(Request $request): View
    {
        $query = FranchiseApplication::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $applications = $query->latest('created_at')->paginate(15)->withQueryString();

        return view('admin.franchise-applications.index', compact('applications'));
    }

    /**
     * Display the specified franchise application.
     */
    public function show(FranchiseApplication $application): View
    {
        return view('admin.franchise-applications.show', compact('application'));
    }

    /**
     * Update the status of the franchise application (e.g. approve, reject, reviewed).
     */
    public function updateStatus(Request $request, FranchiseApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,approved,rejected',
        ]);

        $application->update(['status' => $validated['status']]);

        return redirect()->back()
            ->with('success', "Application #{$application->id} status updated to " . ucfirst($application->status) . ".");
    }

    /**
     * Remove the specified franchise application.
     */
    public function destroy(FranchiseApplication $application): RedirectResponse
    {
        $application->delete();

        return redirect()->route('admin.franchise-applications.index')
            ->with('success', 'Franchise application deleted successfully.');
    }
}
