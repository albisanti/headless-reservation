<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomHour;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

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

    public function getAllReservations(\Illuminate\Http\Request $request){
        $reservations = DB::table('reservations');
        if(!empty($request->date)) {
            $reservations->where('date_reserved', '=', $request->date);
        } else {
            $reservations->where('date_reserved', '>', date('Y-m-d'));
        }
        $rs = $reservations->get();
        if($rs) return response()->json(['status' => 'success','rs' => $rs]);
        return response()->json(['status' => 'error', 'report' => 'Non è stata trovata nessuna prenotazione']);
    }

    public function getRoomsReservations(\Illuminate\Http\Request $request){
        $roomHours = RoomHour::where('room_id',$request->room_id)->get();
        $reservations = [];
        foreach ($roomHours as $roomHour) {
            $rs = $roomHour->reservations()->get();
            if($rs) $reservations[$roomHour->hour_start] = $rs;
        }
        if($reservations) return response()->json(['status' => 'success', 'rs' => $reservations]);
        return response()->json(['status' => 'error','report' => 'Nessuna prenotazione trovata per la stanza']);
    }

    public function getMyReservations(\Illuminate\Http\Request $request){
        $user = User::find(Auth::id());
        try {
            $reservations = $user->reservations()->get();
            if ($reservations) return response()->json(['status' => 'success', 'rs' => $reservations]);
            return response()->json(['status' => 'error', 'report' => 'Nessuna prenotazione trovata per l\'utente.']);
        } catch (Exception $e){
            return response()->json(['status' => 'error', 'report' => 'Nessuna prenotazione trovata per l\'utente. Se pensi che questo sia un errore, contatta l\'assistenza.']);
        }
    }

    public function getUserReservations(\Illuminate\Http\Request $request){
        $user = User::find($request->id);
        $reservations = $user->reservations()->get();
        if($reservations) return response()->json(['status' => 'success', 'rs' => $reservations]);
        return response()->json(['status' => 'error','report' => 'Nessuna prenotazione trovata per l\'utente.']);
    }

    public function confirmReservation(\Illuminate\Http\Request $request){
        if($request->status !== 'confirm' && $request->status !== 'refuse') return response()->json(["status" => "error", "report" => "Azione non disponibile"],400);

        $reservation = Reservation::find($request->id);
        if($reservation){
            $reservation->status = $request->status === "confirm" ? "active" : "canceled";
            if($reservation->save()) return response()->json(['status' => 'success']);
            return response()->json(['status' => 'error', "report" => "Non è stato possibile accettare la prenotazione. Si prega di riprovare più tardi"]);
        }
        return response()->json(['status' => 'error', 'report' => "La prenotazione ricercata non è disponibile per l'accettazione"]);
    }

    public function deleteReservation(\Illuminate\Http\Request $request){
        $reservation = Reservation::find($request->id);
        if($reservation){
            $reservation->delete();
            return response()->json(["status" => "success"]);
        }
        return response()->json(["status" => "error", "report" => "Prenotazione non trovata"]);
    }

}
