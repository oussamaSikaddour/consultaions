<?php

namespace App\Livewire;

use App\Models\User;
use App\Traits\SortableTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class UsersTable extends Component
{
use WithPagination, SortableTrait;
#[Url()]
public $fullName = "";
#[Url()]
public $perPage = 1;
#[Url()]
public $userableType="";
#[Url()]
public $userableId=null;
#[Url()]
public $specialty="";
#[Url()]
public $email = "";
public $noUserFoundMessage="Pour le moment, aucun utilisateur n'a été trouvé.";
public $showForSuperAdmin=false;
public $showForAdminService=false;




public function mount()
{




if($this->userableType === "doctor"){
    $this->initializeFilter('specialty', 'spécialité de service :',app('my_constants')['SPECIALTY_OPTIONS']);
}

if($this->showForSuperAdmin  ){
    $this->initializeFilter(
        'userableType',
        "type d'utilisateur :",
        [
            ['',"--- choisissez un type d'utilisateur ---"],
            ['admin','administrateur'],
            ['user','utilisateur'],
            ['doctor','médecin'],
            ['admin_place_of_consultation','administrateur du lieu de consultation'],
            ['admin_establishment',"administrateur de l'établissement"],
            ['admin_service','administrateur de service'],
        ]
);
}

}
#[On('set-userable-id-Externally')]
public function setUserableIdExternally($selectedValue){
$this->userableId = $selectedValue;
}


#[Computed]
public function users()
{
        $query = User::query();
        $query->leftJoin('personnel_infos', 'users.id', '=', 'personnel_infos.user_id');
        if($this->userableType ==="doctor"){
            $query->leftJoin('occupations', 'users.id', '=', 'occupations.user_id');
        }
        if ($this->userableType !== "") {
            $query->where('userable_type', $this->userableType);
        }

        if ($this->userableId !== null || !$this->showForSuperAdmin) {
            $query->where('userable_id', $this->userableId);
        }

        $query->where('email', 'like', "%{$this->email}%");
        $query->where('name', 'like', "%{$this->fullName}%");

        if($this->specialty !==""){
            $query->whereHas('occupations', function ($query) {
                $query->where('specialty',$this->specialty);
            })->whereHas('occupations', function ($query) {
                $query->take(1);
            });
        }

        if($this->userableType ==="doctor"){
            $query->select('users.*', 'personnel_infos.last_name', 'personnel_infos.first_name', 'personnel_infos.tel','occupations.specialty');
        }else{
            $query->select('users.*', 'personnel_infos.last_name', 'personnel_infos.first_name', 'personnel_infos.tel');
        }


        // Sort users based on other fields.
        $query->orderBy($this->sortBy, $this->sortDirection);

        // return $query->paginate($this->perPage);
        return $query->get();


}





public function updatedPerPage()
{
    $this->resetPage();
}

public function generateExcel()
{
    // Your data retrieval logic, e.g., $tableData
    $tableData = $this->users()->map(function ($user) {
        return [
            'Name' => $user->name,
            'Email' => $user->email,
             'Registerd At'=>$user->created_at,
             'télephone'=>$user->tel,
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
                'Content-Disposition' => 'attachment; filename="users.xlsx"',
            ]
        );
    } catch (\Exception $e) {
        // Handle errors and return an appropriate response
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


#[On("delete-user")]
public function deleteUser(User $user){
    $user->delete();
}


public function placeholder(){

    return view('components.loading',['variant'=>'l']);
}


public function render()
    {
        return view('livewire.users-table');
    }
}
