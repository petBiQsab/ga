<?php

namespace App\Console\Reporting\Notifications;

use App\Models\Managers;
use App\Models\Projektove_portfolio;
use App\Models\Projektovy_manazer_pp;
use App\Models\User;
use App\Models\Users_group;
use Illuminate\Console\Command;
use Mail;

class Level1WeeklyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:level1WeeklyReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification level1 weekly reminder';

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
                ->join('projektove_portfolio_details','projektove_portfolio.id','=','projektove_portfolio_details.id_pp')
                ->select(['projektove_portfolio.id_original', 'projektove_portfolio.id_projekt', 'projektove_portfolio.nazov_projektu as nazov', 'projektovy_manazer_pp.id_user'])
                ->where([
                    'projektovy_manazer_pp.id_user' => $manager->id_user,
                    'projektovy_manazer_pp.deleted_at' => null,
                    'projektove_portfolio.id_reporting' => 1,
                    'projektove_portfolio.active_reporting_cycle'=>1,
                    'mtl.status' => null,
                ])
                ->get();

            if (count($results) > 0) {

                foreach ($results as $item) {
                    if (in_array($item->id_stav_projektu,[5,6,7]))
                    {
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

                $user=User::where(['email'=>$results[0]->email])->first();
                $user_email=$user;

                $user=Users_group::where(['user_id' => $user->objectguid])->whereNotNull('group')->first();
                $boss=null;
                if ($user!=null)
                {
                    $manager=Managers::where(['id_group' => $user->group])->first();
                    if ($manager!=null)
                    {
                        $boss=User::where(['objectguid'=>$manager->id_user])->first();
                    }
                }

                if ($boss!=null)
                {
                    $bossOfManager = $boss->email;
                    $data->boss=$boss->name;

                    //Mail::to('ivan.duricek@bratislava.sk')->send(new \App\Mail\Notifications\Level1WeeklyReminderMail($data));
                    //Mail::to($user_email)->cc($bossOfManager)->send(new \App\Mail\Notifications\Level1WeeklyReminderMail($data));
                    Mail::to($user_email)->send(new \App\Mail\Notifications\Level1WeeklyReminderMail($data));
                }
                else
                {
                     Mail::to($user_email)->send(new \App\Mail\Notifications\Level1WeeklyReminderMail($data));
                    //Mail::to('ivan.duricek@bratislava.sk')->send(new \App\Mail\Notifications\Level1WeeklyReminderMail($data));
                }
            }
        }
    }
}
