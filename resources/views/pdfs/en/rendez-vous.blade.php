<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rendez-vous</title>
    <style>
    body {
      width: 59.5rem;
      font-family: Arial, sans-serif;
      font-size: 15px;
      margin: 0; /* Prevent default margins */
    }

    .rendez-vous {
      width: 100%;
      position: relative;
    }

    h3 {
      margin-left: 1rem;
    }

    p {
     display: block;
      width: 40rem;
      margin-left: 2rem;
      margin-bottom: 1rem;
    }

     img{
        display: block;
        width: 100%;
        height:10rem;
        object-fit: contain;
     }
    strong {
        color:#1B9A9E;
    }
    </style>
</head>
<body>

    <div class="rendez-vous">

                        <img src="{{public_path('img/med.png')}}" alt="logo">


                        <div>
                            <h3>Patient Information:</h3>
                            <p>Patient Code: <strong>{{ $rendezVousData['patient']['code'] }}</strong></p>
                            <p>Patient Name:<strong> {{ $rendezVousData['patient']['last_name'] }} {{ $rendezVousData['patient']['first_name'] }}</strong></p>
                        </div>
                        <div>
                            <h3>Appointment Information:</h3>
                            <p>Date:<strong> {{ $rendezVousData['day_at'] }} </strong></p>
                            <p>Appointment Type: <strong>{{ app('my_constants')['RENDEZ_VOUS_TYPE'][app()->getLocale()][$rendezVousData['type']] }} </strong></p>
                        </div>

                    <div>
                        <div>
                            <h3>Consultation Place Informations:</h3>
                            <p>Name:<strong> {{ $rendezVousData['consultation_place']['name'] }}</strong></p>
                            <p>Daira: <strong>{{ app('my_constants')['DAIRAS'][app()->getLocale()][$rendezVousData['consultation_place']['daira']] }}</strong></p>
                            <p>Address: <strong>{{ $rendezVousData['consultation_place']['address'] }}</strong></p>
                        </div>
                    </div>
                    <div>
                        <div>
                            <h3>Doctor Information:</h3>
                            <p>Doctor's Name: <strong>{{ $rendezVousData['doctor_name'] }}</strong></p>
                            <p>Specialty: <strong>{{ app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()][$rendezVousData['specialty']] }}</strong></p>
                        </div>
                    </div>
                    <div class="rendez-vous__footer">
                        <p>
                            We kindly request you to arrive early and to bring any relevant medical records, insurance information, and a list of current medications to your appointment.
                        </p>
                        <p>
                            We look forward to assisting you with your healthcare needs, and Thank you for choosing Your Medical Practice Name.
                        </p>
                    </div>
     </div>
</body>
</html>
