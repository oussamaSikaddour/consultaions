<?php
return [
    "common"=>[
        "submit-btn"=>"Valider"
    ],
    "login"=>[
        "instruction"=>"Veuillez fournir les informations suivantes :",
        'email'=>"Email",
        'password'=>"Mot de passe",
        "forget-password-link"=>"Mot de passe oublié ?",
        "register-link"=>"Créer un compte",
        "no-user-err"=>"Aucun utilisateur correspondant trouvé avec l'email et le mot de passe fournis",
        "too-many-attempts"=>"Votre tentative de connexion est temporairement bloquée en raison de tentatives répétées infructueuses. Veuillez réessayer dans quelques minutes."
    ],

    "register"=>[
        "first-f"=>[
            "instruction"=>"Votre email doit être validé, un code de vérification vous sera envoyé",
            "login-link"=>"J'ai déjà un compte",
            "l-name"=>"Nom de famille",
            "f-name"=>"Prénom",
            "b-date"=>"Date de naissance",
            'email'=>"Email",
            'tel'=>"Numéro de téléphone",
            'password'=>"Mot de passe",
            "success-txt"=>"Un code de vérification a été envoyé à votre adresse e-mail"
        ],
        "second-f"=>[
            "instruction"=>"Entrez le code de vérification qui vous a été envoyé",
            "new-code-btn"=>"Obtenir un nouveau code de vérification",
            'email'=>"Email",
            "code"=>"Code de vérification",
            'code-err'=>"Le code de vérification n'est pas valide"
        ]
    ]
,
    "forget-pwd"=>[
        "first-f"=>[
            "instruction"=>"Votre email doit être validé, un code de vérification vous sera envoyé",
            "email"=>"Email",
            "success-txt"=>"Un code de vérification a été envoyé à votre adresse e-mail"
        ],
        "second-f"=>[
            "instruction"=>"Entrez le code de vérification qui vous a été envoyé",
            'email'=>"Email",
            "code"=>"Code de vérification",
            "password"=>"Le nouveau mot de passe",
            "no-user"=>"Aucun utilisateur correspondant trouvé avec l'e-mail fourni",
            "code-err"=>"Le code de vérification n'est pas valide"
        ]
    ]
,
    "change-pwd" => [
        "instruction" => "Veuillez fournir les informations suivantes :",
        "pwd" => "Ancien mot de passe",
        "new-pwd" => "Nouveau mot de passe",
        "pwd-err" => "Vérifiez votre ancien mot de passe",
        "success-txt" => "Votre mot de passe a été modifié. Vous serez maintenant déconnecté(e)."
    ]
    ,
    "site-params"=>[
        "first-f"=>[
            "instruction"=>"Veuillez fournir les informations suivantes :",
            "email"=>"Email",
            "password"=>"Mot de passe",
            "no-user"=>"Aucun utilisateur correspondant trouvé avec l'email et le mot de passe fournis",
            "no-access"=>"Vous n'avez pas le droit d'accéder à l'étape suivante",
            "success-txt"=>"Soyez prudent lors du changement de l'état global de la plateforme"
        ],
        "second-f"=>[
            "instruction"=>"Gérer l'état de maintenance de la plateforme :",
            "disable"=>"Désactiver",
            "enable"=>"Activer",
            "db-download-btn"=>"Télécharger la base de données",
            "no-db"=>"Aucune sauvegarde de base de données disponible.",
            "state"=>"L'état de maintenance de la plateforme",
            "success-txt"=>"Vous avez changé avec succès l'état de maintenance"
        ]
        ],
        "user" => [
            "add" => [
                "success-txt" => "L'utilisateur a été créé avec succès",
            ],
            "update" => [
                "success-txt" => "L'utilisateur a été mis à jour avec succès",
            ]
            ],
            "establishment" => [
                "add" => [
                    "success-txt" => "L'établissement a été créé avec succès",
                ],
                "update" => [
                    "success-txt" => "L'établissement a été mis à jour avec succès",
                ]
                ],
                "service" => [
                    "add" => [
                        "success-txt" => "Le service a été créé avec succès",
                    ],
                    "update" => [
                        "success-txt" => "Le service a été mis à jour avec succès",
                    ]
                    ],
            "planning" => [
                "add" => [
                     "success-txt" => "Le planning a été créé avec succès",
                ],
                "update" => [
                     "success-txt" => "Le planning a été mis à jour avec succès",
                ]
                ],
            "planning-day" => [
                    "add" => [
                        "success-txt" => "Le jour du planning a été créé avec succès",
                    ],
                    "update" => [
                        "success-txt" => "La jour du planning a été mis à jour avec succès",
                    ]
                    ],
          "m-file" => [
                        "add" => [
                            "success-txt" => "Le dossier médical a été créé avec succès",
                        ],
                        "update" => [
                            "success-txt" => "Le dossier médical a été mis à jour avec succès",
                        ]
                    ]
        ,
        "rendez-vous" => [
            "c-place-required-err" => "Vous devez sélectionner au moins un lieu de consultation",
            "planning-required-err" => "Vous devez sélectionner une date de rendez-vous.",
            "planning-exists-err" => "La date de rendez-vous sélectionnée est invalide",
            "no-m-file" => "Aucun dossier médical valide trouvé",
            "maxed-out" => "Le nombre maximum de rendez-vous pour cette journée a été atteint. Vous avez pris trop de temps pour valider votre choix, un autre patient vient de prendre le dernier rendez-vous",
            "success-txt" => "Le rendez-vous a été pris avec succès",
        ]

];
