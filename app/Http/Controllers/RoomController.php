<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomHour;

class RoomController extends Controller
{

    public function getRooms(\Illuminate\Http\Request $request){
        $rooms = new Room;
        $rs = $rooms->get();
        if($rooms) return response()->json(['status' => 'success','rs' => $rs]);
        return response()->json(['status' => 'error', 'report' => "Nessun risultato trovato"]);
    }

    public function roomDetail(\Illuminate\Http\Request $request){
        $this->validate($request,['id' => 'required|integer']);
        $room = Room::find($request->id);
        if($room) return response()->json(['status' => 'success', 'rs' => $room]);
        return response()->json(['status' => 'error','report' => 'Stanza non disponibile.']);
    }

    public function getRoomHours(\Illuminate\Http\Request $request){
        $roomHour = RoomHour::find($request->id);
        if($roomHour) return response()->json(['status' => 'success', 'rs' => $roomHour]);
        return response()->json(['status' => 'error','report' => 'Orari non disponibili.']);
    }

    public function addRoom(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'name' => 'required',
            'capacity' => 'nullable|numeric',
            'fail_capacity' => 'nullable|boolean',
            'default_capacity' => 'nullable|boolean'
        ]);
        $room = Room::create([
           'name' => $request->name,
           'desc' => $request->desc,
           'capacity' => $request->capacity,
            'fail_capacity' => $request->fail_capacity,
            'default_capacity' => $request->default_capacity,
            'open_at' => $request->open_at,
            'close_at' => $request->close_at
        ]);
        if($room) return response()->json(['status' => 'success','id' => $room->id]);
        return response()->json(['status' => 'error', 'report' => "C'è stato un errore nella creazione della stanza. Riprova più tardi o contatta l'assistenza."]);
    }

    public function updateRoom(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'id' => 'required|integer'
        ]);
        $room = Room::find($request->id);

        $room->name = $request->name ?? $room->name;
        $room->desc = $request->desc ?? $room->desc;
        $room->capacity = $request->capacity ?? $room->capacity;
        $room->fail_capacity = $request->fail_capacity ?? $room->fail_capacity;
        $room->default_capacity = $request->default_capacity ?? $room->default_capacity;
        $room->open_at = $request->open_at ?? $room->open_at;
        $room->close_at = $request->close_at ?? $room->close_at;
        if($room->save()){
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error','report' => "C'è stato un errore nella modifica della stanza. Riprova più tardi o contatta l'assistenza"]);

    }

    public function removeRoom(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'id' => 'required|integer'
        ]);
        $room = Room::find($request->id);
        if($room->delete()) return response()->json(['status' => 'success']);
        return response()->json(['status' => 'error', 'report' => "C'è stato un errore nella cancellazione della stanza. Riprova più tardi o contatta l'assistenza."]);
    }

    public function addDayHour(\Illuminate\Http\Request $request){
        $this->validate($request,[
           'room_id' => 'required|integer',
           'day' => 'required|integer',
           'hour_start' => 'required',
            'capacity' => 'nullable|integer',
            'fail_capacity' => 'nullable|boolean',
            'bind_hours' => 'nullable|boolean',
            'prev_confirmation' => 'nullable|boolean'
        ]);
        $roomHour = RoomHour::create([
            'room_id' => $request->room_id,
            'day' => $request->day,
            'hour_start' => $request->hour_start,
            'hour_end' => $request->hour_end,
            'max_time' => $request->max_time,
            'capacity' => $request->capacity,
            'fail_capacity' => $request->fail_capacity,
            'bind_hours' => $request->bind_hours,
            'prev_confirmation' => $request->prev_confirmation,
            'status' => $request->status ?? 'pend_creation'
        ]);
        if($roomHour) return response()->json(['status' => 'success']);
        return response()->json(['status' => 'error', 'report' => "C'è stato un errore nell'aggiunta di un nuovo orario. Riprova più tardi o contatta l'assistenza"]);
    }

    public function updateDayHour(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'id' => 'required|integer'
        ]);
        $roomHour = RoomHour::find($request->id);

        if($roomHour){
            $roomHour->room_id = $request->room_id ?? $roomHour->room_id;
            $roomHour->day = $request->day ?? $roomHour->day;
            $roomHour->hour_start = $request->hour_start ?? $roomHour->hour_start;
            $roomHour->hour_end = $request->hour_end ?? $roomHour->hour_end;
            $roomHour->max_time = $request->max_time ?? $roomHour->max_time;
            $roomHour->capacity = $request->capacity ?? $roomHour->capacity;
            $roomHour->fail_capacity = $request->fail_capacity ?? $roomHour->fail_capacity;
            $roomHour->bind_hours = $request->bind_hours ?? $roomHour->bind_hours;
            $roomHour->prev_confirmation = $request->prev_confirmation ?? $roomHour->prev_confirmation;
            $roomHour->status = $request->status ?? $roomHour->status;
            if($roomHour->save()) return response()->json(['status' => 'success','id' => $roomHour->id]);
            return response()->json(['status' => 'error', 'report' => "C'è stato un errore nella modifica di un orario. Riprova più tardi o contatta l'assistenza"]);

        }
        return response()->json(['status' => 'error','report' => "Non è stata trovata la stanza dove applicare la modifica"]);
    }

    public function removeDayHour(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'id' => 'required|integer'
        ]);
        $roomHour = RoomHour::find($request->id);
        if($roomHour) {
            if($roomHour->delete()) return response()->json(['status' => 'success']);
            return response()->json(['status' => 'error', 'report' => "C'è stato un errore nella cancellazione di un orario. Riprova più tardi o contatta l'assistenza"]);
        }
        return response()->json(['status' => 'error','report' => "Non è stata trovata la stanza da cancellare"]);
    }

}
