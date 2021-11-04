<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function addReservation(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'room_hour_id' => 'required|integer',
            'hour_start' => 'required',
            'date_reserved' => 'required'
        ]);

        $reservation = new Reservation;
        $reservation->room_hour_id = $request->room_hour_id;
        $reservation->user_id = Auth::id();
        $reservation->hour_start = $request->hour_start;
        $reservation->hour_end = $request->hour_end;
        $reservation->eta = $request->eta;
        $reservation->status = 'to_approve';
        $reservation->date_reserved = $request->date_reserved;
        if($reservation->save()) return response()->json(['status' => 'success']);
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile salvare la prenotazione. Riprovare più tardi']);
    }

    public function getRoomsReservations(\Illuminate\Http\Request $request){
        $room = Room::find($request->room_id);
        $reservations = $room->reservations()->get();
        if($reservations) return response()->json(['status' => 'success', 'rs' => $reservations]);
        return response()->json(['status' => 'error','report' => 'Nessuna prenotazione trovata per la stanza']);
    }

    public function getMyReservations(\Illuminate\Http\Request $request){
        $user = User::find(Auth::id());
        $reservations = $user->reservations()->get();
        if($reservations) return response()->json(['status' => 'success', 'rs' => $reservations]);
        return response()->json(['status' => 'error','report' => 'Nessuna prenotazione trovata per l\'utente.']);
    }

    public function getUserReservations(\Illuminate\Http\Request $request){
        $user = User::find($request->id);
        $reservations = $user->reservations()->get();
        if($reservations) return response()->json(['status' => 'success', 'rs' => $reservations]);
        return response()->json(['status' => 'error','report' => 'Nessuna prenotazione trovata per l\'utente.']);
    }

}
