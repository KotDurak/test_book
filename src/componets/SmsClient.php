<?php

namespace app\componets;

use yii\base\Component;
use yii\data\ArrayDataProvider;

class SmsClient extends Component
{
    public $apiUrl;
    public $apiKey;



    public function sendBatch(array $phones, string $text)
    {
        $data = [];

        foreach ($phones as $phone) {
            $data[] = [
                'to'   => $phone,
                'text'  => $text,
            ];
        }

        $this->sendRequest($data);
    }


    private function sendRequest(array $send): string|false
    {
        try {
            return file_get_contents($this->apiUrl, false, stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-Type: application/json\r\n",
                    'content' => json_encode([
                        'apikey'    => $this->apiKey,
                        'send'  => $send,
                    ])
                ]
            ]));
        } catch (\Throwable $ex) {
            \Yii::error('Ошибка во время смс рассыллки: ' . $ex->getMessage());
            return false;
        }
    }
}