<?php

namespace App\Console\Reporting\Exports;

use App\Models\MTL;
use App\Models\Projektove_portfolio;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class ExportDatasetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:exportDatasetCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Dataset - custom set of data - weekly reported';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function exportData($pp_ids, $status)
    {
        $weekNumber = Carbon::now()->subWeek()->weekOfYear;

        $query = MTL::whereIn('id_pp', $pp_ids);

        if (is_null($status)) {
            $query->whereNull('status');
        } else {
            $query->where('status', $status);
        }

        $mtlRecords = $query->with([
            'MTL_PP_Details.PP_Details_Faza_projektu',
            'MTL_PP_Details.PP_Details_Stav_projektu',
            'MTL_PP_Details.PP_Details_Ryg',
            'MTL_PP_Details.PP_Details_Muscow',
            'MTL_Doplnujuce_udaje'
        ])->get([
            'id_pp', 'status', 'komentar', 'updated_at'
        ]);

        $logs = $mtlRecords->map(function ($record) use ($weekNumber, $status) {
            return [
                'id_pp'       => $record->id_pp,
                'status'      => is_null($status) ? 'none' : $record->status,
                'week_number' => $weekNumber,
                'planovane_aktivity_na_najblizsi_tyzden' => $record->MTL_PP_Details->planovane_aktivity_na_najblizsi_tyzden ?? null,
                'zrealizovane_aktivity' => $record->MTL_PP_Details->zrealizovane_aktivity ?? null,
                'rizika_projektu' => $record->MTL_PP_Details->rizika_projektu ?? null,
                'datum_zacatia_projektu' => $record->MTL_PP_Details->datum_zacatia_projektu ?? null,
                'datum_konca_projektu' => $record->MTL_PP_Details->datum_konca_projektu ?? null,
                'najaktualnejsia_cena_projektu_vrat_DPH' => $record->MTL_PP_Details->najaktualnejsia_cena_projektu_vrat_DPH ?? null,
                'najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH' => $record->MTL_PP_Details->najaktualnejsie_rocne_prevadzkove_naklady_projektu_vrat_DPH ?? null,
                'faza_projektu' => $record->MTL_PP_Details->PP_Details_Faza_projektu->value ?? null,
                'stav_projektu' => $record->MTL_PP_Details->PP_Details_Stav_projektu->value ?? null,
                'ryg' => $record->MTL_PP_Details->PP_Details_Ryg->value ?? null,
                'muscow' => $record->MTL_PP_Details?->PP_Details_Muscow->value ?? null,
                'suma_externeho_financovania' => $record->MTL_Doplnujuce_udaje->suma_externeho_financovania ?? null,
                'zdroj_externeho_financovania' => $record->MTL_Doplnujuce_udaje->zdroj_externeho_financovania ?? null,
                'komentar' => $record->komentar,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        });

        DB::table('export_dataset')->insert($logs->toArray());
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pp_ids = Projektove_portfolio::where(['id_reporting' => 1])->pluck('id')->toArray();

        foreach (['red', 'orange', 'green', null] as $status) {
            $this->exportData($pp_ids, $status);
        }
    }

}



