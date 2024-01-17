<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rendez-vous</title>
    <style>
    body {
      width: 59.5rem;
      font-family: 'Noto Sans', Arial, sans-serif;
      font-size: 15px;
      margin: 0;
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

        <img src="{{ public_path('img/med.png') }}" alt="logo">

        <div>
            <h3>Informations sur le patient :</h3>
            <p>Code patient : <strong>{{ $rendezVousData['patient']['code'] }}</strong></p>
            <p>Nom du patient : <strong>{{ $rendezVousData['patient']['last_name'] }} {{ $rendezVousData['patient']['first_name'] }}</strong></p>
        </div>
        <div>
            <h3>Informations sur le rendez-vous :</h3>
            <p>Date : <strong>{{ $rendezVousData['day_at'] }}</strong></p>
            <p>Type de rendez-vous : <strong>{{ app('my_constants')['RENDEZ_VOUS_TYPE'][app()->getLocale()][$rendezVousData['type']] }}</strong></p>
        </div>

        <div>
            <div>
                <h3>Informations sur le lieu de consultation :</h3>
                <p>Nom : <strong>{{ $rendezVousData['consultation_place']['name'] }}</strong></p>
                <p>Daira : <strong>{{ app('my_constants')['DAIRAS'][app()->getLocale()][$rendezVousData['consultation_place']['daira']] }}</strong></p>
                <p>Adresse : <strong>{{ $rendezVousData['consultation_place']['address'] }}</strong></p>
            </div>
        </div>
        <div>
            <div>
                <h3>Informations sur le médecin :</h3>
                <p>Nom du médecin : <strong>{{ $rendezVousData['doctor_name'] }}</strong></p>
                <p>Spécialité : <strong>{{ app('my_constants')['SPECIALTY_OPTIONS'][app()->getLocale()][$rendezVousData['specialty']] }}</strong></p>
            </div>
        </div>
        <div class="rendez-vous__footer">
            <p>
                Nous vous demandons aimablement d'arriver tôt et d'apporter tout dossier médical pertinent, des informations d'assurance, et une liste des médicaments actuels à votre rendez-vous.
            </p>
            <p>
                Nous sommes impatients de vous aider dans vos besoins en matière de santé, et merci de choisir le nom de votre pratique médicale.
            </p>
        </div>
    </div>
</body>
</html>
