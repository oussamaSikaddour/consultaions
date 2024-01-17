<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>موعد</title>
    <style>
    body {
      width: 59.5rem;
      font-family: 'Noto Sans Arabic', Arial, sans-serif;
      font-size: 15px;
      margin: 0;
      direction: rtl;
    }

    .rendez-vous {
      width: 100%;
      position: relative;
    }

    h3 {
      margin-right: 1rem;
    }

    p {
      display: block;
      width: 40rem;
      margin-right: 2rem;
      margin-bottom: 1rem;
    }

    img {
      display: block;
      width: 100%;
      height: 10rem;
      object-fit: contain;
    }

    strong {
      color: #1B9A9E;
    }
    </style>
</head>
<body>

    <div class="rendez-vous">

        <img src="{{ public_path('img/med.png') }}" alt="لوجو">

        <div>
            <h3>معلومات المريض:</h3>
            <p>رمز المريض: <strong>{{ $rendezVousData['patient']['code'] }}</strong></p>
            <p>اسم المريض: <strong>{{ $rendezVousData['patient']['last_name'] }} {{ $rendezVousData['patient']['first_name'] }}</strong></p>
        </div>
        <div>
            <h3>معلومات الموعد:</h3>
            <p>التاريخ: <strong>{{ $rendezVousData['day_at'] }}</strong></p>
            <p>نوع الموعد: <strong>{{ app('my_constants')['RENDEZ_VOUS_TYPE'][app()->getLocale()][$rendezVousData['type']] }}</strong></p>
        </div>

        <div>
            <div>
                <h3>معلومات مكان الاستشارة:</h3>
                <p>الاسم: <strong>{{ $rendezVousData['consultation_place']['name'] }}</strong></p>
                <p>الدائرة: <strong>{{ app('my_constants')['DAIRAS'][app()->getLocale()][$rendezVousData['consultation_place']['daira']] }}</strong></p>
                <p>العنوان: <strong>{{ $rendezVousData['consultation_place']['address'] }}</strong></p>
            </div>
        </div>
        <div>
            <div>
                <h3>معلومات الطبيب:</h3>
                <p>اسم الطبيب: <strong>{{ $rendezVousData['doctor_name'] }}</strong></p>
                <p>التخصص: <strong>{{ app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()][$rendezVousData['specialty']] }}</strong></p>
            </div>
        </div>
        <div class="rendez-vous__footer">
            <p>
                نطلب منك أن تصل في وقت مبكر وتحضر أي سجلات طبية ذات صلة ومعلومات التأمين وقائمة بالأدوية الحالية إلى موعدك.
            </p>
            <p>
                نتطلع إلى مساعدتك في احتياجاتك الصحية، وشكرًا لاختيارك اسم ممارستك الطبية.
            </p>
        </div>
    </div>
</body>
</html>
