<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request)
    {
        $query = ContactMessage::query();

        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->latest('created_at')->paginate(15)->withQueryString();

        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Display the specified message.
     */
    public function show(ContactMessage $message)
    {
        if (! $message->is_read) {
            $message->markAsRead();
        }
        return view('admin.contact-messages.show', compact('message'));
    }

    /**
     * Toggle read/unread state.
     */
    public function toggleRead(ContactMessage $message)
    {
        $message->is_read = ! $message->is_read;
        $message->save();
        return Redirect::back()->with('success', 'Message status updated.');
    }

    /**
     * Remove the specified message.
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return Redirect::back()->with('success', 'Message deleted.');
    }
}
?>
