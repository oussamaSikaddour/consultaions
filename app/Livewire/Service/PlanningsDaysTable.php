<?php

namespace App\Livewire\Service;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use App\Models\ConsultationPlace;
use App\Models\Planning;
use App\Models\PlanningDay;
use App\Models\Service;
use App\Models\User;
use App\Traits\SortableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PlanningsDaysTable extends Component
{


    use WithPagination, SortableTrait;

    // Properties with default values
    public $serviceId = "";
    #[Url()]
    public $doctorId ="";
    #[Url()]
    public $dayAt= "";
    public $specialty="";
    #[Url()]
    public $consultationPlaceId = "";
    public $planningId = "";
    public $doctorsList=[];
    public $consultationPlacesList=[];
    public $establishmentSpecialtyList=[];
    public $planningsList=[];






    #[On('set-planning-id-externally')]
    public function setPlanningIdIdExternally($selectedValue){
        $this->planningId = $selectedValue;
   }

    public function updatedSpecialty()
    {
        $this->doctorId="";
        if(count($this->doctors()) > 0){
        $this->doctorsList = $this->doctors->map(function ($doctor) {
            return [$doctor->id, $doctor->name];
        })->prepend(["", "-- choisir un medecin --"]);

    } else{
      $this->doctorsList = [["", "-- choisir un medecin --"]];
    }
        $this->updateFilterData('doctorId',$this->doctorsList);
    }


    #[Computed()]
    public function doctors()
    {
        if(session()->has("establishment_id")){
        return User::where("userable_id",session("establishment_id"))->
        whereHas('occupations', function ($query) {
            $query->where('entitled', 'doctor')->where('specialty', 'like', "%{$this->specialty}%");
        })->whereHas('occupations', function ($query) {
            // Only consider the first occupation
            $query->take(1);
        })->get(['id', 'name']);
    }else{
        return [];
    }

    }

    #[Computed()]
    public function consultationsPlaces()
    {
        return  ConsultationPlace::get(['id', 'name']);

    }

    #[Computed()]
    public function specialties(){
        if(session()->has("establishment_id")){
        return Service::where("establishment_id",session('establishment_id'))->
          get(['specialty']);
        }
        else return [];
    }






    #[Computed]
    public function planningDays()
    {


                $query = PlanningDay::with(['planning', 'consultationPlace', 'doctor'])
                    ->leftJoin('plannings', 'planning_days.planning_id', '=', 'plannings.id')
                    ->leftJoin('consultation_places', 'planning_days.consultation_place_id', '=', 'consultation_places.id')
                    ->leftJoin('users', 'planning_days.doctor_id', '=', 'users.id');
                    if ($this->dayAt !== "") {
                        $query->where('day_at', $this->dayAt);
                    }
                    if($this->serviceId !==""){
                        $query->whereHas('planning', function ($query) {
                            $query->where('service_id',$this->serviceId);
                        });
                    }
                    if($this->consultationPlaceId !==""){
                        $query->whereHas('consultationPlace', function ($query) {
                            $query->where('id',$this->consultationPlaceId);
                        });
                    }
                    $query->whereHas('doctor', function ($query) {
                        if ($this->doctorId !== "") {
                            $query->where('id', $this->doctorId)
                            ->whereHas('occupations', function ($query) {
                                $query->where('entitled', 'doctor')
                                    ->where('specialty','like', '%' . $this->specialty . '%');
                            });
                        }else{
                        $query->whereHas('occupations', function ($query) {
                            $query->where('entitled', 'doctor')
                                ->where('specialty','like', '%' . $this->specialty . '%');
                        });
                        }
                    });

                    if ($this->planningId !== "") {
                        $query->where('planning_id', $this->planningId);
                    }



          $query->select('planning_days.*', 'users.name as doctor_name', 'plannings.name as planning_name', 'consultation_places.name as consultation_place_name');

            // Sort users based on other fields.
            $query->orderBy($this->sortBy, $this->sortDirection);

            // return $query->paginate($this->perPage);
            return $query->get();


    }




    public function generateExcel()
{
    // Your data retrieval logic, e.g., $tableData
    $tableData = $this->planningDays()->map(function ($pd) {
        return [
            'Date' => $pd->day_at,
            'Médecin'=>$pd->doctor_name,
            'planning'=> $pd->planning_name,
            "consultation Place"=>$pd->consultation_place_name,
            "nombre de consultaion"=>$pd->number_of_consultation,
            "nombre de rendez vous"=> $pd->number_of_rendez_vous,
            "date de creation"=> $pd->created_at->format('d/m/Y'),
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
                'Content-Disposition' => 'attachment; filename="planningDays.xlsx"',
            ]
        );
    } catch (\Exception $e) {
        // Handle errors and return an appropriate response
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    #[On("delete-planning-day")]
    public function deletePlanningDay(PlanningDay $pd)
    {
        try {
            $pd->delete();
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }


    public function mount()
    {


        if(count($this->specialties()) > 0){
        $this->establishmentSpecialtyList = $this->specialties->map(function ($s) {
            return [$s->specialty, $s->specialty];
        })->prepend(["", "-- choisir une specialté --"]);
        }

        if(count($this->doctors()) > 0){
        $this->doctorsList = $this->doctors->map(function ($doctor) {
            return [$doctor->id, $doctor->name];
        })->prepend(["", "-- choisir un medecin --"]);
          }
          if(count($this->consultationsPlaces()) > 0){
        $this->consultationPlacesList = $this->consultationsPlaces->map(function ($cp) {
            return [$cp->id, $cp->name];
        })->prepend(["", "-- choisir un lieu de consultation --"]);
     }

        // Add the second filter to $filters
            $this->initializeFilter('specialty', 'spécialité :', $this->establishmentSpecialtyList);
            $this->initializeFilter('doctorId', 'medecin', $this->doctorsList);
            $this->initializeFilter('consultationPlaceId', 'lieu de consultation', $this->consultationPlacesList);
    }

        public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }
    public function render()
    {
        return view('livewire.service.plannings-days-table');
    }
}
