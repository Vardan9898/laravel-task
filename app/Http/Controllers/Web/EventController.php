<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $events = Event::all();

        return response()->json(['events' => $events]);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text' => 'required',
            'creator_id' => 'required|exists:users,id',
            'participant_ids' => 'array',
        ]);

        $event = new Event();
        $event->title = $request->input('title');
        $event->text = $request->input('text');
        $event->creator_id = $request->input('creator_id');
        $event->save();

        $participantIds = $request->input('participant_ids', []);
        $event->participants()->sync($participantIds);

        return response()->json(['message' => 'Event created successfully']);
    }
}
