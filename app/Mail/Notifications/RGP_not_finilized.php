<?php

namespace App\Mail\Notifications;

use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RGP_not_finilized extends Mailable
{
    use SerializesModels;

    protected $data;
    private array $lang;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data=[],$lang)
    {
        $this->data = $data;
        $this->lang=$lang;
    }

    //private function getPredchadzajuciMesiac():string
    //{
    //    $carbonDate = Carbon::now();
    //   $previousMonth = $carbonDate->subMonth();
    //    return $this->lang[$previousMonth->format('F')];
    //}

    //private function getPredchadzajuciMesiac_rok()
    //{
    //    $carbonDate = Carbon::now();
    //    $previousMonth = $carbonDate->subMonth();
    //    return $previousMonth->format('Y');
    //}

    private function getPredchadzajuciTyzden(): string
    {
        $carbonDate = Carbon::now();
        $previousWeek = $carbonDate->subWeek();
        return $previousWeek->format('W'); // Returns the ISO-8601 week number
    }

    private function getPredchadzajuciTyzden_rok(): string
    {
        $carbonDate = Carbon::now();
        $previousWeek = $carbonDate->subWeek();
        return $previousWeek->format('Y'); // Returns the year of that previous week
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.notification.rgp_not_finalized')
            ->subject('Nezreportované projekty v MPP - za ' . $this->getPredchadzajuciTyzden() . '. týždeň ' . $this->getPredchadzajuciTyzden_rok())
            ->with('data', $this->data);
    }
}
