<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        Mail::raw("Od: {$data['name']} ({$data['email']})\n\nSpráva:\n{$data['message']}", function ($msg) {
            $msg->to('info@kaviarennakorze.sk')
                ->subject('Nová správa z webu');
        });

        return back()->with('success', 'Správa bola úspešne odoslaná!');
    }
}

