<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification; 
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function showValidatedNotifications(Request $request)
    {
        // Récupérer toutes les notifications validées pour l'utilisateur
        $notifications = auth()->user()->notifications()->where('type', 'App\Notifications\CommandeValideeNotification')->get();
    
        return view('notifications.validated', compact('notifications'));
    }
    


    public function showReceivedNotifications(Request $request)
{
    // Récupérer toutes les notifications reçues pour l'utilisateur
    $notifications = auth()->user()->notifications()->where('type', 'App\Notifications\NotificationProprietaireCommande')->get();

    return view('notifications.received', compact('notifications'));
}


    public function countUnread()
    {
        $count = Auth::user()->unreadNotifications->count();
        return response()->json(['count' => $count]);
    }

    public function markAsRead($id)
{
    // Récupérer la notification de l'utilisateur
    $notification = Auth::user()->notifications()->find($id);

    if ($notification) {
        // Marquer la notification comme lue
        $notification->markAsRead();
    }

    // Rediriger vers la page des notifications validées (ou la page appropriée)
    return redirect()->back()->with('success', ' notification maintenant lue.');
}


    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Toutes les notifications sont maintenant lues.');
    }
}

