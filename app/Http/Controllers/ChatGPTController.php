<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class ChatGPTController extends Controller
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('CHATGPT_API_KEY'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function askToChatGpt(Request $request)
    {
        $message = $request->data;
        $message = $message . ', yêu cầu là: viết chuẩn SEO, hơn 3000 từ và   hãy trả về cho tôi theo kiểu html , ví dụ tiêu đề thì h2, các mục thì h3, nội dung trong đó thì h5, phần nào quan trọng thì cho strong in đậm ( tôi chỉ cần nội dung trong thẻ body ,  không cần các thứ khác ở ngoài, kể cả thẻ body) ';
        $response = $this->httpClient->post('chat/completions', [
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'system', 'content' => 'You are'], ['role' => 'user', 'content' => $message]],
            ],
        ]);
        $decodedResponse = json_decode($response->getBody(), true)['choices'][0]['message']['content'];
        $formattedContent = nl2br($decodedResponse);

        return $formattedContent;
    }
}
