<?php

namespace App\Imports;

use App\Models\Service;
use App\Rules\DairaExists;
use App\Rules\ServiceSpecialtyExists;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ServiceImport implements ToModel, WithHeadingRow
{
    use GeneralTrait;
    public function model(array $row, int $lineNumber = null)
    {
        $validator = Validator::make($row, [
            'nom_du_service' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('services','name')->where(function ($query) {
                    return $query->where('establishment_id',session('establishment_id'));
                })->whereNull('deleted_at'),
            ],
            'specialite_de_service' => [
                'required',
                'string',
                'min:5',
                'max:255',
                 new ServiceSpecialtyExists
            ],
            'chef_de_service'  => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('services','head_of_service')->where(function ($query)  {
                    return $query->where('establishment_id', session('establishment_id'));
                })->whereNull('deleted_at'),
            ],
        ]);


        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $lineNumberErrorMessage=__("imports.line-number-error").$lineNumber;
            throw new \Exception( implode("\n", $errorMessages).$lineNumberErrorMessage);
        }



        // Create a new instance of the Establishment model and assign validated data to its properties
        $service = new Service([
            'establishment_id' =>  session('establishment_id'),
            'name' => $row['nom_du_service'],
            'specialty'=>$this->findSpecialtyKey($row['specialite_de_service']),
            'head_of_service'=>$row['chef_de_service']
        ]);

        return $service; // Return the model instance after successful validation
    }


}
