<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Coop_utvary;
use App\Models\Proces_partner_list;
use App\Models\Projektove_portfolio_details;
use App\Models\Projektovy_tim;
use App\Models\Projektovy_zamer;
use App\Models\Projektovy_zamer_roky;
use App\Models\RYG;
use Database\Seeders\ciselniky\AdminListSeeder;
use Database\Seeders\ciselniky\AkceptaciaSeeder;
use Database\Seeders\ciselniky\AktivityKategoriaSeeder;
use Database\Seeders\ciselniky\AktivitySeeder;
use Database\Seeders\ciselniky\ExterneFinancovanieSeeder;
use Database\Seeders\ciselniky\FazaProjektuSeeder;
use Database\Seeders\ciselniky\HashtagSeeder;
use Database\Seeders\ciselniky\KategoriaSeeder;
use Database\Seeders\ciselniky\MestskaCastSeeder;
use Database\Seeders\ciselniky\MuscowSeeder;
use Database\Seeders\ciselniky\PhsrSeeder;
use Database\Seeders\ciselniky\PlanovanieRozpoctuSeeder;
use Database\Seeders\ciselniky\PoslaneckaPrioritaSeeder;
use Database\Seeders\ciselniky\PrioritaSeeder;
use Database\Seeders\ciselniky\PrioritneOblastiSeeder;
use Database\Seeders\ciselniky\ProcesnyPartnerListSeeder;
use Database\Seeders\ciselniky\ReportingSeeder;
use Database\Seeders\ciselniky\RygSeeder;
use Database\Seeders\ciselniky\SpecifickeAtributySeeder;
use Database\Seeders\ciselniky\StavProjektuSeeder;
use Database\Seeders\ciselniky\TypProjektuSeeder;
use Database\Seeders\ciselniky\VerejnaPracaSeeder;
use Database\Seeders\dataSeeders\AktivityPPSeeder;
use Database\Seeders\dataSeeders\CoopOrganizacieSeeder;
use Database\Seeders\dataSeeders\CoopUtvarySeeder;
use Database\Seeders\dataSeeders\DoplnujuceUdajeSeeder;
use Database\Seeders\dataSeeders\HashtagPPSeeder;
use Database\Seeders\dataSeeders\KvalifikovanyOdhadRokySeeder;
use Database\Seeders\dataSeeders\KvalifikovanyOdhadSeeder;
use Database\Seeders\dataSeeders\MestskaCastPPSeeder;
use Database\Seeders\dataSeeders\MTLSeeder;
use Database\Seeders\dataSeeders\OrganizaciaProjektuSeeder;
use Database\Seeders\dataSeeders\PhsrPPSeeder;
use Database\Seeders\dataSeeders\ProjektovaIdeaRokySeeder;
use Database\Seeders\dataSeeders\ProjektovaIdeaSeeder;
use Database\Seeders\dataSeeders\ProjektovePortfolioDetailsSeeder;
use Database\Seeders\dataSeeders\ProjektovePortfolioSeeder;
use Database\Seeders\dataSeeders\ProjektovyManagerPPSeeder;
use Database\Seeders\dataSeeders\ProjektovyTimSeeder;
use Database\Seeders\dataSeeders\ProjektovyZamerRokySeeder;
use Database\Seeders\dataSeeders\ProjektovyZamerSeeder;
use Database\Seeders\dataSeeders\RiadiaceGremiumSeeder;
use Database\Seeders\dataSeeders\SchvalenieProjektuSeeder;
use Database\Seeders\dataSeeders\SpecifickeAtributyPPSeeder;
use Database\Seeders\dataSeeders\SuvisiaceProjektySeeder;
use Database\Seeders\dataSeeders\TypProjektuPPSeeder;
use Illuminate\Database\Seeder;
use function Symfony\Component\Translation\t;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $this->call(AdminListSeeder::class);
//        $this->call(AkceptaciaSeeder::class);
//        $this->call(AktivityKategoriaSeeder::class);
//        $this->call(AktivitySeeder::class);
//        $this->call(ExterneFinancovanieSeeder::class);
//        $this->call(FazaProjektuSeeder::class);
//        $this->call(HashtagSeeder::class);
//        $this->call(KategoriaSeeder::class);
//        $this->call(MestskaCastSeeder::class);
//        $this->call(PhsrSeeder::class);
//        $this->call(PlanovanieRozpoctuSeeder::class);
//        $this->call(PoslaneckaPrioritaSeeder::class);
//        $this->call(PrioritneOblastiSeeder::class);
//        $this->call(PrioritaSeeder::class);
//        $this->call(ProcesnyPartnerListSeeder::class);
//        $this->call(ReportingSeeder::class);
//        $this->call(SpecifickeAtributySeeder::class);
//        $this->call(StavProjektuSeeder::class);
//        $this->call(TypProjektuSeeder::class);
//        $this->call(VerejnaPracaSeeder::class);
//
//
//        $this->call(ProjektovePortfolioSeeder::class);
//        $this->call(ProjektovePortfolioDetailsSeeder::class);
//        $this->call(OrganizaciaProjektuSeeder::class);
//        $this->call(SchvalenieProjektuSeeder::class);
//        $this->call(DoplnujuceUdajeSeeder::class);
//        $this->call(ProjektovaIdeaSeeder::class);
//        $this->call(ProjektovaIdeaRokySeeder::class);
//        $this->call(ProjektovyZamerSeeder::class);
//        $this->call(ProjektovyZamerRokySeeder::class);
//        $this->call(KvalifikovanyOdhadSeeder::class);
//        $this->call(KvalifikovanyOdhadRokySeeder::class);
//        $this->call(PhsrPPSeeder::class);
//        $this->call(TypProjektuPPSeeder::class);
//        $this->call(AktivityPPSeeder::class);
//        $this->call(ProjektovyManagerPPSeeder::class);
//        $this->call(CoopUtvarySeeder::class);
//        $this->call(CoopOrganizacieSeeder::class);
//        $this->call(RiadiaceGremiumSeeder::class);
//        $this->call(ProjektovyTimSeeder::class);
//        $this->call(MestskaCastPPSeeder::class);
//        $this->call(SuvisiaceProjektySeeder::class);
//        $this->call(MTLSeeder::class);
//        $this->call(HashtagPPSeeder::class);
//        $this->call(SpecifickeAtributyPPSeeder::class);
//        $this->call(MuscowSeeder::class);
//        $this->call(RygSeeder::class);
    }
}
