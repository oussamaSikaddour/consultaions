<?php

namespace App\Imports;

use App\Models\ConsultationPlace;
use App\Rules\DairaExists;
use App\Rules\LandLineNumberExist;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CPlaceImport implements ToModel, WithHeadingRow
{
    use GeneralTrait;
    public function model(array $row, int $lineNumber = null)
    {
        $validator = Validator::make($row, [
            'daira' => ['required','string','min:3','max:100',new DairaExists],
            'nom_du_lieu_des_consultations' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('consultation_places','name')->where(function ($query) use($row) {
                    return $query->where('daira', $row['daira']);
                }),
            ],
            'adresse' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('consultation_places','address')->where(function ($query)use($row){
                    return $query->where('daira', $row['daira']);
                }),
            ],

            'latitude' => [
                'required',
                'string',
                'min:5',
                'max:25',
                Rule::unique('consultation_places','latitude')->where(function ($query)use($row){
                    return $query->where('longitude', $row['longitude']);
                })->whereNull('deleted_at'),

            ],
            'longitude' => [
                'required',
                'string',
                'min:3',
                'max:25',
                Rule::unique('consultation_places','longitude')->where(function ($query)use($row){
                    return $query->where('latitude', $row['latitude']);
                })->whereNull('deleted_at'),

            ],
            'numero_de_telephone_fixe' => [
                'required',
                'digits:9',
                new LandLineNumberExist(new ConsultationPlace())
            ],
            'numero_de_fax' => [
                'nullable',
                'digits:9',
                new LandLineNumberExist(new ConsultationPlace())
            ],
        ]);


        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $lineNumberErrorMessage=__("imports.line-number-error").$lineNumber;
            throw new \Exception( implode("\n", $errorMessages).$lineNumberErrorMessage);
        }

        // Create a new instance of the Establishment model and assign validated data to its properties
        $cPlace = new ConsultationPlace([
            'daira' => $this->findDairaKey($row['daira']),
            'name' => $row['nom_du_lieu_des_consultations'],
            'address' => $row['adresse'],
            "latitude"=>$row['latitude'],
            "longitude"=>$row['longitude'],
            'tel' => $row['numero_de_telephone_fixe'],
            'fax' => $row['numero_de_fax'] ?? null,
        ]);

        return $cPlace; // Return the model instance after successful validation
    }


}
