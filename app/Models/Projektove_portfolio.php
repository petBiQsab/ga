<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Overtrue\LaravelVersionable\Versionable;

class Projektove_portfolio extends Authenticatable
{
    protected $table = 'projektove_portfolio';
    use Notifiable;
    use SoftDeletes;
    //use Versionable;

    protected $versionable = ['id_original', 'id_projekt', 'id_parent', 'id_child', 'nazov_projektu', 'alt_nazov_projektu', 'id_reporting', 'rgp_ready', 'id_planovanie_rozpoctu', 'active_reporting_cycle', 'max_rok'];

    protected $fillable = [
        'id_original', 'id_projekt', 'id_parent', 'id_child', 'nazov_projektu', 'alt_nazov_projektu', 'id_reporting', 'rgp_ready', 'id_planovanie_rozpoctu', 'active_reporting_cycle', 'max_rok', 'created_by',
    ];

    public function PP_MTL()
    {
        return $this->hasOne('App\Models\MTL', 'id_pp', 'id');
    }
    public function PP_MTL_Log()
    {
        return $this->hasOne('App\Models\MTL_log', 'id_pp', 'id');
    }
    public function PP_MTL_Log_last_week()
    {
        return $this->hasOne('App\Models\MTL_log', 'id_pp', 'id')->where(['week_number' => Carbon::now()->subWeek()->weekOfYear]);
    }

    public function PP_PP_Details()
    {
        return $this->hasOne('App\Models\Projektove_portfolio_details', 'id_pp', 'id');
    }

    public function PP_Planovanie_rozpoctu()
    {
        return $this->hasOne('App\Models\Planovanie_rozpoctu', 'id', 'id_planovanie_rozpoctu');
    }

    public function PHSR(): BelongsToMany
    {
        return $this->belongsToMany(Phsr::class,'phsr_pp','id_pp','id_phsr');
    }

    public function PP_PHSR()
    {
        return $this->hasMany('App\Models\Phsr_pp', 'id_pp', 'id');
    }

    public function TypProjektu(): BelongsToMany
    {
        return $this->belongsToMany(Typ_projektu::class, 'typ_projektu_pp', 'id_pp','id_typ_projektu');
    }

    public function PP_TypProjektu()
    {
        return $this->hasMany('App\Models\Typ_projektu_pp', 'id_pp', 'id');
    }

    public function PrioritneOblasti(): BelongsToMany
    {
        return $this->belongsToMany(Prioritne_oblasti::class,'prioritne_oblasti_pp' ,'id_pp', 'id_prioritne_oblasti');
    }

    public function PP_PrioritneOblasti()
    {
        return $this->hasMany('App\Models\Prioritne_oblasti_pp', 'id_pp', 'id');
    }

    public function PP_OrganizaciaProjektu()
    {
        return $this->hasOne('App\Models\Organizacia_projektu', 'id_pp', 'id');
    }

