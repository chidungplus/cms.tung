<?php

namespace App\Jobs;

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

class ChangePasswordGarena implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $username;
    protected $password;
    protected $new_password;
    protected $agent;

    /**
     * Create a new job instance.
     *
     * @param Account $username
     */
    public function __construct($id, $username, $password, $new_password, $agent)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->new_password = $new_password;
        $this->agent = $agent;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $username = str_replace(" ", "", $this->username);
        $password = str_replace(" ", "", $this->password);
        $new_password = str_replace(" ", "", $this->new_password);
        

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
            
            Account::handleResponse($this->id, $res, $this->new_password);

        } catch (RequestException $e) {
            $res = $e->getResponse()->getBody();
            $res = json_decode($res, true);
            
            Account::handleResponse($this->id, $res, $this->new_password);
        }
    }
}
