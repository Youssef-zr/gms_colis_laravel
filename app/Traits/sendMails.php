<?php

namespace App\Traits;

use App\Mail\SendReplyToDep;
use App\Models\Priorite;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

trait sendMails
{
    public static function newMail($newTicket, $newReplyFrom = null)
    {
        // client and department service email
        $MailsTo[0] = Service::find($newTicket->IDService)->email;
        $MailsTo[1] = $newTicket->client->user->email;
        $MailsTo[2] = 'yn-neinaa@hotmail.com';

        // dd($MailsTo);
        // fetch some data from ticket
        $mailData = [
            "from" => $newReplyFrom != null ? $newReplyFrom : Auth::user()->name,
            "ticket_id" => $newTicket->id,
            "show_ticket_link" => adminUrl('tickets/' . $newTicket->id),
            "subject" => $newTicket->objet_ticket,
            "priority" => Priorite::whereId($newTicket->IDPriorite)->first()->libelle,
            "status" => "en cours",
        ];

        Mail::to($MailsTo)->send(new SendReplyToDep($mailData));
    }
}
