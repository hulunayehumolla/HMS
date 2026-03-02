<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Storage;
use App\Models\FoodMenu;

class WelcomeController extends Controller
{
    

   public function welcome()
    {
      

        return view('welcome');
    }

   
}
