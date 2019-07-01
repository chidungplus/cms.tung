<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Psr7\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\User;
use Zent\Account\Models\Account;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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
        $username = 'chidungapi';
        $password = 'matkhau1';
        $new_password = 'matkhau123';

        $client = new Client([
            //            'verify'          => storage_path('app/cert.crt'),
            //            'ssl_key'         => storage_path('app/private.pem'),
                        'allow_redirects' => true,
                        'debug'           => false,
                        'curl'            => [
                            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                        ],
                    ]);
            
                    $request = new Request(
                        'POST',
                        'http://api-garena.tk/api/changePass',
                        [
                            'Content-type' => 'application/json',
                            'profile'      => 'http://example.com/list.json',
                            'User-Agent'   => 'curl/7.24.0'
                        ],
                        '{"username":"'.$username.'",
                        "password":"'.$password.'",
                        "new_password":"'.$new_password.'",
                        "agent":"dungnc"}'
                    );
                    
                    try {
                        $response = $client->send($request);
                        $text = $response->getBody()->getContents();
                        $res = json_decode($text, true);

                        Account::handleResponse(87, $res, $new_password);

                    } catch (RequestException $e) {
                        $res = $e->getResponse()->getBody();
                        $res = json_decode($res, true);
                        
                        // dd($res);
                        Account::handleResponse(87, $res, $new_password);
                    }
    }
}
