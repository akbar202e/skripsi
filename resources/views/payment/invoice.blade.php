<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
            font-size: 32px;
        }
        .invoice-number {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }
        .invoice-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .meta-section {
            flex: 1;
        }
        .meta-section label {
            font-weight: bold;
            font-size: 12px;
            color: #666;
            display: block;
        }
        .meta-section value {
            font-size: 14px;
            display: block;
            margin-top: 5px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details h3 {
            margin-top: 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            float: right;
            width: 40%;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .total-row.grand-total {
            border-bottom: 2px solid #333;
            border-top: 2px solid #333;
            padding: 15px 0;
            font-weight: bold;
            font-size: 18px;
        }
        .footer {
            clear: both;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .print-button {
            text-align: right;
            margin-bottom: 20px;
        }
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="print-button">
        <button onclick="window.print()">Cetak / Simpan sebagai PDF</button>
    </div>

    <div class="invoice-container">
        <div class="invoice-header">
            <h1>INVOICE PEMBAYARAN</h1>
            <div class="invoice-number">
                Nomor: {{ $pembayaran->merchant_order_id }}
            </div>
        </div>

        <div class="invoice-meta">
            <div class="meta-section">
                <label>DETAIL PEMBAYARAN</label>
                <value>{{ $pembayaran->created_at->format('d F Y') }}</value>
            </div>
            <div class="meta-section">
                <label>NAMA PEMOHON</label>
                <value>{{ $pembayaran->user->name }}</value>
            </div>
            <div class="meta-section">
                <label>EMAIL</label>
                <value>{{ $pembayaran->user->email }}</value>
            </div>
        </div>

        <div class="invoice-details">
            <h3>DETAIL PERMOHONAN</h3>
            <table>
                <tbody>
                    <tr>
                        <td style="width: 30%;">Judul Permohonan</td>
                        <td>{{ $permohonan->judul }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Permohonan</td>
                        <td>#{{ $permohonan->id }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Pengajuan</td>
                        <td>{{ $permohonan->created_at->format('d F Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="invoice-details">
            <h3>DETAIL PEMBAYARAN</h3>
            <table>
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th style="width: 20%;" class="text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pembayaran Permohonan Pengujian</td>
                        <td class="text-right">Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="total-section">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</span>
                </div>
                <div class="total-row">
                    <span>Biaya Admin:</span>
                    <span>Rp 0</span>
                </div>
                <div class="total-row grand-total">
                    <span>TOTAL:</span>
                    <span>Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div class="invoice-details">
            <h3>STATUS PEMBAYARAN</h3>
            <table>
                <tbody>
                    <tr>
                        <td style="width: 30%;">Metode Pembayaran</td>
                        <td>{{ $pembayaran->payment_method_name ?? $pembayaran->payment_method ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            @if($pembayaran->isSuccessful())
                                <strong style="color: green;">✓ BERHASIL</strong>
                            @elseif($pembayaran->isFailed())
                                <strong style="color: red;">✗ GAGAL</strong>
                            @else
                                <strong style="color: orange;">⏳ MENUNGGU</strong>
                            @endif
                        </td>
                    </tr>
                    @if($pembayaran->paid_at)
                        <tr>
                            <td>Tanggal Pembayaran</td>
                            <td>{{ $pembayaran->paid_at->format('d F Y H:i') }}</td>
                        </tr>
                    @endif
                    @if($pembayaran->duitku_reference)
                        <tr>
                            <td>Referensi</td>
                            <td>{{ $pembayaran->duitku_reference }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Terima kasih telah menggunakan layanan kami. Jika ada pertanyaan, silahkan hubungi kami.</p>
            <p>Invoice ini dicetak pada {{ now()->format('d F Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
