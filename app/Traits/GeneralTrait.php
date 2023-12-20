<?php

namespace App\Traits;

trait GeneralTrait
{
    public function populateSelectorOption($data,$mappingFunction,$emptyOptionText){
        $options =[];
        if(count($data) > 0) {
            $options = $data->map($mappingFunction)->prepend(["", "-- {$emptyOptionText} --"]);
        }else{
          $options =[["", "-- {$emptyOptionText} --"]];
        }
        return $options;
    }


    public function populateDoctorsOptions($doctors){
        $this->doctorsOptions = $this->populateSelectorOption(
            $doctors,
            fn($d) => [$d->id, $d->name],
             "choisir un médecin"
           );
    }
 public function populateConsultationPlacesOptions($consultationPlaces){
        $this->consultationPlaceOptions = $this->populateSelectorOption(
            $consultationPlaces,
            function ($cp) {
                              return [$cp->id, $cp->name];
                             },
            "choisir un lieu de consultation");
}

}
