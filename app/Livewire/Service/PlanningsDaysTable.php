<?php

namespace App\Livewire\Service;


use App\Models\ConsultationPlace;
use App\Models\Planning;
use App\Models\PlanningDay;
use App\Models\Service;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PlanningsDaysTable extends Component
{


    use WithPagination,GeneralTrait,TableTrait;

    // Properties with default values
    public $serviceId = "";
    #[Url()]
    public $doctorId ="";
    #[Url()]
    public $dayAt= "";
    public $specialty="";
    #[Url()]
    public $consultationPlaceId = "";
    public $planningId ="unknown";
    public $doctorsList=[];
    public $consultationPlacesList=[];
    public $establishmentSpecialtyList=[];
    public $planningsList=[];
    public $showForCoordService= false;




    public function resetFilters(){
  $this->dayAt="";
  $this->specialty="";
  $this->doctorId="";
  $this->consultationPlaceId="";
    }


    #[On('set-planning-id-externally')]
    public function setPlanningIdIdExternally($selectedValue){
        $this->planningId = $selectedValue;
   }

    public function updatedSpecialty()
    {
        $this->doctorsList = $this->populateDoctorsOptions($this->doctors());
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
    }

    }

    #[Computed()]
    public function consultationsPlaces()
    {
        return  ConsultationPlace::get(['id', 'name']);

    }

    #[Computed()]
    public function specialties(){
   return Service::where("establishment_id",session('establishment_id'))->
    get(['specialty']);
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

                    if (!$this->showForCoordService || $this->planningId)
                      {

                        $query->where('planning_id', $this->planningId);
                    }

          $query->select('planning_days.*', 'users.name as doctor_name', 'consultation_places.name as consultation_place_name');
            // Sort users based on other fields.
            $query->orderBy($this->sortBy, $this->sortDirection);
            // return $query->paginate($this->perPage);
            return $query->get();
    }




    public function generatePlanningDaysExcel(){
        $planningFileName = "planning"; // Default value if $this->planningId is not truthy

        if($this->planningId){
            $planning = Planning::find($this->planningId);
            $planningFileName = $planning ? str_replace(' ', '_', $planning->name) : "planning";
        }

        return $this->generateExcel(function() {
            return $this->planningDays()->map(function ($pd) {
                return [
                    __('tables.planning-days.date') => $pd->day_at,
                    __('tables.planning-days.doctor') => $pd->doctor_name,
                    __('tables.planning-days.c-place') => $pd->consultation_place_name,
                    __('tables.planning-days.c-number') => $pd->number_of_consultation,
                ];
            })->toArray();
        }, $planningFileName);
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
        $this->establishmentSpecialtyList=
        $this->populateSpecialtiesOptions($this->specialties());
       $this->doctorsList = $this->populateDoctorsOptions($this->doctors());
       $this->consultationPlacesList = $this->populateConsultationPlacesOptions($this->consultationsPlaces());

        // Add the second filter to $filters
            $this->initializeFilter(
            'specialty',
           __('tables.planning-days.filters.specialty'),
             $this->establishmentSpecialtyList,
             "specialty");
            $this->initializeFilter(
            'doctorId',
            __('tables.planning-days.filters.doctor'),
             $this->doctorsList);
            $this->initializeFilter(
                'consultationPlaceId',
                __('tables.planning-days.filters.c-place'),
                $this->consultationPlacesList);

    }

        public function placeholder(){

        return view('components.loading',['variant'=>'l']);
    }
    public function render()
    {
        return view('livewire.service.plannings-days-table');
    }
}
