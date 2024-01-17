<?php

return [
  "common"=>[
    "submit-btn"=>"Save"
  ],
 "user"=>[
    "l-name"=>"Last Name",
    "f-name"=>"First Name",
    "specialty"=>"Specialty",
    "b-date"=>"Birth Date",
    'email'=>"Email",
    'tel'=>"Phone Number",
    "h3"=>"The email must be valid, a verification code will be sent to it",
    "for"=>[
        "add-super-admin"=>"Add Super Admin",
        "add-coord-service"=>"Add Service coordinator",
        "add-coord-c-place"=>"Add Consultation place coordinator",
        "add-doctor"=>"Add Doctor",
        "add-admin-establishment"=>"Add Establishment Administrator",
         "update-user"=>"Update "
    ]

 ],

 "role"=>[
  "for"=>[
    "manage"=>"Manage Roles"
  ]
 ],
 "establishment"=>[
    "acronym"=>"Name Abbreviation",
    "name"=>"Name",
    "email"=>"Email",
    "address"=>"Address",
    "land-line-number"=>"Land line number",
    "fax-number"=>"Fax number",
    "for"=>[
        "add"=>"Add Establishment",
        "update"=>"Update Establishment"
    ]
    ],
 "service"=>[
    "name"=>"Service Name",
    "head-service"=>"Head Of The Service",
    "specialty"=>"Service Specialty :",
    "for"=>[
        "add"=>"Add Service",
        "update"=>"Update Service"
    ]
    ],
 "c-place"=>[
    "name"=>"Consultations Place Name",
    "address"=>"Address",
    "land-line-number"=>"Land line number",
    "fax-number"=>"Fax number",
    "daira"=>"Daïra :",
     "latitude"=>"Latitude",
     "longitude"=>"Longitude",
    "for"=>[
        "add"=>"Add Consultations Place",
        "update"=>"Update Consultations Place"
    ],],

    "m-file"=>[
        "birth-d"=>"Birth Date",
        "l-name" =>"Last Name",
        "f-name" =>"First Name",
        "phone-number"=>"Phone Number",
        "address"=>"Address",
        "for"=>[
            "add"=>"Add Medical File",
            "update"=>"Update Medical File"
        ],
    ],
    "planning"=>[
        "name"=>"Planning Name",
         "year"=>"Year :",
         "state"=>"State :",
          "month"=>"Month :",
          "for"=>[
            "add"=>"Add Planning",
            "update"=>"Update Planning"
        ],
     ],

     "planning-day"=>[

        "doctor-c-place-err"=>"you cannot add a scheduling day at the moment, you must add at least one doctor and one consultation location",
        "doctor-err"=>"you cannot add a scheduling day at the moment, you must add at least one doctor",
        "c-place-err"=>"you cannot add a planning day at the moment, you must add at least one consultation location",
        "specialty"=>"Specialty :",
        "doctor"=>"Doctor :",
        "c-place"=>"Consultations Place :",
        "date"=>"The Date",
        "c-number"=>"Consultations Number",
        "for"=>[
            "add"=>"Add Planning day",
            "update"=>"Update Planning day",
        ],

     ],
  "rendez-vous"=>[
    "date"=>"Appointment Date",
    "start-d"=>"Start Date",
    "end-d"=>"End Date",
    "specialty"=>"Specialty :",
    "doctor"=>"Doctor :",
     "daira"=>"Daïra :",
     "c-place"=>"Consultation Place :",
     "letter"=>"Guidance letter",
    "for"=>[
        "add"=>"Add Appointment",
        "add-control"=>"Add a check-up appointment"
    ],
    "no-c-place-or-no-doctor"=>"Sorry, you can't make an appointment at the moment, check back later",
    "already-have-r-with-specialty"=>"You already have an appointment coming up with this specialty.  Please select another specialty or wait for your appointment.",
    "intro"=>"To view the list of available appointments",
    "first-instruction"=>"Choose a medical specialty.",
    "second-instruction"=>"select at least one daïra and a place of consultation ",
    "third-instruction"=>"Select at least one doctor",
    "fourth-instruction"=>"You can change the period as you wish :",
    "fifth-instruction"=>"Please note that the orientation letter is required in photo format :",
    "not-found"=>"There are no appointments available at the moment ",
    "letter-type-err"=>"Orientation letter must be in image format"

  ]

];
