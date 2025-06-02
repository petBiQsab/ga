<?php

namespace App\Console\Reporting\Notifications;

use App\Models\Projektove_portfolio;
use App\Models\Projektovy_manazer_pp;
use App\Models\User;

use Illuminate\Console\Command;
use Mail;

class Level1NotificationMag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:level1notifyMag';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin notification - 10 days to end of month';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $managers = Projektovy_manazer_pp::distinct()->get('id_user');

        foreach ($managers as $manager) {
            $results = Projektove_portfolio::join('projektovy_manazer_pp', 'projektove_portfolio.id', '=', 'projektovy_manazer_pp.id_pp')
                ->join('mtl', 'projektove_portfolio.id', '=', 'mtl.id_pp')
                ->join('projektove_portfolio_details', 'projektove_portfolio.id', '=', 'projektove_portfolio_details.id_pp')
                ->select(['projektove_portfolio.id_original', 'projektove_portfolio.id_projekt', 'projektove_portfolio.nazov_projektu as nazov', 'projektovy_manazer_pp.id_user'])
                ->where([
                    'projektovy_manazer_pp.id_user' => $manager->id_user,
                    'projektovy_manazer_pp.deleted_at' => null,
                    'projektove_portfolio.id_reporting' => 1,
                    'projektove_portfolio.active_reporting_cycle' => 1])
                ->get();

            if (count($results) > 0) {

                foreach ($results as $item) {

                    //AK JE STAV PROJEKTU V NASLEDOVNYCH ID, TAK SA NEPOSIELA REPORT
                    if (in_array($item->id_stav_projektu, [5, 6, 7])) {
                        continue;
                    }
                    $user = User::where(['objectguid' => $item->id_user])->first();
                    $item->user = $user->name;
                    $item->firstName = $user->givenName;
                    $item->email = $user->email;
                }

                $data = new \stdClass();
                $data->meno = $results[0]->firstName;
                $data->projects = $results;

                //Mail::to('matus.baxant@bratislava.sk')->send(new \App\Mail\Notifications\MagSevenDay($data));
                //Mail::to($results[0]->email)->send(new \App\Mail\Notifications\MagSevenDay($data));
            }
        }
    }
}
