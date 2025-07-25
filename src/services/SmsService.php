<?php
namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    private string $sid;
    private string $token;
    private string $from;
    private Client $client;

    public function __construct()
    {
        // Vérification de l'existence des variables d'environnement
        if (!isset($_ENV['TWILIO_SID']) || !isset($_ENV['TWILIO_TOKEN']) || !isset($_ENV['TWILIO_FROM'])) {
            // Mode développement : utiliser des valeurs par défaut
            $this->sid = 'dev_mode';
            $this->token = 'dev_mode';
            $this->from = '+0000000000';
            return;
        }
        
        $this->sid = $_ENV['TWILIO_SID'];         
        $this->token = $_ENV['TWILIO_TOKEN'];
        $this->from = $_ENV['TWILIO_FROM'];
        $this->client = new Client($this->sid, $this->token);
    }

    public function sendCode(string $to, string $code): bool
    {
        // En mode développement
        if ($_ENV['APP_ENV'] === 'development') {
            error_log("SMS simulé envoyé à $to : $code");
            return true;
        }
        
        try 
        {
            $this->client->messages->create($to,
            [
                'from' => $this->from,
                'body' => "Votre code secret MAXIT est : $code"
            ]
        );
            return true;
        } catch (\Exception $e) {
            error_log("Erreur SMS: " . $e->getMessage());
            return false;
        }
    }
}
