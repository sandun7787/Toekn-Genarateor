<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon; // Add this line

class TokenController extends Controller
{
    public function index(Request $request)
    {
        // Get the current date using Carbon
        $currentDate = Carbon::now()->toDateString(); // YYYY-MM-DD format

        // Check if a token is already stored in session
        if (!$request->session()->has('date') || $request->session()->get('date') !== $currentDate) {
            // If the date has changed, reset the token to 1
            $request->session()->put('date', $currentDate);
            $request->session()->put('token', 1);
        }

        // Get the current token from session
        $token = $request->session()->get('token');
        
        // Return the view with the current token and date
        return view('token.index', compact('token', 'currentDate'));
    }

    public function printToken(Request $request)
    {
        // Get the current token
        $token = $request->session()->get('token');
        
        // Increase the token number for the next person
        $newToken = $token + 1;
        
        // Store the updated token in the session
        $request->session()->put('token', $newToken);
        
        // Return the token number to be printed and the new token
        return response()->json(['token' => $token, 'newToken' => $newToken]);
    }
}
