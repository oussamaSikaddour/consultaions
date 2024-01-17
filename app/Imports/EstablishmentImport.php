<?php

namespace App\Imports;

use App\Models\Establishment; // Update the namespace based on your application structure
use App\Rules\LandLineNumberExist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EstablishmentImport implements ToModel, WithHeadingRow
{
    public function model(array $row, int $lineNumber = null)
    {
        $validator = Validator::make($row, [
            'abreviation_du_nom' => [
                'required',
                'string',
                 "max:10",
                Rule::unique('establishments', 'acronym')
                    ->whereNull('deleted_at'),
            ],
            'nom' => [
                'required',
                'string',
                 "max:255",
                Rule::unique('establishments', 'name')
                    ->whereNull('deleted_at'),
            ],
            'email'  => [
                'required',
                'email',
                 "max:255",
                Rule::unique('establishments', 'email')
                    ->whereNull('deleted_at'),
            ],
            'adresse' => [
                'required',
                'string',
                 "max:255",
                Rule::unique('establishments', 'address')
                    ->whereNull('deleted_at'),
            ],
            'numero_du_fix' =>
            ['required','digits:9',
            new LandLineNumberExist(new Establishment())],
            'numero_du_fax' =>[
                'required',
                'digits:9',
                new LandLineNumberExist(new Establishment())]
        ]);


        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            $lineNumberErrorMessage=__("imports.line-number-error").$lineNumber;
            throw new \Exception( implode("\n", $errorMessages).$lineNumberErrorMessage);
        }

        // Create a new instance of the Establishment model and assign validated data to its properties
        $establishment = new Establishment([
            'acronym' => $row['abreviation_du_nom'],
            'name' => $row['nom'],
            'email' => $row['email'],
            'address' => $row['adresse'],
            'tel' => $row['numero_du_fix'],
            'fax' => $row['numero_du_fax'] ?? null,
        ]);

        return $establishment; // Return the model instance after successful validation
    }


}
