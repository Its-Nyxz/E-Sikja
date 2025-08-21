<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->notifications();

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'read') {
                $query->where('read', true);
            } else {
                $query->where('read', false);
            }
        }else{
            // $query->where('read', false);
        }

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', 'LIKE', '%' . $request->type . '%');
        }

        $notifications = $query->latest()->paginate(10);

        $data = [
            'title' => 'Notifikasi',
            'notifications' => $notifications
        ];

        return view('cms.notification.index')->with($data);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai telah dibaca');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->each->markAsRead();

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai telah dibaca');
    }

    /**
     * Remove the specified notification.
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus');
    }
}