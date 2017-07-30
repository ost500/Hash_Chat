<?php

namespace App\Console\Commands;

use App\PushToken;
use App\User;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class PushNotiToAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:toAll {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $message = $this->argument('message');


        $server_key = "AAAARPXG50c:APA91bFhOxsMK5CULU-GmL1si6hK9SeRFr-O6FTcWsmA2d6rEYqKyUECOMDuisdDSuq5V1PLht5VPBjwsnJjjLIYMPSMG5oEIw443jAnvLmHAHtDeycEwVazlp9g3KsEf74RB2kuN38z";
        $url = 'https://fcm.googleapis.com/fcm/send';
        $notification["body"] = $message;
        $notification["title"] = "마음의 편지 To.수원대";
        $notification["sound"] = "default";


        $tokens = PushToken::get();

        $tokenIds = array();

        /** @var PushToken $user */
        foreach ($tokens as $token) {
            $tokenIds[] = $token->token;
        }

        $fields = array(
//            "to" => "/tab/album_detail/28",
            'registration_ids' => $tokenIds,
            'data' => $notification,
            'notification' => $notification
        );
        $headers = array(
            'Authorization:key =' . $server_key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);


        print_r($result);

    }
}
