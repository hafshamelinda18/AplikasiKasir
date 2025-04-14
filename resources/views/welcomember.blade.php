<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang!</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .email-header {
            background-color:rgb(206, 61, 17);
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
        }
        .email-body h2 {
            color: #333333;
            font-size: 20px;
        }
        .email-body p {
            color: #666666;
            line-height: 1.6;
        }
        .email-body a {
            display: inline-block;
            padding: 10px 20px;
            background-color:rgb(212, 54, 54);
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .email-body a:hover {
            background-color:rgb(190, 35, 15);
        }
        .email-footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }
        .email-footer p {
            margin: 0;
        }
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Selamat Datang di CaineMart!</h1>
        </div>
        <div class="email-body">
            <h2>Halo, {{ $data['pelanggan']->NamaPelanggan }}!</h2>
            <p>
                Terima kasih telah bergabung menjadi member CaineMart. Kami sangat senang menyambut Anda sebagai bagian dari keluarga besar kami!
            </p>
            <p>
                Sebagai member, Anda akan mendapatkan berbagai keuntungan menarik seperti promo eksklusif, penawaran spesial, dan layanan yang lebih personal sesuai kebutuhan Anda.
            </p>
            <p>
                Jangan lewatkan berbagai informasi terbaru dan penawaran khusus yang akan kami kirimkan secara berkala. Pastikan Anda tetap terhubung bersama kami!
            </p>
           
        </div>
        <div class="email-footer">
            <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan hubungi tim layanan pelanggan kami kapan saja.</p>
            <p>&copy; 2025 CaineMart. Seluruh hak cipta dilindungi.</p>
        </div>
    </div>
</body>
</html>
