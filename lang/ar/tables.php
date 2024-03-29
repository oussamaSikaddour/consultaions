<?php
return [
    "common"=>[
        "excel-file-type-err" => "يجب أن يكون النوع الخاص بالملف هو إكسل (XLSX، XLS، CSV)"
    ],
    'users'=> [
        "fullName"=>"الاسم",
        "email"=>"البريد الإلكتروني",
        "specialty"=>"التخصص",
        "registration-date"=>"تاريخ التسجيل",
        "phone"=>"رقم الهاتف",
        "filters"=>[
            "specialty"=>"التخصص:",
            "user-type"=>"دور المستخدم:"
        ],
        "not-found"=>"لا يوجد مستخدمين في الوقت الحالي",
    ],
    'establishments'=> [
        "empty-excel" => "إنشاء ورقة بيانات إكسل فارغة للمؤسسات",
        "upload-excel-btn-txt"=>"تحميل المؤسسات",
        "excel-upload-success-msg"=>"تم تحميل المؤسسات بنجاح",
        "acronym"=>"اختصار الاسم",
        "name"=>"الاسم",
        "email"=>"البريد الإلكتروني",
        "address"=>"العنوان",
        "land-line-number"=>"الهاتف الثابت",
        "fax-number"=>"رقم الفاكس",
        "creation-date"=>"تاريخ الإضافة",
        "not-found"=>"لا توجد مؤسسات في الوقت الحالي",
    ],
    'services'=> [
        "empty-excel" => "إنشاء ورقة بيانات إكسل فارغة للمصلحات",
        "upload-excel-btn-txt" => "تحميل المصلحات",
        "excel-upload-success-msg" => "تم تحميل المصلحات بنجاح",
        "name"=>"اسم المصلحة",
        "head-service"=>"رئيس المصلحة",
        "specialty"=>"تخصص المصلحة",
        "creation-date"=>"تاريخ الإضافة",
        "filters"=>[
            "specialty"=>"التخصص:",
        ],
        "not-found"=>"لا توجد مصلحات في الوقت الحالي",
    ],
    "plannings" => [
        "name" => "اسم الخطة",
        "year" => "السنة",
        "state" => "الحالة",
        "month" => "الشهر",
        "creation-date" => "تاريخ الإضافة",
        "filters" => [
            "year" => "السنة:",
            "month" => "الشهر:",
            "state" => "الحالة:",
        ],
        'already-published' => 'تم النشر بالفعل',
        "not-found" => "لا توجد خطط في الوقت الحالي",
    ],
    "planning-days" => [
        "date" => "التاريخ",
        "doctor" => "الطبيب",
        "c-place" => "مكان الاستشارات",
        "c-number" => "عدد الاستشارات",
        "creation-date" => "تاريخ الإضافة",
        "filters" => [
            "specialty" => "التخصص:",
            "doctor" => "الطبيب:",
            "c-place" => "مكان الاستشارات:",
        ],
        'already-published' => 'تم النشر بالفعل',
        "not-found" => "لا توجد أي أيام جدولية متاحة حالياً",
    ],
    'c-places'=> [
        "empty-excel" => "إنشاء ورقة بيانات Excel فارغة لأماكن الاستشارات",
        "upload-excel-btn-txt" => "تحميل أماكن الاستشارات",
        "excel-upload-success-msg" => "تم تحميل أماكن الاستشارات بنجاح",
        "name"=>"اسم مكان الاستشارات",
        "address"=>"العنوان",
        "land-line-number"=>"رقم الهاتف الثابت",
        "fax-number"=>"رقم الفاكس",
        "filters"=>[
            "daira"=>"الدائرة",
        ],
        "creation-date"=>"تاريخ الإضافة",
        "not-found"=>"لا توجد أماكن للاستشارات في الوقت الحالي",
    ],
    'm-files'=> [
        "code"=>"كود الملف",
        "birth-d"=>"تاريخ الميلاد",
       "l-name"=>"القب",
       "f-name"=>"الإسم",
        "phone-number"=>"رقم الهاتف",
        "filters"=>[
            "daira"=>"الدائرة",
        ],
        "creation-date"=>"تاريخ الإضافة",
        "not-found"=>"لا توجد ملفات طبية في الوقت الحالي",
    ],
    'rendez-vous'=> [
        "mf-code"=>"كود الملف",
        "date"=>"التاريخ في",
        'type' => 'النوع',
        "name"=>"اسم المريض",
        "birth-d"=>"تاريخ الميلاد",
        "start-d"=>"تاريخ البدء",
        "end-d"=>"تاريخ الانتهاء",
        "patient-l-name"=>"اسم العائلة للمريض",
        "patient-f-name"=>"الاسم الأول للمريض",
        "specialty"=>"التخصص",
        "doctor"=>"الطبيب",
        'd-email'=>"بريد الطبيب",
        'd-phone'=>"رقم هاتف الطبيب",
        "establishment"=>"المؤسسة",
        "c-place"=>"مكان الاستشارة",
        "filters"=>[
            "doctor"=>"الطبيب:",
            "specialty"=>"التخصص:",
            "c-place"=>"مكان الاستشارة:",
            'type' => 'النوع:',
        ],
        "not-found"=>"لا توجد مواعيد  حالياً",
        'delete-err' => "لا يمكنك حذف الموعد. إنه خلال الـ 3 أيام القادمة.",
    ],
];
