<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactInquiryReplyMail;

class ContactInquiryController extends Controller
{
    /** List all contact form inquiries */
    public function index(Request $request)
    {
        $search  = $request->input('search');
        $status  = $request->input('status');

        $inquiries = ContactInquiry::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")
                                        ->orWhere('email', 'like', "%{$search}%"))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $unreadCount = ContactInquiry::where('status', 'unread')->count();

        return view('admin.contact-inquiries.index', compact('inquiries', 'unreadCount'));
    }

    /** Show single inquiry and mark as read */
    public function show(ContactInquiry $contactInquiry)
    {
        if ($contactInquiry->status === 'unread') {
            $contactInquiry->update(['status' => 'read', 'read_at' => now()]);
        }
        $contactInquiry->load('replies');
        return view('admin.contact-inquiries.show', compact('contactInquiry'));
    }

    /** Store a reply and send email */
    public function storeReply(Request $request, ContactInquiry $contactInquiry)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Save to database as admin reply
        $contactInquiry->replies()->create([
            'message' => $request->message,
            'is_admin' => true
        ]);

        // Send Email to the client
        Mail::to($contactInquiry->email)->send(new ContactInquiryReplyMail($contactInquiry, $request->message));

        $contactInquiry->update(['status' => 'replied']);

        return back()->with('success', 'Reply sent successfully via email.');
    }

    /** Mark as replied */
    public function markReplied(ContactInquiry $contactInquiry)
    {
        $contactInquiry->update(['status' => 'replied']);
        return back()->with('success', 'Marked as replied.');
    }

    /** Delete inquiry */
    public function destroy(ContactInquiry $contactInquiry)
    {
        $contactInquiry->delete();
        return redirect()->route('admin.contact-inquiries.index')
                         ->with('success', 'Inquiry deleted.');
    }
}
