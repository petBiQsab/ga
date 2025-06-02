<?php

namespace App\Console\Reporting\Notifications;

use App\Http\Factories\ExportFactory;
use App\Models\MTL;
use App\Models\Projektove_portfolio;
use App\Models\Projektovy_manazer_pp;
use App\Models\Projektovy_tim;
use App\Models\Riadiace_gremium;
use App\Models\Users_group;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;

use Illuminate\Console\Command;
use Mail;

class RgpReportMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:rgpReportMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email with RGP';

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
        ini_set('max_execution_time', '2000');
        ini_set('memory_limit','8192M');

        foreach (Projektove_portfolio::where(['id_reporting' => 1,'rgp_ready'=>1,
            'active_reporting_cycle'=>1])->get() as $projekt)
        {

            //AK JE STAV PROJEKTU V NASLEDOVNYCH ID, TAK SA NEPOSIELA REPORT
            if (in_array($projekt->PP_PP_Details->id_stav_projektu,[5,6,7]))
            {
                continue;
            }
            $projekt->active_reporting_cycle=0;
            $projekt->save();

            $export=new ExportFactory();
            $data=$export->initExport('rgp',$projekt->id);
            $today=Carbon::today();
            $fileName="RGP_Report_ID".$data['id_projekt']."_".$today->format('dmY');
            $pdf = PDF::loadView('export.rgp_report.rgp', $data)
                ->setPaper('a4','landscape');
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            $data=$export->initExport('rgp',$projekt->id);

            $main_receivers=[];
            foreach (Riadiace_gremium::where(['id_pp' => $projekt->id])->get() as $item)
            {
                $main_receivers[]=$item->RiadiaceGremium_User->email;
            }

            $copy_receivers=[];
            foreach (Projektovy_tim::where(['id_pp' => $projekt->id])->get() as $item)
            {
                $copy_receivers[]=$item->ProjektovyTim_User->email;
            }

            foreach (Projektovy_manazer_pp::where(['id_pp' => $projekt->id])->get() as $item)
            {
                $copy_receivers[]=$item->ProjektovyManagerPP_User->email;

                //veduci PM
                $manager_of_PM=Users_group::where(['user_id'=>$item->id_user])->whereNotNull('group')->first();
                if ($manager_of_PM!=null)
                {
                    if (isset($manager_of_PM->UsersGroup_Manager))
                    {
                        if (isset($manager_of_PM->UsersGroup_Manager->Managers_User))
                        {
                            $copy_receivers[]=$manager_of_PM->UsersGroup_Manager->Managers_User->email;
                        }
                    }
                }
            }
            $subject="ID ".$data['id_projekt']." ".$data['nazov_projektu']." | Mesačný report projektu";

            Mail::send('mail.reports.rgp.rgp_mail',['data' => $data], function ($message) use ($pdf,$fileName,$subject,$main_receivers,$copy_receivers) {
                $message->to($main_receivers);
                $message->cc($copy_receivers);
                $message->subject($subject);
                $message->attachData($pdf->output(), $fileName.'.pdf');
            });
        }
    }
}
