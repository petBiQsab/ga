<?php

namespace App\Mail\Notifications;



use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Level1WeeklyReminderMail extends Mailable
{
    use SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data=[])
    {
        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail/notification/level1WeeklyReminder')
            ->subject('Aktualizácia projektu - ostáva posledný deň na aktualizáciu vášho projektu v MPP')
            ->with('data',$this->data);
    }
}

