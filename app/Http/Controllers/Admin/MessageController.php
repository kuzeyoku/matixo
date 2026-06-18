<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Mail\ContactReply;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index(Request $r)
    {
        $items = ContactMessage::query()
            ->when($r->search, fn($q, $s) => $q->where(fn($x) => $x
                ->where('name', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")
                ->orWhere('subject', 'like', "%{$s}%")))
            ->when(isset($r->is_read) && $r->is_read !== '', fn($q) => $q->where('is_read', (bool) $r->is_read))
            ->latest()->paginate(25)->withQueryString();

        return view('admin.messages.index', ['items' => $items, 'filters' => $r->all()]);
    }

    public function show(int $id)
    {
        $item = ContactMessage::findOrFail($id);
        $item->markAsRead();
        return view('admin.messages.show', ['item' => $item]);
    }

    public function reply(Request $r, int $id)
    {
        $data = $r->validate([
            'subject' => 'required|string|max:200',
            'body'    => 'required|string|max:10000',
        ]);

        $item = ContactMessage::findOrFail($id);

        try {
            Mail::to($item->email)->send(new ContactReply($item, $data['subject'], $data['body']));
        } catch (\Throwable $e) {
            return back()->with('error', 'Mail gönderilemedi: ' . $e->getMessage())->withInput();
        }

        $item->update([
            'replied_at'    => now(),
            'reply_content' => $data['body'],
        ]);

        ActivityLogger::log('reply', $item, null, 'Mesaja cevap gönderildi');
        return back()->with('success', 'Cevap gönderildi.');
    }

    public function destroy(int $id)
    {
        $m = ContactMessage::findOrFail($id);
        ActivityLogger::log('delete', $m);
        $m->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Mesaj silindi.');
    }
}
