<?php

class Captcha
{
    private string $serverKey;

    public function __construct(string $serverKey)
    {
        $this->serverKey = $serverKey;
    }

    public function verify(?string $token, ?string $userIp): bool
    {
        if(empty($token)){
            return false;
        }

        $url = 'https://smartcaptcha.yandexcloud.net/validate';
        $data = [
            'secret' => $this->serverKey,
            'token' => $token,
            'ip' => $userIp
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true); // Указываем, что это POST-запрос
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Данные запроса
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Чтобы curl_exec вернул результат, а не вывел его на экран
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Ограничиваем время ожидания ответа 5 секундами

        $response = curl_exec($ch);
        curl_close($ch);

        if (empty($response)) {
            return false;
        }
         $responseData = json_decode($response, true);
         return isset($responseData['status']) && $responseData['status'] === 'ok';
    }
}