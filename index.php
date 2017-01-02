<?php
/**
 * Created by @OnyxTM.
 * User: Morteza Bagher Telegram id : @mench
 * Date: 11/12/2016
 * Time: 09:19 PM
 */

define('API_KEY','XXX:XXX');

$admin = "ADMIN CHAT ID";

$channeluse = "@CHANNELUSERNAME";

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

$chatid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$msgid = $update->callback_query->message->message_id;


$btnmen = json_encode(['inline_keyboard'=>[
            [['text'=>'Creator | سازنده' ,'url'=>'telegram.me/mench']],[['text'=>'Advertising | تبلیغات' ,'callback_data'=>'ads']],
            [['text'=>'Source Bot | سورس ربات' ,'callback_data'=>'botsrc']],
            [['text'=>'Inline mode | حالت اینلاین' ,'switch_inline_query'=>'']]
        ]]);

$startmen = "سلام دوست عزیز من 👮🏻
پیام خود را ارسال کنید تا به صورت 👁‍🗨 (ویو) دریافت کنید.
ساخته شده توسط : <code>@mench</code>
➖➖➖➖➖➖➖
Hello my dear friend 👮🏻
If you send your message to 👁🗨 (View) get.
Made by: <code>@mench</code>";

$time = file_get_contents("http://api.bridge-ads.ir/td?td=time");
$date = file_get_contents("http://api.bridge-ads.ir/td?td=date");


