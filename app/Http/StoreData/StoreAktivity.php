<?php

namespace App\Http\StoreData;

use App\Http\Factories\StoreDataFactory;
use App\Http\Interface\FactoryInterface\StorableInterface;
use App\Models\Aktivity_pp;

class StoreAktivity implements StorableInterface
{
    private bool $isDirty;

    public function __construct()
    {
        $this->isDirty = false;
    }

    private function saveDirty(bool $changeBool): bool
    {
        if ($changeBool === true) {
            $this->isDirty = true;
        }
        return $this->isDirty;
    }
    private function sanitizeDate($date)
    {
        if ($date=="")
        {
            $date=null;
        }
        return $date;
    }
    public function store($model, $aktivity_typ, $id, $newValue)
    {
        if ($aktivity_typ=="standard") {
            $aktivity_ids=Aktivity_pp::where(['id_pp' => $id])->whereNull('vlastna_aktivita')->pluck('id')->toArray();

            foreach ($newValue as $items) {

                if (!isset($items->id_aktivita)) // pre prípad ak je to novo pridaná aktivita
                {
                    $items->id_aktivita=$items->value->id;
                }
                $query = $model::where(['id_pp' => $id, 'id_aktivita' => $items->id_aktivita])->firstOrNew();

                if ($query->exists === true) {
                    $idToRemove = $query->id;
                    $key = array_search($idToRemove, $aktivity_ids);
                    if ($key !== false) {
                        unset($aktivity_ids[$key]);
                    }
                }

                $query->id_pp=$id;

                if (is_object($items->value))  //ak sa zmenila aktivita(nazov), tak pride object value, kde je aj id a value
                {
                    $query->id_aktivita = $items->value->id;
                }
                else
                {
                    $query->id_aktivita=$items->id_aktivita;
                }

                $query->zaciatok_aktivity = $this->sanitizeDate($items->zaciatok_aktivity);
                $query->skutocny_zaciatok_aktivity = $this->sanitizeDate($items->skutocny_zaciatok_aktivity);
                $query->koniec_aktivity = $this->sanitizeDate($items->koniec_aktivity);
                $query->skutocny_koniec_aktivity = $this->sanitizeDate($items->skutocny_koniec_aktivity);

                $isDirtyZaciatok = $query->isDirty('zaciatok_aktivity');
                $isDirtySkutocnyZaciatok = $query->isDirty('skutocny_zaciatok_aktivity');
                $isDirtyKoniec = $query->isDirty('koniec_aktivity');
                $isDirtySkutocnyKoniec = $query->isDirty('skutocny_koniec_aktivity');

                $query->save();

                $this->isDirty = $this->saveDirty($isDirtyZaciatok || $isDirtySkutocnyZaciatok || $isDirtyKoniec || $isDirtySkutocnyKoniec);

                if (is_object($items->value)) //ak sa zmenila aktivita(nazov), tak zodpovedné osoby k starej aktivite sa vymazu
                {
                    $zodpovedni=Aktivity_pp::where(['id_pp' => $id,'id_aktivita' => $items->id_aktivita])->firstOrNew();
                    $storeFactory=new StoreDataFactory();
                    $store= $storeFactory->inicializeStoring('AktivityZodpovedni');
                    $this->isDirty = $this->saveDirty($store->store(new Aktivity_pp(),$zodpovedni->ZodpovedneOsoby() , $id, []));

                    $zodpovedni=Aktivity_pp::where(['id_pp' => $id,'id_aktivita' => $items->value->id])->first();

                }else
                {
                    $zodpovedni=Aktivity_pp::where(['id_pp' => $id,'id_aktivita' => $items->id_aktivita])->first();
                }
                $storeFactory=new StoreDataFactory();
                $store= $storeFactory->inicializeStoring('AktivityZodpovedni');
                $this->isDirty = $this->saveDirty($store->store(new Aktivity_pp(),$zodpovedni->ZodpovedneOsoby() , $id, $items->zodpovedni));

            }
            foreach ($aktivity_ids as $id) { //vymazu sa aktivity, ktore ostali v zozname
                Aktivity_pp::findOrFail($id)->delete();
                $this->isDirty = $this->saveDirty(true);
            }
        }
        elseif ($aktivity_typ=="vlastna")
        {

            $aktivity_ids=Aktivity_pp::where(['id_pp' => $id])->whereNull('id_aktivita')->pluck('id')->toArray();

            foreach ($newValue as $items) {

                if (is_object($items->value))// pre prípad ak je to novo pridaná aktivita alebo editovaný názov
                {
                    $items->value=$items->value->value;
                }

                $query = $model::where(['id_pp' => $id, 'vlastna_aktivita' => $items->value])->firstOrNew();
                if ($query->exists === true) {
                    $idToRemove = $query->id;
                    $key = array_search($idToRemove, $aktivity_ids);
                    if ($key !== false) {
                        unset($aktivity_ids[$key]);
                    }
                }
                $query->id_pp=$id;

                if (is_object($items->value))  //ak sa zmenila aktivita(nazov), tak pride object value, kde je aj id a value
                {
                    $query->vlastna_aktivita = $items->value->value;
                }
                else
                {
                    $query->vlastna_aktivita=$items->value;
                }

                if (isset($items->headerTitle))
                {
                    $query->id_kategoria=$items->headerTitle->id;
                }

                $query->zaciatok_aktivity = $this->sanitizeDate($items->zaciatok_aktivity);
                $query->skutocny_zaciatok_aktivity = $this->sanitizeDate($items->skutocny_zaciatok_aktivity);
                $query->koniec_aktivity = $this->sanitizeDate($items->koniec_aktivity);
                $query->skutocny_koniec_aktivity = $this->sanitizeDate($items->skutocny_koniec_aktivity);

                $isDirtyZaciatok = $query->isDirty('zaciatok_aktivity');
                $isDirtySkutocnyZaciatok = $query->isDirty('skutocny_zaciatok_aktivity');
                $isDirtyKoniec = $query->isDirty('koniec_aktivity');
                $isDirtySkutocnyKoniec = $query->isDirty('skutocny_koniec_aktivity');

                $query->save();

                $this->isDirty = $this->saveDirty($isDirtyZaciatok || $isDirtySkutocnyZaciatok || $isDirtyKoniec || $isDirtySkutocnyKoniec);

                if (is_object($items->value)) //ak sa zmenila aktivita(nazov), tak zodpovedné osoby k starej aktivite sa vymazu
                {
                    $zodpovedni=Aktivity_pp::where(['id_pp' => $id,'vlastna_aktivita' => $items->value])->firstOrNew();
                    $storeFactory=new StoreDataFactory();
                    $store= $storeFactory->inicializeStoring('AktivityZodpovedni');
                    $this->isDirty = $this->saveDirty($store->store(new Aktivity_pp(),$zodpovedni->ZodpovedneOsoby() , $id, []));

                    $zodpovedni=Aktivity_pp::where(['id_pp' => $id,'vlastna_aktivita' => $items->value->value])->first();

                }else
                {
                    $zodpovedni=Aktivity_pp::where(['id_pp' => $id,'vlastna_aktivita' => $items->value])->first();
                }
                $storeFactory=new StoreDataFactory();
                $store= $storeFactory->inicializeStoring('AktivityZodpovedni');
                $this->isDirty = $this->saveDirty($store->store(new Aktivity_pp(),$zodpovedni->ZodpovedneOsoby() , $id, $items->zodpovedni));
            }
            foreach ($aktivity_ids as $id) {
                Aktivity_pp::findOrFail($id)->delete();
                $this->isDirty = $this->saveDirty(true);
            }
        }
        return $this->isDirty;
    }
}