    public function ProjektovyManager(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'projektovy_manazer_pp', 'id_pp', 'id_user','id','objectguid');
    }

    public function PP_ProjektovyManager()
    {
        return $this->hasMany('App\Models\Projektovy_manazer_pp', 'id_pp', 'id');
    }

    public function CoopUtvary(): BelongsToMany
    {
        return $this->belongsToMany(Groups::class,'coop_utvary', 'id_pp', 'id_group','id','objectguid');
    }

    public function PP_CoopUtvary()
    {
        return $this->hasMany('App\Models\Coop_utvary', 'id_pp', 'id');
    }

    public function CoopOrganizacie(): BelongsToMany
    {
        return $this->belongsToMany(Groups::class,'coop_organizacie', 'id_pp', 'id_group','id','objectguid');
    }

    public function PP_CoopOrganizacie()
    {
        return $this->hasMany('App\Models\Coop_organizacie', 'id_pp', 'id');
    }

    public function ProjektovyTim(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'projektovy_tim', 'id_pp', 'id_user', 'id','objectguid');
    }

    public function PP_ProjektovyTim()
    {
        return $this->hasMany('App\Models\Projektovy_tim', 'id_pp', 'id');
    }

    public function RiadiaceGremium(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'riadiace_gremium', 'id_pp', 'id_user','id','objectguid');
    }

    public function PP_RiadiaceGremium()
    {
        return $this->hasMany('App\Models\Riadiace_gremium', 'id_pp', 'id');
    }

    public function PP_SchvalovanieProjektu()
    {
        return $this->hasOne('App\Models\Schvalenie_projektu', 'id_pp', 'id');
    }

    public function PP_DoplnujuceUdaje()
    {
        return $this->hasOne('App\Models\Doplnujuce_udaje', 'id_pp', 'id');
    }

    public function MestskaCast(): BelongsToMany
    {
        return $this->belongsToMany(Mestska_cast::class,'mestska_cast_pp', 'id_pp', 'id_mc');
    }

    public function PP_MestskaCastPP()
    {
        return $this->hasMany('App\Models\Mestska_cast_pp', 'id_pp', 'id');
    }

    public function PP_Reporting()
    {
        return $this->hasOne('App\Models\Reporting', 'id', 'id_reporting');
    }

    public function PP_ProjektovaIdea()
    {
        return $this->hasOne('App\Models\Projektova_idea', 'id_pp', 'id');
    }

    public function PP_ProjektovyZamer()
    {
        return $this->hasOne('App\Models\Projektovy_zamer', 'id_pp', 'id');
    }

    public function PP_KvalifikovanyZamer()
    {
        return $this->hasOne('App\Models\Kvalifikovany_odhad', 'id_pp', 'id');
    }

    public function Hashtag(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class,'hashtag_pp', 'id_pp', 'id_hashtag');
    }

    public function PP_HashtagPP()
    {
        return $this->hasMany('App\Models\Hashtag_pp', 'id_pp', 'id');
    }

    public function SpeciAtribut(): BelongsToMany
    {
        return $this->belongsToMany(Specificke_atributy::class,'specificke_atributy_pp', 'id_pp', 'id_speci_atribut');
    }

    public function PP_SpeciAtributPP()
    {
        return $this->hasMany('App\Models\Specificke_atributy_pp', 'id_pp', 'id');
    }


    public function AktivityStandard(): BelongsToMany
    {
        return $this->belongsToMany(Aktivity::class,'aktivity_pp', 'id_pp', 'id_aktivita')->whereNull('vlastna_aktivita');
    }
    public function PP_AktivityPP_standard()
    {
        return $this->hasMany('App\Models\Aktivity_pp', 'id_pp', 'id')->whereNull('vlastna_aktivita');
    }

    public function PP_AktivityPP_vlastne()
    {
        return $this->hasMany('App\Models\Aktivity_pp', 'id_pp', 'id')->whereNull('id_aktivita');
    }

    public function PP_AktivityPP_vsetky()
    {
        return $this->hasMany('App\Models\Aktivity_pp', 'id_pp', 'id');
    }

    public function SuvisiaceProjekty(): BelongsToMany
    {
        return $this->belongsToMany(Projektove_portfolio::class,'suvisiace_projekty', 'id_pp', 'id_suvis_projekt');
    }

    public function PP_SuvisiaceProjekty()
    {
        return $this->hasMany('App\Models\Suvisiace_projekty', 'id_pp', 'id');
    }

    public function Sprava(): BelongsToMany
    {
        return $this->belongsToMany(Groups::class,'sprava', 'id_pp', 'id_group');
    }

    public function PP_Sprava()
    {
        return $this->hasMany('App\Models\Sprava', 'id_pp', 'id');
    }

    public function Udrzba(): BelongsToMany
    {
        return $this->belongsToMany(Groups::class,'udrzba', 'id_pp', 'id_group');
    }

    public function PP_Udrzba()
    {
        return $this->hasMany('App\Models\Udrzba', 'id_pp', 'id');
    }

    public function PP_ProjektovaIdeaRokyBV()
    {
        return $this->hasMany('App\Models\Projektova_idea_roky', 'id_pp', 'id')->where(['typ' => "BV"]);
    }

    public function PP_ProjektovaIdeaRokyKV()
    {
        return $this->hasMany('App\Models\Projektova_idea_roky', 'id_pp', 'id')->where(['typ' => "KV"]);
    }

    public function PP_ProjektovyZamerRokyBV()
    {
        return $this->hasMany('App\Models\Projektovy_zamer_roky', 'id_pp', 'id')->where(['typ' => "BV"]);
    }
    public function PP_ProjektovyZamerRokyKV()
    {
        return $this->hasMany('App\Models\Projektovy_zamer_roky', 'id_pp', 'id')->where(['typ' => "KV"]);
    }
    public function PP_ProjektovyZamerRokyBP()
    {
        return $this->hasMany('App\Models\Projektovy_zamer_roky', 'id_pp', 'id')->where(['typ' => "BP"]);
    }
    public function PP_ProjektovyZamerRokyKP()
    {
        return $this->hasMany('App\Models\Projektovy_zamer_roky', 'id_pp', 'id')->where(['typ' => "KP"]);
    }
    public function PP_KvalifikovanyOdhadRoky()
    {
        return $this->hasMany('App\Models\Kvalifikovany_odhad_roky', 'id_pp', 'id');
    }
    public function lastCompletedActivity()
    {
        return $this->hasOne('App\Models\Aktivity_pp', 'id_pp', 'id')
            ->whereNotNull('skutocny_zaciatok_aktivity')
            ->whereNotNull('skutocny_koniec_aktivity')
            ->latest('skutocny_koniec_aktivity');
    }

    public function incompleteActivities()
    {
        return $this->hasMany('App\Models\Aktivity_pp', 'id_pp', 'id')
            ->where(function ($query) {
                $query->whereNull('zaciatok_aktivity')
                    ->orWhereNull('skutocny_zaciatok_aktivity')
                    ->orWhereNull('koniec_aktivity')
                    ->orWhereNull('skutocny_koniec_aktivity');
            });
    }



}
