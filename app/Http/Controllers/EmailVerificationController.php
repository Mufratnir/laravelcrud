<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\ConfirmMail;
use App\Models\User;

class EmailVerificationController extends BaseController
{
    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'Email already verified'
            ], 400);
        }

        $user->mail_token = Str::random(64);
        $user->save();

        $user->notify(new ConfirmMail($user));

        return response()->json([
            'message' => 'Verification email resent'
        ]);
    }

   public function verifyEmail($token)
   
   {
    $frontendUrl = 'http://localhost:5173/EmailVerified?status=success';
    $user = User::where('mail_token', $token)->first();

    if(!$user) {
        return $this->SendError('Invalid token', [], 404);
    }

    $user->email_verified_at = now();
    $user->mail_token = null;
    $user->save();

    return redirect($frontendUrl);
   }
}
