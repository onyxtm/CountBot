<?php
/**
 * Created by PhpStorm.
 * User: Morteza Bagher Telegram id : @mench
 * Date: 11/12/2016
 * Time: 09:19 PM
 */

define('API_KEY','XXX:XXX');

function bridge($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

function rp($Number){
    $Rand = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $Number);
    return $Rand;
}

$update = json_decode(file_get_contents('php://input'));
$txt = $update->message->text;
$chat_id = $update->message->chat->id;
$message_id = $update->message->message_id;
$channel_forward = $update->channel_post->forward_from;
$channel_text = $update->channel_post->text;
$from = $update->message->from->id;


$time = file_get_contents("http://api.bridge-ads.ir/td?td=time");
$date = file_get_contents("http://api.bridge-ads.ir/td?td=date");

$channeluse = "@CHANNELUSERNAME";

if ($txt == "/start"){
    bridge("sendMessage",[
        'chat_id'=>$chat_id,
        'text'=>'سلام دوست عزیز من 👮🏻
پیام خود را ارسال کنید تا به صورت 👁‍🗨 (ویو) دریافت کنید.
ساخته شده توسط : <code>@mench</code>
➖➖➖➖➖➖➖
Hello My Friend 👮🏻
Message Send And Back to 👁‍🗨 (sin) Message 

Created By : <code>@mench</code>',
        'parse_mode'=>"HTML",
        'reply_markup'=>json_encode(['inline_keyboard'=>[
            [['text'=>'Creator | سازنده' ,'url'=>'telegram.me/mench']],
            [['text'=>'Share Bot | اشتراک ربات' ,'switch_inline_query'=>'']]
        ]])
    ]);
}else {
    bridge("forwardMessage", [
        'chat_id' => $channeluse,
        'from_chat_id' => $chat_id,
        'message_id' => $message_id
    ]);
}
if (isset($update->channel_post->forward_from)) {
    $idfor = $update->channel_post->forward_from->id;
    bridge("forwardMessage", [
        'chat_id' => $idfor,
        'from_chat_id' => $channeluse,
        'message_id' => $update->channel_post->message_id
    ]);
}


$first_name = $update->message->chat->first_name;
bridge('answerInlineQuery',[
    'inline_query_id'=>$update->inline_query->id,
    'results'=>json_encode([[
        'type'=>'article',
        'id'=>base64_encode(1),
        'title'=>'Banner | بنر',
        'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"سلام دوست من 😊
            دوستان شما از حالت مخفی برنامه های پیشرفته تلگرام استفاده میکنند و نمیتوانید بفهمید که پیامتان را میبیند یا نه؟
            گروه برنامه نویسی اپکس این مشکل را حل نموده  !!!

با ربات Count Bot میتوانید یک پیام با خوردن سین یا همان ویو دریافت کنید و اگر به آن سین یکدانه اضافه شد شخص پیام شما را دیده☺️

بهترین دوستتان $first_name
➖➖➖➖➖
Hello My Friend👍
Your Friend in hidden Telegram Beta Application and Not View Your Message.

Apex Team Create Bot !!!

This Count Bot And Send Message or Giv a Sin Messaging Text and add sin By Post ☺️"],
        'reply_markup'=>[
            'inline_keyboard'=>[
                [
                    ['text'=>"Join Bot | عضویت در ربات",'url'=>'https://telegram.me/countmsgbot']
                ],
                [
                    ['text'=>"Share | اشتراک",'switch_inline_query'=>'']
                ]
            ]
        ]
    ],[
        'type'=>'article',
        'id'=>base64_encode(rand(5,555)),
        'title'=>'Channel Jockdoni | کانال جوکدونی',
        'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"برای عضویت در کانال جوکدونی از دکمه های زیر استفاده کنید.✅
➖➖➖➖➖
Join To Jockdoni Channel By Button in below✅"],
        'reply_markup'=>[
            'inline_keyboard'=>[
                [
                    ['text'=>"Join Channel | عضویت در کانال",'url'=>'https://telegram.me/ch_jockdoni']
                ],
                [
                    ['text'=>"Share | اشتراک",'switch_inline_query'=>'']
                ]
            ]
        ]
    ],[
        'type'=>'article',
        'id'=>base64_encode(rand(5,555)),
        'title'=>'Time | زمان',
        'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"امروز 📅
$date
ساعت🕕
$time
➖➖➖➖➖
Today is📅
 ".date("Y/M/D")."
The time is🕕
".date("h:i:sa")],
        'reply_markup'=>[
            'inline_keyboard'=>[
                [
                    ['text'=>"Share | اشتراک",'switch_inline_query'=>'']
                ]
            ]
        ]

    ],[
        'type'=>'article',
        'id'=>base64_encode(rand(5,555)),
        'title'=>'Random Pass 12 | رمز تصادفی 12',
        'input_message_content'=>['parse_mode'=>'HTML','message_text'=>"رمز تصادفی برای شما با 12 کاراکتر📮
".rp(12)."
➖➖➖➖➖
Rando Password 12 Charachter📮
".rp(12)],
        'reply_markup'=>[
            'inline_keyboard'=>[
                [
                    ['text'=>"Share | اشتراک",'switch_inline_query'=>'']
                ]
            ]
        ]

    ]])
]);
