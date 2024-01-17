<?php

return [
    "common" => [
        "submit-btn" => "Enregistrer"
    ],
    "user" => [
        "l-name" => "Nom de famille",
        "f-name" => "Prénom",
        "specialty" => "Spécialité",
        "b-date" => "Date de naissance",
        "email" => "Email",
        "tel" => "Numéro de téléphone",
        "h3" => "L'email doit être valide, un code de vérification y sera envoyé",
        "for" => [
            "add-super-admin" => "Ajouter un Super Admin",
            "add-coord-service" => "Ajouter un coordinateur de service",
            "add-coord-c-place" => "Ajouter un coordinateur de lieu de consultation",
            "add-doctor" => "Ajouter un Docteur",
            "add-admin-establishment" => "Ajouter un Administrateur d'établissement",
            "update-user" => "Mettre à jour"
        ]
    ],

    "role"=>[
        "for"=>[
            "manage"=>"Gérer les rôles"
        ]
        ],
    "establishment" => [
        "acronym" => "Abréviation du nom",
        "name" => "Nom",
        "email" => "Email",
        "address" => "Adresse",
        "land-line-number" => "Numéro de téléphone fixe",
        "fax-number" => "Numéro de fax",
        "for" => [
            "add" => "Ajouter un établissement",
            "update" => "Mettre à jour l'établissement"
        ]
    ],
    "service" => [
        "name" => "Nom du service",
        "head-service" => "Chef du service",
        "specialty" => "Spécialité du service :",
        "for" => [
            "add" => "Ajouter un service",
            "update" => "Mettre à jour le service"
        ]
    ],

    "c-place" => [

        "name" => "Nom du lieu des consultations",
        "address" => "Adresse",
        "land-line-number" => "Numéro de téléphone fixe",
        "fax-number" => "Numéro de fax",
        "daira" => "Daïra :",
        "latitude"=>"Latitude",
        "longitude"=>"Longitude",
        "for" => [
            "add" => "Ajouter un lieu des consultations",
            "update" => "Mettre à jour le lieu des consultations"
        ]
    ],

    "m-file"=>[
        "birth-d" => "Date de naissance",
        "l-name" => "Nom de famille",
        "f-name" => "Prénom",
        "phone-number" => "Numéro de téléphone",
        "address" => "Adresse",
        "for" => [
            "add" => "Ajouter un dossier médical",
            "update" => "Mettre à jour le dossier médical"
        ],
    ],
     "planning"=> [
        "name" => "Nom du planning",
        "year" => "Année :",
        "state" => "État :",
        "month" => "Mois :",

     ],
     "planning-day"=>[
        "doctor-c-place-err" => "Vous ne pouvez pas ajouter un jour de planification pour le moment. Vous devez ajouter au moins un médecin et un lieu de consultation.",
        "doctor-err" => "Vous ne pouvez pas ajouter un jour de planification pour le moment. Vous devez ajouter au moins un médecin.",
        "c-place-err" => "Vous ne pouvez pas ajouter un jour de planification pour le moment. Vous devez ajouter au moins un lieu de consultation.",
        "specialty" => "Spécialité :",
        "doctor" => "Médecin :",
        "c-place" => "Lieu de consultations :",
        "date" => "La Date",
        "c-number" => "Nombre de consultations",
        "for" => [
            "add" => "Ajouter un jour de planification",
            "update" => "Mettre à jour le jour de planification",
        ],
    ],
    "rendez-vous" => [
        "date" => "Date du rendez-vous",
        "start-d" => "Date de début",
        "end-d" => "Date de fin",
        "specialty" => "Spécialité :",
        "doctor" => "Médecin :",
        "daira" => "Daïra :",
        "c-place" => "Lieu de consultation :",
        "letter" => "Lettre d'orientation",
        "for" => [
            "add" => "Ajouter un rendez-vous",
            "add-control" => "Ajouter un rendez-vous de contrôle",
        ],
        "no-c-place-or-no-doctor" => "Désolé, vous ne pouvez pas prendre de rendez-vous pour le moment, veuillez vérifier ultérieurement",
        "already-have-r-with-specialty" => "Vous avez déjà un rendez-vous à venir avec cette spécialité. Veuillez choisir une autre spécialité ou attendre votre rendez-vous.",
        "intro" => "Pour voir la liste des rendez-vous disponibles",
        "first-instruction" => "Choisissez une spécialité médicale.",
        "second-instruction" => "Sélectionnez au moins une daïra et un lieu de consultation.",
        "third-instruction" => "Sélectionnez au moins un médecin.",
        "fourth-instruction" => "Vous pouvez modifier la période comme vous le souhaitez :",
        "fifth-instruction" => "Veuillez noter que lettre d'orientation est requise en format photo :",
        "not-found" => "Il n'y a pas de rendez-vous disponibles pour le moment.",
        "letter-type-err" => "lettre d'orientation doit être au format image."
    ],
];
