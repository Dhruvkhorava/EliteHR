<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mail;
use App\Models\User;
use Carbon\Carbon;

class MailController extends Controller
{
    public function index()
    {
        $mails = Mail::inbox(auth()->id())->with('sender')->latest()->paginate(20);
        return view('admin.mail.inbox', [
            'mails' => $mails,
            'title' => 'Inbox',
            'catName' => 'mail',
            'breadcrumbs' => ['Mail', 'Inbox'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function sent()
    {
        $mails = Mail::sent(auth()->id())->with('receiver')->latest()->paginate(20);
        return view('admin.mail.sent', [
            'mails' => $mails,
            'title' => 'Sent Mails',
            'catName' => 'mail',
            'breadcrumbs' => ['Mail', 'Sent'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function drafts()
    {
        $mails = Mail::drafts(auth()->id())->latest()->paginate(20);
        return view('admin.mail.drafts', [
            'mails' => $mails,
            'title' => 'Drafts',
            'catName' => 'mail',
            'breadcrumbs' => ['Mail', 'Drafts'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function trash()
    {
        $mails = Mail::trash(auth()->id())->latest()->paginate(20);
        return view('admin.mail.trash', [
            'mails' => $mails,
            'title' => 'Trash',
            'catName' => 'mail',
            'breadcrumbs' => ['Mail', 'Trash'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function compose($id = null)
    {
        $users = User::where('id', '!=', auth()->id())->get();
        $draft = null;
        if ($id) {
            $draft = Mail::where('id', $id)->where('sender_id', auth()->id())->where('is_draft', true)->first();
        }

        return view('admin.mail.compose', [
            'users' => $users,
            'draft' => $draft,
            'title' => 'Compose Mail',
            'catName' => 'mail',
            'breadcrumbs' => ['Mail', 'Compose'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required_unless:action,draft|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        $mailData = [
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_draft' => $request->action === 'draft',
        ];

        if ($request->has('mail_id')) {
            $mail = Mail::find($request->mail_id);
            if ($mail && $mail->sender_id == auth()->id() && $mail->is_draft) {
                $mail->update($mailData);
            } else {
                $mail = Mail::create($mailData);
            }
        } else {
            $mail = Mail::create($mailData);
        }

        $message = $mail->is_draft ? 'Mail saved as draft.' : 'Mail sent successfully.';
        return redirect()->route('mail.index')->with('success', $message);
    }

    public function show(Mail $mail)
    {
        // Check if user is sender or receiver
        if ($mail->sender_id != auth()->id() && $mail->receiver_id != auth()->id()) {
            abort(403);
        }

        // Mark as read if user is receiver
        if ($mail->receiver_id == auth()->id() && !$mail->is_read) {
            $mail->update([
                'is_read' => true,
                'read_at' => Carbon::now()
            ]);
        }

        return view('admin.mail.view', [
            'mail' => $mail,
            'title' => 'View Mail',
            'catName' => 'mail',
            'breadcrumbs' => ['Mail', 'View'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function destroy(Mail $mail)
    {
        $userId = auth()->id();

        if ($mail->sender_id == $userId) {
            if ($mail->is_trashed_sender) {
                // Permanently delete if already in trash
                if ($mail->receiver_id == null || $mail->is_trashed_receiver) {
                    $mail->delete();
                } else {
                    // Just hide from sender if still active for receiver
                    $mail->update(['is_trashed_sender' => true]); // This is redundant if already true, but logic for permanent delete above covers it
                }
            } else {
                $mail->update(['is_trashed_sender' => true]);
            }
        } elseif ($mail->receiver_id == $userId) {
            if ($mail->is_trashed_receiver) {
                if ($mail->is_trashed_sender) {
                    $mail->delete();
                } else {
                    $mail->update(['is_trashed_receiver' => true]);
                }
            } else {
                $mail->update(['is_trashed_receiver' => true]);
            }
        }

        return back()->with('success', 'Mail moved to trash.');
    }
}
