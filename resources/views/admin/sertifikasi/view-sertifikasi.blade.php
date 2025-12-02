<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        .page {
            padding: 40px;
            background-color: #f4f4f4;
            font-family: sans-serif;
            text-align: center;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #ccc;
            width: 600px;
            margin: 0 auto;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        .name {
            font-size: 22px;
            font-weight: bold;
            margin-top: 25px;
        }

        .training {
            font-size: 18px;
            margin-top: 10px;
        }

        .completion-text {
            font-size: 15px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="container">
            <img src="{{ public_path('storage/icon/company_icon.png') }}" class="logo">

            <div class="title">SERTIFIKAT KELULUSAN</div>

            <p class="completion-text">Dengan ini menyatakan bahwa</p>

            <div class="name">{{ $data['nama_lengkap'] }}</div>

            <p class="completion-text">Telah menyelesaikan pelatihan:</p>

            <div class="training"><strong>{{ $data['nama_pelatihan'] }}</strong></div>
        </div>
    </div>
</body>

</html>
