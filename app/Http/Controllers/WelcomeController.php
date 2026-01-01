<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class WelcomeController extends Controller
{
    public function welcome()
    {
        // Fetch all rooms and group by class
        $roomsGrouped = Room::all()->groupBy('room_class'); // No 'with', just fetch all columns

        return view('welcome', compact('roomsGrouped'));
    }
}
