<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Client;

// use Webklex\IMAP\Facades\Client;
// use Webklex\PHPIMAP\Client;
// use Webklex\IMAP\Client;

class EmailController extends Controller
{
    public function __construct() {
        $this->emails = new Email;
    }

    public function index()
    {
        $emails = $this->emails->orderBy('received_date', 'desc')->paginate(20);

        return view( 'email.index' )->with('emails', $emails);
    }

    public function save_mails()
    {
        if ( ! empty( $fetch_emails = $this->fetch_mails() ) ) {
            try {
                $count_new_mails = count($fetch_emails);
                $this->emails->insert( $fetch_emails );

                return redirect('/')->with('success', "Fetched new {$count_new_mails} emails");
            } catch (\Throwable $e) {
                return redirect('/')->with('error', $e->getMessage());
            }
        }
        
        return redirect('/')->with( 'success', 'No new emails' );
    }

    private function fetch_mails()
    {   
        // Email Configuration
        $client_manager = new ClientManager('../config/imap.php');
        $client_manager = new ClientManager($options = []);

        $client = $client_manager->make([
            'host'          => 'imap.googlemail.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'protocol'      => 'imap',
            'username'      => env('FETCH_EMAIL_USERNAME', ''),
            'password'      => env('FETCH_EMAIL_PASSWORD', '')
        ]);
        
        $client->connect();

        $folders = $client->getFolders();

        $email_count         = $this->emails->get()->count();
        $messages_arr        = [];
        $old_messages_id_arr = [];

        foreach ($folders as $key => $folder) {
            $messages = [];

            if ( $email_count == 0 ) {
                $messages = $folder->messages()->all()->get();
            } else {
                $latest_mail = $this->emails->orderBy('received_date', 'desc')->first();
                $set_date    = date( 'd.m.Y', strtotime( $latest_mail->received_date ) );
                $messages    = $folder->query()->since($set_date)->get();
                $mails       = $this->emails->whereDate('received_date', '>=', date( 'Y-m-d', strtotime( $latest_mail->received_date ) ) )->get();

                if ( ! empty( $mails ) ) {
                    foreach ($mails as $key => $mail) {
                        $old_messages_id_arr [] = [
                            'email_id' => $mail->email_id,
                        ];
                    }
                }
            }
            
            if ( ! empty( $messages ) ) {
                foreach ($messages as $key => $message) {
                    $messages_arr [] = [
                        'email_id' => $message->getUid(),
                        'sender' => $message->getFrom()[0]->mail,
                        'title' => $message->getSubject()[0],
                        'content' => $message->getBodies()['text'],
                        'received_date' => $message->getDate()[0]->timezone('Asia/Manila')->toDateTimeString(),
                    ];
                }
            }
        }

        if ( ! empty( $old_messages_id_arr ) && ! empty( $messages_arr ) ) {
            if ( ! empty( $messages_arr = $this->remove_duplicates( $old_messages_id_arr, $messages_arr ) ) ) {
                return $messages_arr;
            }
        }

        return $messages_arr;
    }

    public function remove_duplicates($old_mails = [], $fetched_mails = [])
    {
        if ( ! empty($old_mails) && ! empty($fetched_mails) ) {
            foreach ($old_mails as $old_mail) {
                $exist_email_id = $old_mail['email_id'];

                foreach ($fetched_mails as $key => $fetched_mail) {
                    if ( $fetched_mail['email_id'] == $exist_email_id ) {
                        unset( $fetched_mails[$key] );
                        break;
                    }
                }
            }

            return $fetched_mails;
        }

        return [];
    }
}
