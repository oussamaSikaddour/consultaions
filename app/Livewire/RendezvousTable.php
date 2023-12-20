<?php

namespace App\Livewire;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use App\Models\ConsultationPlace;
use App\Models\Planning;
use App\Models\RendezVous;
use App\Models\User;
use App\Traits\SortableTrait;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mpdf\Mpdf;

class RendezvousTable extends Component
{

    use WithPagination, SortableTrait;
    // Properties with default values
    public $serviceId = "";
    #[Url()]
    public $doctorId =null;
    #[Url()]
    public $code ="";
    #[Url()]
    public $dayAt= "";
    #[Url()]
    public $dateMin= "";
    #[Url()]
    public $dateMax= "";
    #[Url()]
    public $specialty="";
    #[Url()]
    public $birthDate="";
    #[Url()]
    public $consultationPlaceId = "";
    public $medicalFileId = "";
    public $patient="";
    public $doctorsList=[];
    public $consultationPlacesList=[];
    public $showMoreDetails=false;
    public $dontShowForDoctor=false;
    public $openedBy=null;

    public function updatedSpecialty()
    {
              if(count($this->doctors()) > 0){
               $this->doctorsList = $this->doctors->map(function ($doctor) {
                return [$doctor->id, $doctor->name];
                })->prepend(["", "-- choisir un medecin --"]);
              }else{
                $this->doctorsList =[["", "-- choisir un medecin --"]];
             }
        $this->updateFilterData('doctorId',$this->doctorsList);
    }

    #[Computed()]
    public function doctors()
    {

        $doctors= User::whereHas('occupations', function ($query) {
            $query->where('entitled', 'doctor')->where('specialty', 'like', "%{$this->specialty}%");
        })->whereHas('occupations', function ($query) {
            // Only consider the first occupation
            $query->take(1);
        })->get(['id', 'name']);
       return $doctors;

    }
    #[Computed()]
    public function consultationsPlaces()
    {
        return  ConsultationPlace::get(['id', 'name']);

    }




#[Computed]
public function rendezVous()
{
    $query = RendezVous::query()
        ->with([
            'patient',
            'doctor',
            'consultationPlace',
            'referralLetter'
        ])
        ->leftJoin('medical_files', 'rendez_vous.patient_id', '=', 'medical_files.id')
        ->leftJoin('establishments', 'medical_files.establishment_id', '=', 'establishments.id')
        ->leftJoin('consultation_places',
        'rendez_vous.consultation_place_id', '=', 'consultation_places.id')
        ->leftJoin('users', 'rendez_vous.doctor_id', '=', 'users.id')
        ->leftJoin('occupations', 'users.id', '=', 'occupations.user_id')
        ->leftJoin('personnel_infos', 'users.id', '=', 'personnel_infos.user_id');
        if($this->medicalFileId !==""){
            $query->where('patient_id', $this->medicalFileId);
        }
        if ($this->patient !=="") {
            $query->whereHas('patient', function ($query) {
                $query->where('last_name', 'LIKE', '%' . $this->patient . '%')
                    ->orWhere('first_name', 'LIKE', '%' . $this->patient . '%');
            });
        }
        if($this->openedBy){
            $query->whereHas('patient', function ($query) {
                $query->where('opened_by', $this->openedBy);
            });
        }
        if ($this->specialty !== "") {
                $query->where('rendez_vous.specialty', $this->specialty);
        }
        if($this->dayAt !==""){
            $query->where('rendez_vous.day_at', $this->dayAt);
        }
        if ($this->dateMin !== "" && $this->dateMax !== "") {
            $query->whereBetween('rendez_vous.day_at', [$this->dateMin, $this->dateMax]);
        }elseif($this->dateMin !==""){
                $query->where('rendez_vous.day_at', '>=', $this->dateMin)
                      ->where('rendez_vous.day_at', '<=', date('Y-m-d', strtotime($this->dateMin . ' +30 days')));
        }
       if($this->doctorId){
        $query->whereHas('doctor', function ($query)  {
            $query->where('id', $this->doctorId);
        });
       }
       if($this->consultationPlaceId !==""){
        $query->whereHas('planningDay', function ($query)  {
            $query->where('consultation_place_id', $this->consultationPlaceId);
        });
       }


    if ($this->showMoreDetails) {
        $query->select(
            'rendez_vous.*',
            'medical_files.code as code',
            'medical_files.last_name as patient_last_name',
            'medical_files.first_name as patient_first_name',
            'medical_files.birth_date as patient_birth_date',
            'users.name as doctor_name',
            'users.email as doctor_email',
            'personnel_infos.tel as doctor_phone',
            'establishments.name as establishment_name',
            'consultation_places.name as cp_name',
        );
    } else {
        $query->select(
            'rendez_vous.*',
            'users.name as doctor_name',
            'establishments.name as establishment_name',
            'consultation_places.name as cp_name',
        );
    }
    $query->orderBy($this->sortBy, $this->sortDirection);

    return $query->get();
}