if(preg_match('/^\/([Qq])r',$txt)){
  $strrr = str_replace("/qr","",$txt);
  $photo = file_get_contents("http://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$strrr");
  bridge('sendPhoto',[
    'chat_id'=>$chat_id,
    'photo'=>$photo,
    'caption'=>"@CountMsgBot"
  ]);
}elseif ($txt == "/start"){
    bridge("sendMessage",[
        'chat_id'=>$chat_id,
        'text'=>$startmen,
        'parse_mode'=>"HTML",
        'reply_markup'=>$btnmen
    ]);
}elseif($data == "ads"){
      bridge("editmessagetext",[
        'chat_id'=>$chatid,
        'message_id'=>$msgid,
        'text'=>"تبلیغات فارسی:

[کانال جوکدونی😊](https://telegram.me/joinchat/EzUIy0AnWqQZgiA_w-I7lA)

👈برای ثبت تبلیغ [اینجا](http://telegram.me/mench) کلیک کنید
➖➖➖➖➖
English Ad:

NULL

Sign 👈Bray ad [here](http://telegram.me/mench) Click",
        'parse_mode'=>"Markdown",
        'disaple_web_page_preview'=>true,
        'reply_markup'=>json_encode(['inline_keyboard'=>[
        [['text'=>'Home | خانه','callback_data'=>'menu']]
      ]])
    ]);
}elseif($data == "botsrc"){
      bridge("editmessagetext",[
        'chat_id'=>$chatid,
        'message_id'=>$msgid,
        'text'=>"تبلیغات فارسی:

[دریافت سورس](https://github.com/onyxtm/CountBot)
برای ساخت ربات مراحل زیر را انجام دهید
ابتدا دو ربات بسازید.
سپس توکن ربات اصلی خود را در سورس وارد نمایید.
بعد از آن فایل ربات را با توکن ربات اصلی ست کنید.
سپس ربات دوم را با فایل اصلی بدون تغییر دادن توکن درون فایل ست کنید.

دو ربات را ادمین کانال کنید و نام کاربری کانال را در فایل سورس ربات وارد کنید.

ربات شما ساخته شد😊

برای مثال توکن دو ربات برای نمونه:
ربات اصلی:
333222111:fdkjflsSDFLK:SDmdlsjkvjfjknf_FDnfjdk
ربات فرعی:
111222333:ffdslkjflksjfdKSDknfdfdvjfjknf_fdnfjdf

تو کن ربات اصلی را جایگزین XXX:XXX در index.php کنید.
 
سپس وبهوک ربات را با توکن اصلی ست کنید.

بعد از آن بدون تغییری در فایل وبهوک ربات فرعی را با فایل index.php ست کنید.

حال کانالی بسازید و دو ربات را ادمین کانال کنید.

و سپس به درون index.php رفته و بهجای @CHANNELUSERNAME آیدی کانال خود را وارد کنید.☺️

تبریک ربات شما ساخته شد.
",
        'parse_mode'=>"Markdown",
        'disaple_web_page_preview'=>true,
        'reply_markup'=>json_encode(['inline_keyboard'=>[
        [['text'=>'Home | خانه','callback_data'=>'menu']],
          [['text'=>'Source | سورس','url'=>'https://github.com/onyxtm/CountBot']]
      ]])
    ]);
}elseif($data == "menu"){
      bridge("editmessagetext",[
        'chat_id'=>$chatid,
        'message_id'=>$msgid,
        'text'=>$startmen,
        'parse_mode'=>"HTML",
        'reply_markup'=>$btnmen
    ]);
}elseif(preg_match('/^\/([Ss]tate)/',$txt) &&  $from == $admin){
    $user = file_get_contents('CountMem.txt');
    $member_id = explode("\n",$user);
    $member_count = count($member_id) -1;
    bridge('sendMessage',[
      'chat_id'=>$chat_id,
      'text'=>"👥 تعداد کاربران جدید ربات شما : $member_count",
      'parse_mode'=>'HTML'
    ]);
}elseif(preg_match('/^\/([Ss]endtoall)/',$txt) &&  $from == $admin){
    $strrrrrrrr = str_replace("/sendtoall","",$txt);
            $texttoall = $strrrrrrrr;
            $ttxtt = file_get_contents('CountMem.txt');
            $membersidd= explode("\n",$ttxtt);
            for($y=0;$y<count($membersidd);$y++){
                bridge("sendMessage", [
                  'chat_id' => $membersidd[$y], 
                  "text" => $texttoall,
                  "parse_mode" =>"HTML"
                ]);
            }
            $memcout = count($membersidd)-1;
            bridge("sendMessage", [
                  'chat_id' => $admin, 
                  "text" => "پیام شما به $memcout نفر ارسال شد.",
                  "parse_mode" =>"HTML"
                ]);
  }elseif($update->channel_post->text == "/id"){
            bridge("sendMessage", [
                  'chat_id' => $channeluse, 
                  "text" => $update->channel_post->chat->id,
                  "parse_mode" =>"HTML"
                ]);
}elseif($txt == "/id"){
            bridge("sendMessage", [
                  'chat_id' => $chat_id, 
                  "text" => $chat_id,
                  "parse_mode" =>"HTML"
                ]);
}elseif(isset($update->message->reply_to_message)){

    bridge("forwardMessage", [
        'chat_id' => $txt,
        'disable_notification'=>true,
        'from_chat_id' => $chat_id,
        'message_id' => $update->message->reply_to_message->message_id
    ]);

    bridge("sendMessage", [
       'chat_id' => $chat_id, 
       "text" => "پیام ارسای شد به $txt",
       "parse_mode" =>"HTML"
    ]);
}else {
    bridge("forwardMessage", [
        'chat_id' => $channeluse,
        'from_chat_id' => $chat_id,
        'message_id' => $message_id
    ]);
}

$user = file_get_contents('CountMem.txt');
    $members = explode("\n",$user);
    if (!in_array($chat_id,$members)){
      $add_user = file_get_contents('CountMem.txt');
      $add_user .= $chat_id."\n";
     file_put_contents('CountMem.txt',$add_user);
    }

if (isset($update->channel_post)) {
    $idfor = $update->channel_post->forward_from->id;
    bridge("forwardMessage", [
        'chat_id' => $idfor,
        'disable_notification'=>true,
        'from_chat_id' => $channeluse,
        'message_id' => $update->channel_post->message_id
    ]);
}



$first_name = $update->inline_query->from->first_name;
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
Hello my friend 😊
             Friends of stealth mode and can not understand that use advanced programs telegram see your message or not?
             Programming Group apex of the problem solved !!!

Count Bot robot can view a message or get by eating Sin Sin Ykdanh if it was added to the message you Dydh☺

Best friend $first_name"],
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
Random password with 12 characters for you 📮
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
