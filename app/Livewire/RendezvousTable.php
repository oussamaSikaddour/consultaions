<?php

namespace App\Livewire;


use App\Models\ConsultationPlace;
use App\Models\Image;
use App\Models\PlanningDay;
use App\Models\RendezVous;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Traits\TableTrait;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mpdf\Mpdf;

class RendezvousTable extends Component
{

    use WithPagination, TableTrait,GeneralTrait;
    // Properties with default values
    public $serviceId = "";
    #[Url()]
    public $doctorId =null;
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
    public $type="";
    #[Url()]
    public $consultationPlaceId = "";
    public $medicalFileId = "";
    public $patient="";
    public $doctorsList=[];
    public $consultationPlacesList=[];
    public $showForDoctor=false;
    public $showForCPlaceAdmin=false;
    public $openedBy=null;



    public function resetFilters(){
        $this->dayAt="";
        $this->dateMin="";
        $this->dateMax="";
        $this->type="";
        $this->specialty="";
        $this->birthDate="";
        if(!$this->showForDoctor){
         $this->doctorId=null;
        }
        if(!$this->showForCPlaceAdmin){
         $this->consultationPlaceId="";
        }
        }


    public function updatedSpecialty()
    {
        $this->doctorsList = $this->populateDoctorsOptions($this->doctors());
        $this->updateFilterData('doctorId', $this->doctorsList);
    }

    #[Computed()]
    public function doctors()
    {

        $doctors= User::whereHas('occupations', function ($query) {
            $query->where('entitled', 'doctor')->where('specialty',$this->specialty);
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
        if(!$this->showForDoctor || !$this->showForCPlaceAdmin){
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
        if ($this->type !== "") {
                $query->where('rendez_vous.type', $this->type);
        }
        if($this->dayAt !==""){
            $query->where('rendez_vous.day_at', $this->dayAt);
        }

        if($this->dateMin !==""){
                $query->where('rendez_vous.day_at', '>=', $this->dateMin)
                      ->where('rendez_vous.day_at', '<=', date('Y-m-d', strtotime($this->dateMin . ' +30 days')));
        }
        if ($this->dateMin !== "" && $this->dateMax !== "") {
            $query->whereBetween('rendez_vous.day_at', [$this->dateMin, $this->dateMax]);
        }
       if($this->doctorId){
        $query->whereHas('doctor', function ($query)  {
            $query->where('id', $this->doctorId);
        });
       }
       if($this->consultationPlaceId !==""){
         $query->where('consultation_place_id', $this->consultationPlaceId);
       }


    if ($this->showForCPlaceAdmin || $this->showForDoctor) {
        $query->select(
            'rendez_vous.*',
            'medical_files.code as code',
            'medical_files.last_name as patient_last_name',
            'medical_files.first_name as patient_first_name',
            'medical_files.birth_date as patient_birth_date',
            'users.name as doctor_name',
            'users.email as doctor_email',
            'establishments.name as establishment_name',
            'consultation_places.name as cp_name',
        );
    } else {
        $query->select(
            'rendez_vous.*',
            'users.name as doctor_name',
            'establishments.name as establishment_name',
            'consultation_places.name as cp_name',
            "consultation_places.latitude as cp_latitude",
            "consultation_places.longitude as cp_longitude"
        );
    }
    $query->orderBy($this->sortBy, $this->sortDirection);

    return $query->get();
}



    #[On('set-medical-file-id-Externally')]
    public function setMedicalFileIdExternally($selectedValue){
        $this->medicalFileId = $selectedValue;
}





public function generateRendezVousExcel(){

    $rdFileName = $this->specialty ?: "mix-specialties";

    $rdFileName = $rdFileName . "-" . now()->format('Y-m-d'); // Format includes year, month, and day

    return $this->generateExcel(function() {
        return $this->rendezVous()->map(function ($r) {
            return [
                __('tables.rendez-vous.mf-code')=>$r->code,
                __('tables.rendez-vous.patient-l-name')=>$r->patient_last_name,
                __('tables.rendez-vous.patient-l-name')=>$r->patient_first_name,
               __('tables.rendez-vous.birth-d') => $r->patient_birth_date,
                __('tables.rendez-vous.date')=>$r->day_at,
                __('tables.rendez-vous.type')=> app('my_constants')['RENDEZ_VOUS_TYPE'][app()->getLocale()][$r->type],
                 __('tables.rendez-vous.specialty')=>
                                                   app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()][$r->specialty],
               __('tables.rendez-vous.doctor')=> $r->doctor_name,
                __('tables.rendez-vous.d-email') =>$r->doctor_email,
                __('tables.rendez-vous.establishment') =>$r->establishment_name,
                __('tables.rendez-vous.c-place')=> $r->cp_name
            ];
        })->toArray();
    }, $rdFileName);
}


public function printConfirmationPdf($rendezVousData)
{
   try {
        $mpdf = new Mpdf();
        $html = view("pdfs.".app()->getLocale() .".rendez-vous", compact('rendezVousData'))->render();
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
    #[On("delete-rendez-vous")]
    public function deleteRendezVous(RendezVous $rd)
    {
        try {
            DB::beginTransaction();
            $planningDay = PlanningDay::findOrFail($rd->planning_day_id);
            $today = new DateTime();
            $futureDate = new DateTime($planningDay->day_at);
            $futureDate->modify('-3 days');
            if ( $today <= $futureDate) {
                if ($rd->type === 'normal') {
                    $planningDay->number_of_rendez_vous -= 1;
                    if ($planningDay->number_of_consultation > $planningDay->number_of_rendez_vous) {
                        $planningDay->state = 'incomplete';
                        $planningDay->save();
                    }
                }
                Image::where('imageable_id', $rd->id)
                ->where('imageable_type', 'App\Models\RendezVous')
                ->each(function ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                });
                $rd->delete();
            } else {
                throw new \Exception(__("tables.rendez-vous.delete-err"));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction if an error occurs
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }

    public function mount()
    {

        if($this->showForDoctor || $this->showForCPlaceAdmin){
            $this->dayAt= now()->toDateString();
           }


           $this->initializeFilter(
            'type',
             __('tables.rendez-vous.filters.type'),
            app('my_constants')['RENDEZ_VOUS_TYPE'][app()->getLocale()]);


           if(!$this->showForCPlaceAdmin){
          $this->consultationPlacesList= $this->populateConsultationPlacesOptions($this->consultationsPlaces());
          $this->initializeFilter(
            'consultationPlaceId',
            __('tables.rendez-vous.filters.c-place'),
            $this->consultationPlacesList);
          }

         $this->initializeFilter(
          'specialty',
         __('tables.rendez-vous.filters.specialty'),
          app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()]);

            if(!$this->showForDoctor){
                $this->doctorsList = $this->populateDoctorsOptions($this->doctors());
             $this->initializeFilter(
                        'doctorId',
                        __('tables.rendez-vous.filters.doctor'),
                      $this->doctorsList);

            }
        }
    public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }
    public function render()
    {
        return view('livewire.rendezvous-table');
    }
}
