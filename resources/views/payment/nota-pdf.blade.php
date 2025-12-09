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
            max-width: 19cm;
            height: 25cm;
            margin: 0 auto;
            padding: 1cm;
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
            object-fit: contain;
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
            width: 120px;
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
          <table style="width: 100%; border-collapse: collapse;">
            <tbody>
              <tr>
                <td style="width: 110px; vertical-align: top; padding: 0;">
                              <img src="{{ storage_path('app/public/logo.png') }}" alt="Logo">
                </td>
                <td style="text-align: center; vertical-align: top; padding: 0;">
                  <h1 style="font-size: 16pt; font-weight: bold; margin: 0;">UPT LAB. BAHAN KONSTRUKSI</h1>
                  <p style="font-size: 11pt; margin: 2px 0;">Dinas Pekerjaan Umum dan Penataan Ruang</p>
                  <p style="font-size: 11pt; margin: 2px 0;">Provinsi Kalimantan Tengah</p>
                  <p style="font-size: 11pt; margin: 2px 0;">Jalan Tjilik Riwut km. 3 Palangka Raya | Telp. (0536) 3222607</p>
                </td>
              </tr>
            </tbody>
          </table>
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
                @forelse($jenisPengujians as $index => $pengujian)
                    @php
                        $qty = $pengujian->pivot->jumlah_sampel ?? 1;
                        $hargaSatuan = $pengujian->biaya ?? 0;
                        $jumlah = $hargaSatuan * $qty;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pengujian->nama_pengujian }}</td>
                        <td style="text-align: center;">{{ $qty }}</td>
                        <td style="text-align: right;">Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</td>
                        <td style="text-align: right;">Rp {{ number_format($jumlah, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>1</td>
                        <td>{{ $pekerjaan }}</td>
                        <td style="text-align: center;">1</td>
                        <td style="text-align: right;">Rp {{ number_format($jumlahBayar, 0, ',', '.') }}</td>
                        <td style="text-align: right;">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Summary Section -->
        <!-- <table style="width: 100%; margin: 10px 0; font-size: 11pt;">
            <tr>
                <td style="text-align: right; width: 50%;">Jumlah Bayar:</td>
                <td style="text-align: right; width: 50%; font-weight: bold;">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="text-align: right;">Metode Pembayaran:</td>
                <td style="text-align: right; font-weight: bold;">{{ $metode }}</td>
            </tr>
            <tr>
                <td style="text-align: right;">Total:</td>
                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
            </tr>
        </table> -->

        <!-- Total Section -->
        <div class="total-section">
            <div class="terbilang">
                Terbilang: {{ ucfirst(\App\Services\TerbilangService::toTerbilang((int)$totalKeseluruhan)) }} rupiah
            </div>
            

            <table class="signature-table">
                <tr>
                    <td class="signature-left">
                        <!-- <div>Bendahara Penerima</div>
                        <div class="signature-space"></div>
                        <div class="signature-name">TINAWATI</div>
                        <div class="signature-nip">NIP.197501201998032006</div> -->
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
                            <tr>
                                <th>Status Pembayaran</th>
                                <td><b>LUNAS</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
