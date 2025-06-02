<?php

namespace App\Http\Controllers\JunkTraining;

use App\Http\Controllers\Controller;
use App\Models\MTL;
use App\Models\Projektove_portfolio;
use Carbon\Carbon;
use DB;

class TestingController extends Controller
{

    public function logMtlStatuses($pp_ids, $status)
    {
        $weekNumber = Carbon::now()->subWeek()->weekOfYear;

        $query = MTL::whereIn('id_pp', $pp_ids);
        if (is_null($status)) {
            $query->whereNull('status');
        } else {
            $query->where('status', $status);
        }
        $mtlRecords = $query->with('MTL_PP_Details')->get(['id_pp', 'status', 'komentar', 'updated_at']);

        $logs = $mtlRecords->map(function ($record) use ($weekNumber, $status) {
            return [
                'id_pp'       => $record->id_pp,
                'status'      => is_null($status) ? 'none' : $record->status,
                'week_number' => $weekNumber,
                'planovane_aktivity_na_najblizsi_tyzden' => $record->MTL_PP_Details->planovane_aktivity ?? null,
                'zrealizovane_aktivity' => $record->MTL_PP_Details->zrealizovane_aktivity ?? null,
                'rizika_projektu' => $record->MTL_PP_Details->rizika_projektu ?? null,
                'komentar' => $record->komentar,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        });

        DB::table('mtl_log')->insert($logs->toArray());
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function index()
    {
        MTL::query()->update(['reset' => 1]);
        //'updated_at' => DB::raw('updated_at') zanecháva pôvodnu hodnotu updated_at
        Projektove_portfolio::query()->update(['active_reporting_cycle' => 1, 'updated_at' => DB::raw('updated_at')]);

        $pp_ids=Projektove_portfolio::where(['id_reporting'=>1])->pluck('id')->toArray();

        foreach (['red', 'orange', 'green',null] as $status) {
            $this->logMtlStatuses($pp_ids, $status);

            MTL::whereIn('id_pp', $pp_ids)
                ->where(['status' => $status])
                ->update(['status' => null, 'history' => $status, 'reset' => 1]);
        }
        Projektove_portfolio::where(['rgp_ready' => 1])->update(['rgp_ready' => 0]);
        Projektove_portfolio::where(['active_reporting_cycle' => 0])->update(['active_reporting_cycle' => 1]);

    }
}
