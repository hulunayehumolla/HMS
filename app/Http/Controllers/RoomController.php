<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\RoomRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(10);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(RoomRequest $request)
    {
        DB::transaction(function () use ($request) {
            $photos = [];
            if ($request->hasFile('room_photos')) {
                foreach ($request->file('room_photos') as $photo) {
                    $photos[] = $photo->store('rooms', 'public');
                }
            }

            Room::create([
                ...$request->validated(),
                'room_photos' => $photos,
            ]);
        });

        return redirect()->route('rooms.index')->with('success', 'Room created successfully');
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(RoomRequest $request, Room $room)
    {
        try {
            DB::transaction(function() use ($request, $room){
                $photos = $room->room_photos ?? [];

                // Add new uploaded photos
                if ($request->hasFile('room_photos')) {
                    foreach ($request->file('room_photos') as $photo) {
                        $photos[] = $photo->store('rooms', 'public');
                    }
                }

                $room->update([
                    ...$request->validated(),
                    'room_photos' => $photos,
                ]);
            });

            if ($request->ajax()) {
                return response()->json(['success' => 'Room updated successfully']);
            }

            return redirect()->route('rooms.index')->with('success', 'Room updated successfully');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Failed to update room'], 500);
            }
            return back()->withErrors(['error' => 'Failed to update room']);
        }
    }

    public function destroy(Room $room)
    {
        DB::transaction(function () use ($room) {
            if ($room->room_photos) {
                foreach ($room->room_photos as $photo) {
                    Storage::disk('public')->delete($photo);
                }
            }
            $room->delete();
        });

        return back()->with('success', 'Room deleted successfully');
    }

    public function deletePhoto(Room $room, $index)
    {
        $photos = $room->room_photos ?? [];
        if (isset($photos[$index])) {
            $photo = $photos[$index];
            if (Storage::disk('public')->exists($photo)) {
                Storage::disk('public')->delete($photo);
            }

            array_splice($photos, $index, 1);
            $room->update(['room_photos' => $photos]);

            return response()->json(['success' => 'Photo removed successfully']);
        }

        return response()->json(['error' => 'Photo not found'], 404);
    }
}
