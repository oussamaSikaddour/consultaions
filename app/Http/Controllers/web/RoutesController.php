<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutesController extends Controller
{




public function showAdminPage()
{
$title = "Dashboard";
$modalData= [
             "title"=>"Ajout d'un établissement",
              "component"=>[
                           "name"=>'admin.establishment-modal',
                            "parameters"=> []
                           ]
             ];

 return view('pages.admin.dashboard',compact('title','modalData'));
 }

public function showSiteParametersPage()
{
$title = "site parameters";
 return view('pages.admin.site-parameters',compact('title'));
 }




public function showUsersPage()
{
$title = "Users";
$modalData= [
             "title"=>"Ajout d'un administrateur d'application",
              "component"=>[
                           "name"=>'user-modal',
                            "parameters"=> ['userableId'=>'1','userableType'=>'admin']
                           ]
             ];

return view('pages.admin.users',compact('title','modalData'));
 }



public function showUserPage()
 {
    $title = "Mes rendez-vous";
    $openedBy= auth()->id();
    $modalData= [
                "title"=>"Ajout d'un dossier médical",
                  "component"=>[
                      "name"=>'user.medical-file-modal',
                       "parameters"=> []
                      ]
                ];
 return view('pages.user.home',compact('title','modalData','openedBy'));
 }


public function showEstablishmentPage($id = null)
{
        $title = "Établissement";
        $modalData= [
                     "title"=>"Ajout d'un service",
                      "component"=>[
                                   "name"=>'establishment.service-modal',
                                    "parameters"=> ['establishmentId'=>$id]
                                   ]
                     ];
        return view('pages.establishments.establishments',compact('title','modalData','id'));
 }




public function showServicePage($id = null)
{
    $title = "Service";
    $modalData= [
                 "title"=>"Ajout de la planification des consultations",
                  "component"=>[
                               "name"=>'service.planning-modal',
                                "parameters"=> ['serviceId'=>$id]
                               ]
                 ];


        return view('pages.services.service',compact('title','modalData','id'));
}

public function showDoctorsPage($establishmentId=null)
{
$title = "Médecins";
$modalData= [
             "title"=>"Ajout de médecin",
              "component"=>[
                           "name"=>'user-modal',
                            "parameters"=> ['userableId'=>$establishmentId,'userableType'=>'doctor']
                           ]
             ];

return view('pages.services.doctors',compact('title','modalData',"establishmentId"));
 }

public function showPlaceOfConsultationPage()
{
    $title = "Lieux de consultations";
    $modalData= [
                 "title"=>"Ajout d'un lieu de consultation",
                  "component"=>[
                               "name"=>'establishment.consultations-place-modal',
                                "parameters"=> []
                               ]
                 ];
    return view('pages.establishments.consultationsPlaces',compact('title','modalData'));
}
public function showPlaceOfConsultationAdminPage($id = null)
{
    $title = "Consultation place";
    return view('pages.consultations-places.admin',compact('title','id'));
}



public function showDoctorPage()
{
    $title = "Médecin";
    $showForDoctor=true;
    $userId=auth()->id();
    return view('pages.doctor.doctor',compact('title','userId','showForDoctor'));
}
}
