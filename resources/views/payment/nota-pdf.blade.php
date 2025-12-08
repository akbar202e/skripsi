<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nota Pembayaran - {{ $nomorNota }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            font-size: 11pt;
            line-height: 1.3;
        }

        .nota-container {
            width: 100%;
            max-width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            padding: 1.5cm;
            background: white;
        }

        .nota-header {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nota-header img {
            width: 80px;
            height: 100px;
            filter: grayscale(100%);
        }

        .header-text {
            flex: 1;
            text-align: center;
        }

        .header-text h1 {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .header-text p {
            font-size: 11pt;
            margin: 2px 0;
        }

        .nota-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
        }

        .nota-details {
            margin-bottom: 20px;
            font-size: 11pt;
        }

        .nota-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .nota-details td {
            padding: 2px 0;
            vertical-align: top;
        }

        .nota-details td:first-child {
            width: 150px;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11pt;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #000;
            padding: 6px 8px;
        }

        .item-table th {
            background-color: #f0f0f0;
            text-align: center;
        }

        .item-table td:nth-child(1),
        .item-table td:nth-child(2),
        .item-table td:nth-child(3) {
            text-align: center;
        }

        .item-table td:nth-child(4),
        .item-table td:nth-child(5) {
            text-align: right;
        }

        .total-section {
            font-size: 11pt;
        }

        .terbilang {
            font-style: italic;
            font-weight: bold;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .signature-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .signature-table td {
            padding: 10px;
        }

        .signature-left {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding-right: 80px;
        }

        .signature-right {
            width: 50%;
        }

        .signature-space {
            height: 80px;
            margin: 10px 0;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 5px;
        }

        .signature-nip {
            font-size: 10pt;
            margin-top: 2px;
        }

        .total-detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-detail-table tr {
            border-bottom: 1px solid #000;
        }

        .total-detail-table th {
            text-align: left;
            padding: 4px 8px;
            font-weight: normal;
        }

        .total-detail-table td {
            text-align: right;
            padding: 4px 8px;
        }

        .total-row {
            font-weight: bold;
            font-size: 12pt;
            border-top: 2px solid #000 !important;
            border-bottom: 2px double #000 !important;
        }

        .total-row th,
        .total-row td {
            padding: 6px 8px;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .nota-container {
                max-width: 100%;
                height: auto;
                margin: 0;
                padding: 1.5cm;
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <!-- Header -->
        <div class="nota-header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Coat_of_arms_of_Central_Kalimantan.svg" alt="Logo">
            <div class="header-text">
                <h1>UPT LAB. BAHAN KONSTRUKSI</h1>
                <p>Dinas Pekerjaan Umum dan Penataan Ruang</p>
                <p>Provinsi Kalimantan Tengah</p>
                <p>Jalan Tjilik Riwut km. 3 Palangka Raya | Telp. (0536) 3222607</p>
            </div>
        </div>

        <!-- Title -->
        <h2 class="nota-title">NOTA PEMBAYARAN</h2>

        <!-- Details -->
        <div class="nota-details">
            <table>
                <tr>
                    <td>Order Id</td>
                    <td>: <strong>{{ $nomorNota }}</strong></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ $tanggal }}</td>
                </tr>
                <tr>
                    <td>Pemohon</td>
                    <td>: {{ $pemohon }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>: {{ $pekerjaan }}</td>
                </tr>
            </table>
        </div>

        <!-- Items Table -->
        <table class="item-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 45%;">Uraian / Nama Item</th>
                    <th style="width: 10%;">Qty</th>
                    <th style="width: 20%;">Harga Satuan</th>
                    <th style="width: 20%;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $pekerjaan }}</td>
                    <td>1</td>
                    <td style="text-align: right;">Rp {{ number_format($jumlahBayar, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <div class="terbilang">
                Terbilang: {{ \App\Services\TerbilangService::toTerbilang($totalKeseluruhan) }} Rupiah
            </div>

            <table class="signature-table">
                <tr>
                    <td class="signature-left">
                        <div>Bendahara Penerima</div>
                        <div class="signature-space"></div>
                        <div class="signature-name">-</div>
                        <div class="signature-nip">NIP. -</div>
                    </td>
                    <td class="signature-right">
                        <table class="total-detail-table">
                            <tr>
                                <th>Metode Bayar</th>
                                <td>{{ $metode }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Bayar</th>
                                <td>Rp {{ number_format($jumlahBayar, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="total-row">
                                <th>TOTAL</th>
                                <td>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
