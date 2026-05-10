<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print QR Code Sampel - {{ $permohonan->sample_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            display: no-print;
        }

        .header h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .print-button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .print-button-group button {
            padding: 10px 20px;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .print-button-group button:hover {
            background-color: #2563eb;
        }

        .print-button-group .back-button {
            background-color: #6b7280;
        }

        .print-button-group .back-button:hover {
            background-color: #4b5563;
        }

        /* Container untuk labels yang akan di-print */
        .print-labels {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        .label {
            width: 100%;
            max-width: 300px;
            padding: 20px;
            border: 2px dashed #ccc;
            background-color: white;
            text-align: center;
            page-break-inside: avoid;
            break-inside: avoid;
            margin: 0 auto;
        }

        .label-header {
            font-size: 12px;
            color: #666;
            font-weight: 500;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .qr-code-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .qr-code-container img {
            width: 200px;
            height: 200px;
            border: 1px solid #ddd;
            padding: 5px;
            background-color: white;
        }

        .label-code {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            letter-spacing: 1px;
            margin-bottom: 5px;
            font-family: 'Courier New', monospace;
        }

        .label-subtext {
            font-size: 11px;
            color: #666;
            margin-top: 10px;
        }

        .label-info {
            font-size: 10px;
            color: #999;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dotted #ddd;
        }

        .cut-line {
            position: relative;
            text-align: center;
            font-size: 10px;
            color: #999;
            margin: 30px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .cut-line::before,
        .cut-line::after {
            content: '';
            flex: 1;
            height: 1px;
            background-image: repeating-linear-gradient(
                to right,
                #999,
                #999 5px,
                transparent 5px,
                transparent 10px
            );
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .header,
            .print-button-group {
                display: none;
            }

            .print-labels {
                grid-template-columns: repeat(1, 1fr);
                page-break-inside: avoid;
            }

            .label {
                page-break-inside: avoid;
                break-inside: avoid;
                margin-bottom: 40px;
            }

            .cut-line {
                display: flex;
                page-break-inside: avoid;
            }
        }

        @media (max-width: 768px) {
            .print-labels {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏷️ Print Label QR Code Sampel</h1>
            <p>Kode Sampel: <strong>{{ $permohonan->sample_code }}</strong></p>
            <p style="font-size: 12px; color: #666;">Permohonan: {{ $permohonan->judul }}</p>
        </div>

        <div class="print-button-group">
            <button onclick="window.print()">Print Label</button>
        </div>

        <div class="print-labels">
            <!-- Label 1 -->
            <div class="label">
                <div class="label-header">Label Sampel</div>
                <div class="qr-code-container">
                    <img src="{{ $qrCodeBase64 }}" alt="QR Code {{ $permohonan->sample_code }}">
                </div>
                <div class="label-code">{{ $permohonan->sample_code }}</div>
                <div class="label-subtext">Scan untuk melihat detail sampel</div>
                <div class="label-info">
                    Tanggal: {{ now()->format('d/m/Y') }}<br>
                    Pemohon: {{ $permohonan->pemohon->name }}
                </div>
            </div>

            <!-- Label 2 (duplicate untuk kemudahan) -->
            <div class="label">
                <div class="label-header">Label Sampel</div>
                <div class="qr-code-container">
                    <img src="{{ $qrCodeBase64 }}" alt="QR Code {{ $permohonan->sample_code }}">
                </div>
                <div class="label-code">{{ $permohonan->sample_code }}</div>
                <div class="label-subtext">Scan untuk melihat detail sampel</div>
                <div class="label-info">
                    Tanggal: {{ now()->format('d/m/Y') }}<br>
                    Pemohon: {{ $permohonan->pemohon->name }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus print dialog untuk UX yang lebih baik
        window.addEventListener('load', function() {
            // Uncomment jika ingin auto-open print dialog
            // window.print();
        });
    </script>
</body>
</html>
