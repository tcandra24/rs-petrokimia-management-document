<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

// Traits
use App\Traits\General\BreadcrumbsTrait;

class NotificationController extends Controller
{
    use BreadcrumbsTrait;

    public function index()
    {
        $breadcrumbs = $this->setBreadcrumbs('notification', 'index');

        $user = Auth::user();
        $unreadNotification = $user->unreadNotifications;

        return view('notification.index', ['breadcrumbs' => $breadcrumbs, 'notifications' => $unreadNotification]);
    }

    public function show($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if($notification){
            $notification->markAsRead();

            $url = $notification->data['link'];
            return redirect($url);
        }

        toastr()->error('Notifikasi tidak ditemukan');
        return back();
    }
}
