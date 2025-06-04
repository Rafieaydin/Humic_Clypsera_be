<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;

class FcmController extends Controller
{
    public function sendNotificationFirebase()
    {
        $firebase = app('firebase.messaging');
        $message = [
            'data' => [
                'title' => 'Test Notification',
                'body' => 'This is a test notification from Laravel',
            ],
        ];
        $topic = 'dqwd'; // Replace with your topic name
        $message = CloudMessage::withTarget('topic', $topic)
            ->withData($message['data'])
            ->withNotification([
                'title' => $message['data']['title'],
                'body' => $message['data']['body'],
            ]);
        $response = $firebase->send($message);
        dd($response);
        return "berhasil mengirim notifikasi";
    }
}
