<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutesController extends Controller
{




public function showAdminPage()
{
$title =__("pages.dashboard.page-title");
$modalData= [
             "title"=>__("pages.dashboard.add-establishment-btn-text"),
              "component"=>[
                           "name"=>'admin.establishment-modal',
                            "parameters"=> []
                           ]
             ];

 return view('pages.admin.dashboard',compact('title','modalData'));
 }

public function showSiteParametersPage()
{
$title =__("pages.site-params.page-title");
 return view('pages.admin.site-parameters',compact('title'));
 }




public function showUsersPage()
{
$title =__("pages.users.page-title");
$modalData= [
             "title"=>"modals.user.for.add-super-admin",
              "component"=>[
                           "name"=>'user-modal',
                            "parameters"=> ['userableId'=>'1','userableType'=>'admin']
                           ]
             ];

return view('pages.admin.users',compact('title','modalData'));
 }



public function showUserPage()
 {

    $title =__("pages.rendez-vous.page-title");
    $openedBy= auth()->id();
    $modalData= [
                "title"=>'modals.m-file.for.add',
                  "component"=>[
                      "name"=>'user.medical-file-modal',
                       "parameters"=> []
                      ]
                ];
 return view('pages.user.home',compact('title','modalData','openedBy'));
 }


public function showEstablishmentPage()
{

     $title =__("pages.establishment.page-title");

    $id=session('establishment_id');

        $modalData= [
                     "title"=>__("pages.establishment.add-service-btn-txt"),
                      "component"=>[
                                   "name"=>'establishment.service-modal',
                                    "parameters"=> ['establishmentId'=>$id]
                                   ]
                     ];
        return view('pages.establishments.establishments',compact('title','modalData','id'));
 }




public function showServicePage()
{

    $title =__("pages.services.page-title");
    $id=session('service_id');
    $modalData= [
                 "title"=>"modals.planning.for.add",
                  "component"=>[
                               "name"=>'service.planning-modal',
                                "parameters"=> ['serviceId'=>$id]
                               ]
                 ];


        return view('pages.services.service',compact('title','modalData','id'));
}

public function showDoctorsPage()
{
    $title =__("pages.doctors.page-title");

$establishmentId=session('establishment_id');
$modalData= [
             "title"=>"modals.user.for.add-doctor",
              "component"=>[
                           "name"=>'user-modal',
                            "parameters"=> ['userableId'=>$establishmentId,'userableType'=>'doctor']
                           ]
             ];

return view('pages.services.doctors',compact('title','modalData',"establishmentId"));
 }

public function showPlaceOfConsultationPage()
{
    $title =__("pages.consultation-places.page-title");
    $modalData= [
                 "title"=>"modals.c-place.for.add",
                  "component"=>[
                               "name"=>'establishment.consultations-place-modal',
                                "parameters"=> []
                               ]
                 ];
    return view('pages.establishments.consultationsPlaces',compact('title','modalData'));
}
public function showPlaceOfConsultationAdminPage()
{
$title =__("pages.consultations-place.page-title");
$id=session('consultation_place_id');
return view('pages.consultations-places.admin',compact('title','id'));
}



public function showDoctorPage()
{
    $title = __("pages.doctor.page-title");
    $showForDoctor=true;
    $userId=auth()->id();
    return view('pages.doctor.doctor',compact('title','userId','showForDoctor'));
}
}
