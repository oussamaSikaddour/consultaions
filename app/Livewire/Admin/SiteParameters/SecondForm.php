<?php

namespace App\Livewire\Admin\SiteParameters;

use App\Livewire\Forms\Admin\SiteParameters\SecondForm as SiteParametersSecondForm;
use Livewire\Component;
use Symfony\Component\Process\Process;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Storage;

class SecondForm extends Component
{


    public GeneralSetting $generalSettings;
    public SiteParametersSecondForm $form;

    public function downloadDatabase()
    {
        try {
            // Empty the Consultations directory, preserving the directory itself
            Storage::disk('local')->deleteDirectory('Consultations', true);

            $projectPath = base_path();
            $command = "php {$projectPath}/artisan backup:run";
            $process = Process::fromShellCommandline($command);
            $process->mustRun();

            $backupFiles = Storage::disk('local')->files('Consultations');
            $latestBackup = end($backupFiles);

            return Storage::download($latestBackup);

        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
    }



    public function updateMaintenanceOnKeydownEvent($state){
      $this->form->maintenance=$state;
    }
    public function mount()
    {
            try {
                $this->generalSettings = GeneralSetting::firstOrFail();
                $this->form->fill([
                    'maintenance' => $this->generalSettings->maintenance,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }

    }

    public function handleSubmit()
    {

        $response =  $this->form->save($this->generalSettings);
       if ($response['status']) {
        $this->dispatch('open-toast', $response['success']);
       }else{
         $this->dispatch('open-errors', [$response['error']]);
         }
    }



    public function render()
    {
        return view('livewire.admin.site-parameters.second-form');
    }
}
