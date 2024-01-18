<?php
   return [
       "common"=>[
         "submit-btn"=>"Validate"
       ],
      "login"=>[
             "instruction"=>"Please provide the following information",
            'email'=>"Email",
            'password'=>"Password",
            "forget-password-link"=>"Forgot your password ?",
            "register-link"=>"Create an account",
            "no-user-err"=>"No matching users found with provided email and password",
            "too-many-attempts"=>"You have made too many attempts. Please try again in a few minutes."
          ],
     "register"=>[
        "first-f"=>[
            "instruction"=>"Your email must be valid, a verification code will be sent to you",
            "login-link"=>"I already have an account",
            "l-name"=>"Last Name",
            "f-name"=>"First Name",
            "b-date"=>"Birth Date",
            'email'=>"Email",
            'tel'=>"Phone Number",
            'password'=>"Password",
            "success-txt"=>"A verification code has been sent to your email address"
        ],
        "second-f"=>[
            "instruction"=>"Your email must be valid, a verification code will be sent to you",
            "new-code-btn"=>"Get a new verification code",
            'email'=>"Email",
            "code"=>"Verification code",
            'code-err'=>"Verification code is invalid"

        ]
        ],

        "forget-pwd"=>[
            "first-f"=>[
                "instruction"=>"Your email must be valid, a verification code will be sent to you",
                "email"=>"Email",
                "success-txt"=>"A verification code has been sent to your email address"
            ],
            "second-f"=>[
                "instruction"=>"Enter the verification code sent to you",
                'email'=>"Email",
                "code"=>"Verification code",
                "password"=>"The New Password",
                "no-user"=>"No matching users found with provided email",
                "code-err"=>"Verification code is invalid"
            ]
            ],
         "change-pwd"=>[
            "instruction"=>"Please provide the following information:",
           "pwd"=>"The Old Password",
           "new-pwd"=>"The New Password",
           "pwd-err"=>"check your old password",
           "success-txt"=>"your password has been changed. You will now be logged out"
         ],

        "site-params"=>[
            "first-f"=>[
                "instruction"=>"Please provide the following information:",
                "email"=>"Email",
                "password"=>"Password",
                "no-user"=>"No matching users found with provided email and password",
                "no-access"=>"You do not have the rights to access the next step",
                "success-txt"=>"Be careful when changing the global state of the platform"
            ],
            "second-f"=>[
                "instruction"=>"manage the maintenance state of the platform:",
                 "disable"=>"Disable",
                 "enable"=>"Enable",
                 "db-download-btn"=>"Download the database",
                 "no-db"=>"No database backups available.",
                 "state"=>"the maintenance state of the platform",
                 "success-txt"=>"You have successfully changed the maintenance state"
            ]

            ],

        "user"=>[
            "add"=>[
             "success-txt"=>"User was created successfully",
            ],
            "update"=>[
             "success-txt"=>"User was successfully updated"
            ]
            ],
        "establishment"=>[
            "add"=>[
             "success-txt"=>"The establishment has been successfully created",
            ],
            "update"=>[
             "success-txt"=>"The establishment has been successfully updated"
            ]
            ],
        "c-place"=>[
            "add"=>[
              "success-txt"=>"The consultation location has been successfully created"
            ],
            "update"=>[
                "success-txt"=>"The consultation location has been successfully updated"
            ]
            ],
        "service"=>[
            "add"=>[
             "success-txt"=>"the service has been created successfully"
            ],
            "update"=>[
             "success-txt"=>"The service has been successfully updated"
            ]
            ],
        "planning"=>[
            "add"=>[
             "success-txt"=>"The schedule was created successfully"
            ],
            "update"=>[
             "success-txt"=>"The schedule has been successfully updated"
            ]
            ],
    "planning-day"=>[
        "add"=>[
            "success-txt"=>"Planning day has been successfully created"
        ],
        "update"=>[
            "success-txt"=>"The planning day was successfully updated"
        ]
        ],
    "m-file"=>[
        "add"=>[
            "success-txt"=>"The Medical File has been successfully created"
        ],
        "update"=>[
            "success-txt"=>"The medical record has been successfully updated"
        ]
        ],
"rendez-vous"=>[
"c-place-required-err"=>"You must select at least one consultations place",
"planning-required-err"=>"You must select an appointment date.",
"planning-exists-err"=>"The selected appointment date is invalid",
"no-m-file"=>"no valid medical file found",
 "maxed-out"=>"The maximum number of appointments for this day has been reached. You took a long time to validate your choice, another patient has just made the last appointment",
"success-txt"=>"The appointment has been made successfully",
]
          ]
     ;
