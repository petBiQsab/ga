<?php

namespace App\Http\Controllers;


use App\Http\Interface\PracoviskoInterface;
use App\Http\Rights\ProjectUserRights;
use Dflydev\DotAccessData\Data;

class PracoviskoController extends Controller
{

    public function __construct(private PracoviskoInterface $pracoviskoRepository)
    {
       $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()!==null)
        {
            $userInfoData=new \stdClass();
            $userInfoData->name=auth()->user()->name;
            $rights=new ProjectUserRights();
            $rights=$rights->getStaticRole(auth()->user()->objectguid);
            $metadata=new \stdClass();

            $dataset=$this->pracoviskoRepository->createDataset();

            $userInfoData->role=$rights->name;
            $userInfoData->roleName=$rights->name;
            $userInfoData->moje_utvary_filter2=$this->pracoviskoRepository->getMojeUtvary(auth()->user()->objectguid);
        }else
        {
            $userInfoData=new \stdClass();
            $userInfoData->name="Ing. Joe Doe";
            $userInfoData->role="admin";
            $userInfoData->moje_utvary_filter2=$this->pracoviskoRepository->getMojeUtvary(auth()->user()->objectguid);
            $metadata=null;
        }

        return view('pracovisko')->with('dataset',$dataset)->with('userInfoData',$userInfoData)->with('metadata',$metadata);
    }

    public function indexLimit($number)
    {
       // $dataset=$this->pracoviskoRepository->createDatasetLimit($number);

        if (auth()->user()!==null)
        {
            $userInfoData=new \stdClass();
            $userInfoData->name=auth()->user()->name;
            $rights=new ProjectUserRights();
            $rights=$rights->getStaticRole(auth()->user()->objectguid);
            $userInfoData->roleName=$rights->name;
            $metadata=[];

            $dataset=$this->pracoviskoRepository->createDatasetLimit($number);

            $userInfoData->role=$rights->name;
            $userInfoData->roleName=$rights->name;
            $userInfoData->moje_utvary_filter2=$this->pracoviskoRepository->getMojeUtvary(auth()->user()->objectguid);
        }else
        {
            $userInfoData=new \stdClass();
            $userInfoData->name="Jozef Valachovic";
            $rights=new ProjectUserRights();
            $rights=$rights->getStaticRole("023f8e7f-d2fa-4ba5-9cf6-b69737111005");
            $metadata=[];

            if ($rights->slug!="admin")
            {
                $dataset=$this->pracoviskoRepository->createDatasetPM("023f8e7f-d2fa-4ba5-9cf6-b69737111005");
            }
            else
            {
                $dataset=$this->pracoviskoRepository->createDatasetLimit($number);
            }
            $userInfoData->role=$rights->name;
            $userInfoData->moje_utvary_filter2=$this->pracoviskoRepository->getMojeUtvary(auth()->user()->objectguid);
        }

        return view('pracovisko')->with('dataset',$dataset)->with('userInfoData',$userInfoData)->with('metadata',$metadata);
    }

}
