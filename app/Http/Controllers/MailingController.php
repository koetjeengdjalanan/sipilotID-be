<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Libraries\ApiResponse;
use Illuminate\Support\Facades\Mail;

class MailingController extends Controller
{
    /**
     * Send Mail Request to STMP Server
     *
     * @param SendMailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMail(SendMailRequest $request): \Illuminate\Http\JsonResponse
    {
        $res = Mail::html($request->validated()['body'], fn($mail) =>
            $mail->to($request->validated()['mail'])->subject($request->validated()['subject'])
        );
        return ApiResponse::success('', $res);
    }
}