    #[On('set-medical-file-id-Externally')]
    public function setMedicalFileIdExternally($selectedValue){
        $this->medicalFileId = $selectedValue;
}


    public function generateExcel()
{
    // Your data retrieval logic, e.g., $tableData
    $tableData = $this->rendezVous()->map(function ($r) {
        return [
            "code patient"=>$r->code,
            "nom patient"=>$r->patient_last_name,
            "prénom patient"=>$r->patient_first_name,
            "date de naissance" => $r->patient_birth_date,
            "date rendez vous"=>$r->day_at,
            "spécialité"=> $r->specialty,
            "nom Médecin" => $r->doctor_name,
            "email Médecin" =>$r->doctor_email,
            "numéro médecin" => $r->doctor_phone,
            "établissement" =>$r->establishment_name,
            "lieu de consultation"=> $r->cp_name
        ];
    })->toArray();

    try {
        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        // Define styles for header row
        $headerStyle = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DDDDDD']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];

        // Add headers to the spreadsheet
        $columnIndex = 'A';
        foreach (array_keys($tableData[0]) as $header) {
            $activeWorksheet->setCellValue($columnIndex . '1', $header);
            $activeWorksheet->getStyle($columnIndex . '1')->applyFromArray($headerStyle);
            $columnIndex++;
        }

        // Add data rows
        $rowIndex = 2;
        foreach ($tableData as $row) {
            $columnIndex = 'A';
            foreach ($row as $cellValue) {
                $activeWorksheet->setCellValue($columnIndex . $rowIndex, $cellValue);
                $columnIndex++;
            }
            $rowIndex++;
        }

        // Send the spreadsheet as a downloadable file
        $writer = new Xlsx($spreadsheet);

        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="rendezvous.xlsx"',
            ]
        );
    } catch (\Exception $e) {
        // Handle errors and return an appropriate response
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function printConfirmationPdf($rendezVousData)
{
    try {
        $mpdf = new Mpdf();
        $html = view("pdfs.rendez-vous", compact('rendezVousData'))->render();
        $mpdf->WriteHTML($html);
        $tempDir = storage_path('app/temp/');
        if (!File::isDirectory($tempDir)) {
            File::makeDirectory($tempDir, 0755, true, true); // Create the directory recursively
        }
        $tempFilePath = $tempDir . 'rendezvous.pdf';
        $mpdf->Output($tempFilePath, \Mpdf\Output\Destination::FILE);
        return response()->download($tempFilePath, 'rendezvous.pdf')
            ->deleteFileAfterSend(true);
    } catch (\Exception $e) {
        $this->dispatch('open-errors', [$e->getMessage()]);
    }
}
    #[On("delete-rendezvous")]
    public function deleteRendezVous(RendezVous $rd)
    {
        try {
            $rd->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }


    public function mount()
    {
        if($this->showMoreDetails){
            $this->dayAt= now()->toDateString();
           }
        if($this->dontShowForDoctor === false){
            if(count($this->doctors()) > 0){
                $this->doctorsList = $this->doctors->map(function ($doctor) {
                    return [$doctor->id, $doctor->name];
                })->prepend(["", "-- choisir un medecin --"]);
         }

         $this->initializeFilter('specialty', 'spécialité de service', app('my_constants')['SPECIALTY_OPTIONS']);
         $this->initializeFilter('doctorId', 'medecin', $this->doctorsList);
        }
        if(count($this->consultationsPlaces()) >0){
        $this->consultationPlacesList = $this->consultationsPlaces->map(function ($cp) {
            return [$cp->id, $cp->name];
        })->prepend(["", "-- choisir un lieu de consultation --"]);
        $this->initializeFilter('consultationPlaceId', 'lieu de consultation',  $this->consultationPlacesList);}
        }
    public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }
    public function render()
    {
        return view('livewire.rendezvous-table');
    }
}
