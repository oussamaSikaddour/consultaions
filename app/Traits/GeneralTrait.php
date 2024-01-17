<?php

namespace App\Traits;


trait GeneralTrait
{




    function checkAndUpdateArray(&$array, $value)
{
    $index = array_search($value, $array);
    if ($index !== false) {
        // Value exists, remove it
        unset($array[$index]);
    } else {
        // Value doesn't exist, add it
        $array[] = $value;
    }
}


    public function populateSelectorOption($data,$optionsList,$key,$value){

        if(isset($data) && count($data) > 0) {
            foreach ($data as $d) {
                $optionsList[$d->$key] = $d->$value;
            }
        }
        return $optionsList;

    }


    public function populateSpecialtiesOptions($specialties){
    return $this->populateSelectorOption(
          $specialties,
         [""=>""],
          "specialty",
           "specialty"
         );
  }



    public function populateDoctorsOptions($doctors){
     return  $this->populateSelectorOption(
            $doctors,
            [""=>__('selectors.default-option.doctors')],
            "id",
            "name"
           );
    }
 public function populateConsultationPlacesOptions($consultationPlaces){
  return  $this->populateSelectorOption(
            $consultationPlaces,
            [""=>__("selectors.default-option.c-places")],
             "id",
             "name"
           );
}


public function findAttributeKey($attributeToFind, $data) {
    foreach ($data as $key => $value) {
        if (strtolower($value) === strtolower($attributeToFind)) {
            return $key;
        }
    }

    return null; // Return null if no match is found
}


public function findSpecialtyKey($specialtyToFind) {
    $specialtyToFindLower = strtolower($specialtyToFind);
    $specialtyOptions = app('my_constants')['SPECIALTY_OPTIONS'];

    foreach (["ar", "fr", "en"] as $lang) {
        $foundKey = $this->findAttributeKey($specialtyToFindLower, $specialtyOptions[$lang]);
        if ($foundKey !== null) {
            return $foundKey;
        }
    }

    return null; // Return null if no match is found
}
public function findDairaKey($dairaToFind) {
    $dairaToFindLower = strtolower($dairaToFind);
    $dairaOptions = app('my_constants')['DAIRAS'];

    foreach (["ar", "fr", "en"] as $lang) {
        $foundKey = $this->findAttributeKey($dairaToFindLower, $dairaOptions[$lang]);
        if ($foundKey !== null) {
            return $foundKey;
        }
    }

    return null; // Return null if no match is found
}



}
