<?php

namespace App\Enums;

enum RoutesNamesEnum: string {
    const USER_ROUTE = 'home';
    const ADMIN_ROUTE = 'dashboard';
    const ESTABLISHMENT_ROUTE = 'establishments';
    const SERVICE_ROUTE = 'service';
    const PLACE_Of_CONSULTATION_ROUTE = 'place-of-consultation';
    const DOCTOR_ROUTE = 'doctor';
}
