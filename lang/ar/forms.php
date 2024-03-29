<?php
return [
    "common"=>[
        "submit-btn"=>"تحقق"
    ],
    "login"=>[
        "instruction"=>"يرجى تقديم المعلومات التالية",
        'email'=>"البريد الإلكتروني",
        'password'=>"كلمة المرور",
        "forget-password-link"=>"هل نسيت كلمة المرور؟",
        "register-link"=>"إنشاء حساب",
        "no-user-err"=>"لم يتم العثور على مستخدمين مطابقين مع البريد الإلكتروني وكلمة المرور المقدمة",
        "too-many-attempts"=>"تم حظر محاولة تسجيل الدخول مؤقتًا بسبب تكرار المحاولات الفاشلة. يرجى المحاولة مرة أخرى في غضون بضع دقائق"
    ],
    "register"=>[
        "first-f"=>[
            "instruction"=>"يجب أن يكون بريدك الإلكتروني صالحًا ، سيتم إرسال رمز التحقق إليك",
            "login-link"=>"لدي حساب بالفعل",
            "l-name"=>"اللقب",
            "f-name"=>"الاسم",
            "b-date"=>"تاريخ الميلاد",
            'email'=>"البريد الإلكتروني",
            'tel'=>"رقم الهاتف",
            'password'=>"كلمة المرور",
            "success-txt"=>"تم إرسال رمز التحقق إلى عنوان بريدك الإلكتروني"
        ],
        "second-f"=>[
            "instruction"=>"أدخل رمز التحقق الذي تم إرساله إليك",
            "new-code-btn"=>"الحصول على رمز تحقق جديد",
            'email'=>"البريد الإلكتروني",
            "code"=>"رمز التحقق",
            'code-err'=>"رمز التحقق غير صالح"
        ]

    ]
    ,
    "forget-pwd"=>[
        "first-f"=>[
            "instruction"=>"يجب أن يكون بريدك الإلكتروني صالحًا ، سيتم إرسال رمز التحقق إليك",
            "email"=>"البريد الإلكتروني",
            "success-txt"=>"تم إرسال رمز التحقق إلى عنوان بريدك الإلكتروني"
        ],
        "second-f"=>[
            "instruction"=>"أدخل رمز التحقق الذي تم إرساله إليك",
            'email'=>"البريد الإلكتروني",
            "code"=>"رمز التحقق",
            "password"=>"كلمة المرور الجديدة",
            "no-user"=>"لم يتم العثور على مستخدمين مطابقين باستخدام البريد الإلكتروني المقدم",
            "code-err"=>"رمز التحقق غير صالح"
        ]
        ],
        "change-pwd" => [
            "instruction" => "يرجى تقديم المعلومات التالية:",
            "pwd" => "كلمة المرور القديمة",
            "new-pwd" => "كلمة المرور الجديدة",
            "pwd-err" => "تحقق من كلمة المرور القديمة الخاصة بك",
            "success-txt" => "تم تغيير كلمة المرور الخاصة بك. سيتم تسجيل خروجك الآن."
        ],
        "site-params"=>[
            "first-f"=>[
                "instruction"=>"يرجى تقديم المعلومات التالية:",
                "email"=>"البريد الإلكتروني",
                "password"=>"كلمة المرور",
                "no-user"=>"لم يتم العثور على مستخدمين مطابقين مع البريد الإلكتروني وكلمة المرور المقدمة",
                "no-access"=>"ليس لديك حق الوصول إلى الخطوة التالية",
                "success-txt"=>"كن حذرًا عند تغيير الحالة العامة للمنصة"
            ],
            "second-f"=>[
                "instruction"=>"إدارة حالة صيانة المنصة:",
                "disable"=>"تعطيل",
                "enable"=>"تمكين",
                "db-download-btn"=>"تحميل قاعدة البيانات",
                "no-db"=>"لا توجد نسخ احتياطية لقاعدة البيانات متاحة.",
                "state"=>"حالة صيانة المنصة",
                "success-txt"=>"لقد قمت بتغيير حالة الصيانة بنجاح"
            ]
            ],
            "user" => [
                "add" => [
                    "success-txt" => "تم إنشاء المستخدم بنجاح",
                ],
                "update" => [
                    "success-txt" => "تم تحديث المستخدم بنجاح",
                ]
                ],
                "establishment" => [
                    "add" => [
                        "success-txt" => "تم إنشاء المؤسسة بنجاح",
                    ],
                    "update" => [
                        "success-txt" => "تم تحديث المؤسسة بنجاح",
                    ]
                    ],
                "service" => [
                        "add" => [
                            "success-txt" => "تم إنشاء الخدمة بنجاح",
                        ],
                        "update" => [
                            "success-txt" => "تم تحديث الخدمة بنجاح",
                        ]
                        ],
             "planning" => [
                            "add" => [
                                "success-txt" => "تم إنشاء الجدول بنجاح",
                            ],
                            "update" => [
                                "success-txt" => "تم تحديث الجدول بنجاح",
                            ]
                            ],
          "planning-day" => [
                    "add" => [
                         "success-txt" => "تم إنشاء يوم التخطيط بنجاح",
                        ],
                    "update" => [
                         "success-txt" => "تم تحديث يوم التخطيط بنجاح",
                                ]
                    ],
        "m-file" => [
                "add" => [
                     "success-txt" => "تم إنشاء الملف الطبي بنجاح",
                 ],
                "update" => [
                     "success-txt" => "تم تحديث السجل الطبي بنجاح",
                    ]
                ]
       ,
       "rendez-vous" => [
        "c-place-required-err" => "يجب عليك اختيار مكان واحد على الأقل للمشاورة",
        "planning-required-err" => "يجب عليك اختيار تاريخ للموعد.",
        "planning-exists-err" => "تاريخ الموعد المحدد غير صالح",
        "no-m-file" => "لم يتم العثور على ملف طبي صالح",
        "maxed-out" => "تم الوصول إلى الحد الأقصى لعدد المواعيد لهذا اليوم. لقد استغرقت وقتًا طويلاً لتأكيد اختيارك، قام مريض آخر بحجز الموعد الأخير",
        "success-txt" => "تم حجز الموعد بنجاح",
    ]

];
