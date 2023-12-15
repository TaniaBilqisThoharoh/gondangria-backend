<!DOCTYPE html>
<html>
<head>
    <title>gondangria.com</title>
</head>
<body>
    <h1>{{ $mailData['nama'] }}</h1>
    <p>Ini kode verifikasi kamu: <strong>{{ $mailData['token'] }}</strong>.</p>
    
    <p>Harap selesaikan proses verifikasi akun dalam 30 menit.</p>
     
    <p>Terima kasih</p>
    <p>Gondang Ria Waterpark</p>

    <strong style="opacity: 0.5;">Ini adalah email otomatis. Tolong jangan balas ke email ini</strong>
</body>
</html>