<?php

namespace App\Http\Controllers;

use App\Http\Interface\ProjectDetailInterface;
use App\Http\Rights\ProjectUserRights;
use App\Models\Projektove_portfolio;
use Illuminate\Http\Request;


class ProjectDetailController extends Controller
{
    private array $rightsConfig;


    public function __construct(private ProjectDetailInterface $projectDetailRepo,$rightsConfig)
    {
        $this->rightsConfig=$rightsConfig;
        $this->middleware('auth');
    }
    public function index($id_original)
    {
        $projekt=Projektove_portfolio::where(['id_original' => $id_original])->firstOrFail();
        $userRights=new ProjectUserRights();

        $userRightsName=$userRights->getRightsForProject(auth()->user()->objectguid,$projekt->id);

        $dataset=$this->projectDetailRepo->createDataset($projekt);
        $ciselniky=$this->projectDetailRepo->collectCiselniky();
        $metadata= new \stdClass();
        $metadata->nextAvailableId=$this->projectDetailRepo->findAvailableId(); //Nepouziva
        $metadata->notAvailableIds=$this->projectDetailRepo->getNotAvailableId();
        $metadata->rights=$this->rightsConfig[$userRightsName->slug];

        $rights=new ProjectUserRights();

        $userInfoData=new \stdClass();
        $userInfoData->name=auth()->user()->name;
        $userInfoData->role=$userRights->getRightsForProject(auth()->user()->objectguid,$projekt->id)->name;
        $userInfoData->roleName=$rights->getStaticRole(auth()->user()->objectguid)->name;

        $userInfoData->moje_utvary_filter2=["Sekcia výstavby"];

        return view('detail')
            ->with('dataset',$dataset)
            ->with('userInfoData',$userInfoData)
            ->with('ciselniky',$ciselniky)
            ->with('metadata',$metadata);
    }

    public function create()
    {
        $emptyProject=$this->projectDetailRepo->createEmptyProject();
        $ciselniky=$this->projectDetailRepo->collectCiselniky();

        $metadata= new \stdClass();
        $metadata->nextAvailableId=$this->projectDetailRepo->findAvailableId();
        $metadata->notAvailableIds=$this->projectDetailRepo->getNotAvailableId();
        $metadata->rights=$this->rightsConfig['admin'];

        $userInfoData=new \stdClass();
        //$userInfoData->name="Jozef Valachovic";

        $userInfoData->name=auth()->user()->name;
        $rights=new ProjectUserRights();
        //$rights=$rights->getStaticRole("023f8e7f-d2fa-4ba5-9cf6-b69737111005");

        $rights=$rights->getStaticRole(auth()->user()->objectguid);
        $userInfoData->roleName=$rights->name;
        $userInfoData->role=$rights->name;

        $userInfoData->moje_utvary_filter2=["Sekcia výstavby"];

        return view('detail')->with('dataset',$emptyProject)
            ->with('ciselniky',$ciselniky)
            ->with('userInfoData',$userInfoData)
            ->with('metadata',$metadata);
    }

    public function store(Request $request)
    {
        $store=$this->projectDetailRepo->storeEditProject($request);

        return response()->json(['id'=>$store->id],$store->statusCode);
    }

    public function delete($id)
    {
        return $this->projectDetailRepo->deleteProject($id);
    }
}
