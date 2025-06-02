<?php

namespace App\Console\Reporting\Notifications;

use App\Models\Projektove_portfolio;
use App\Models\Projektovy_manazer_pp;
use App\Models\User;
use Illuminate\Console\Command;
use Mail;

class RgpNotFinalizedNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:rgp_not_finalized';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin notification - list of not reported projects';

    private array $lang;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($lang)
    {
        $this->lang=$lang;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $projekty=Projektove_portfolio::where(['id_reporting' => 1,'active_reporting_cycle' => 1])->get();

        foreach ($projekty as $projekt){
            //AK JE STAV PROJEKTU V NASLEDOVNYCH ID, TAK SA NEPOSIELA REPORT
            if (in_array($projekt->PP_PP_Details->id_stav_projektu, [5, 6, 7])) {
                continue;
            }
            if (count($projekt->PP_ProjektovyManager) > 0) {
                $pm = $projekt->PP_ProjektovyManager[0]->id_user;
            } else {
                $pm = null;
            }
            $user = User::where(['objectguid' => $pm])->first();
            if ($user != null) {
                $projekt->user = $user->name;
            } else {
                $projekt->user = null;
            }
        }
        $data = new \stdClass();
        $data->projects = $projekty;

        Mail::to('portfolio@bratislava.sk')->send(new \App\Mail\Notifications\RGP_not_finilized($data,$this->lang));
    }
}

