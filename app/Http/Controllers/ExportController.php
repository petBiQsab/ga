<?php

namespace App\Http\Controllers;

use App\Exports\Reports\RGP;
use App\Http\Factories\ExportFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Mail;


class ExportController extends Controller
{

    public function export($type,$id)
    {
        ini_set('max_execution_time', '2000');
        ini_set('memory_limit','8192M');

        $export=new ExportFactory();
        $data=$export->initExport($type,$id);
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
            ]),
        );

        return $pdf->stream($fileName.'.pdf');

    }

    public function export_odapa($type)
    {
        $export=new ExportFactory();
        return $export->initExport($type,null);
    }
}
