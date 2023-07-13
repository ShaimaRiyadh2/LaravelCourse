<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class GeneralNotification extends Notification
//    implements ShouldQueue
{
    use Queueable;
    public $tries = 2;
    public $timeout = 10;
    public $options;

    public function __construct($options=[]){
        array_merge([
            'content'=>"",
            'action_url'=>env("APP_URL"),//when clicking on noti
            'btn_text'=>env("APP_NAME"),
            'methods'=>['database'],//mail, slack
            'image'=>env("DEFAULT_IMAGE_AVATAR"),
        ],$options);
        $this->options=$options;

    }


    public function via($notifiable){
        return $this->options['methods'];

    }

    public function toMail($notifiable){

        return (new MailMessage)
            ->subject('You have a notification')
            ->greeting("Hello")
            ->line($this->options['content'])
            ->action($this->options['btn_text'], $this->options['action_url']);//name,action

    }
    public function toDatabase($notifiable){

        $content=$this->options['content'];
        return [
            'message'=>'<a href="'.$this->options['action_url'].'">'.$content.'</a>',
            'image'=>$this->options['image'],
            'content'=>$this->options['content'],
            'date'=>now(),
            'action_url'=>$this->options['action_url'],
        ];
    }
}
