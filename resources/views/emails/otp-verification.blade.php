<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Email</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #007bff;">Kode Verifikasi Email</h2>
        <p>Halo,</p>
        <p>Terima kasih telah mendaftar di Sistem Permohonan. Untuk menyelesaikan proses registrasi, silakan masukkan kode verifikasi berikut:</p>
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 24px; font-weight: bold; color: #007bff; background-color: #f8f9fa; padding: 10px 20px; border-radius: 5px; display: inline-block;">
                {{ $otp }}
            </span>
        </div>
        <p>Kode ini akan kedaluwarsa dalam 10 menit. Jika Anda tidak meminta kode ini, abaikan email ini.</p>
        <p>Jika Anda memiliki pertanyaan, silakan hubungi tim dukungan kami.</p>
        <p>Salam,<br>Tim Sistem Permohonan</p>
    </div>
</body>
</html>