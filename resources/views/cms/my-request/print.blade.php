<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 5px 0;
        }
        .content {
            margin: 20px 0;
        }
        .section {
            margin-bottom: 15px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }
        .row {
            display: flex;
            margin-bottom: 5px;
        }
        .label {
            width: 200px;
            font-weight: bold;
        }
        .value {
            flex: 1;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
        }
        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH KABUPATEN BANDUNG</h2>
        <h2>KECAMATAN CICALENGKA</h2>
        <h2>DESA CICALENGKA KULON</h2>
        <p>Jl. Raya Cicalengka Kulon No. 1, Cicalengka Kulon, Kec. Cicalengka, Kabupaten Bandung, Jawa Barat 40395</p>
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">INFORMASI PENGAJUAN</div>
            <div class="row">
                <div class="label">Nomor Pengajuan</div>
                <div class="value">: {{ $requestLetter->code }}</div>
            </div>
            <div class="row">
                <div class="label">Jenis Pengajuan</div>
                <div class="value">: {{ $requestType->name }}</div>
            </div>
            <div class="row">
                <div class="label">Tanggal Pengajuan</div>
                <div class="value">: {{ date('d-m-Y', strtotime($requestLetter->created_at)) }}</div>
            </div>
            <div class="row">
                <div class="label">Status</div>
                <div class="value">: {{ $requestLetter->status }}</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">DATA PEMOHON</div>
            <div class="row">
                <div class="label">NIK</div>
                <div class="value">: {{ $resident->nik }}</div>
            </div>
            <div class="row">
                <div class="label">Nama Lengkap</div>
                <div class="value">: {{ $resident->name }}</div>
            </div>
            <div class="row">
                <div class="label">Tempat, Tanggal Lahir</div>
                <div class="value">: {{ $resident->pob }}, {{ date('d-m-Y', strtotime($resident->dob)) }}</div>
            </div>
            <div class="row">
                <div class="label">Jenis Kelamin</div>
                <div class="value">: {{ $resident->gender }}</div>
            </div>
            <div class="row">
                <div class="label">Alamat</div>
                <div class="value">: {{ $resident->address }}</div>
            </div>
            <div class="row">
                <div class="label">RT/RW</div>
                <div class="value">: {{ $resident->rt }}/{{ $resident->rw }}</div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">DATA PENGAJUAN</div>
            @foreach($data as $key => $value)
                @if(!in_array($key, ['request_type_id', 'village_head', 'village_head_position', 'id']))
                    <div class="row">
                        <div class="label">{{ __('request-letter.' . $key) }}</div>
                        <div class="value">: {{ str_contains($key, 'date') || str_contains($key, 'dob') ? date('d-m-Y', strtotime($value)) : (str_contains($key, 'income') ? number_format($value) : $value) }}</div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="section">
            <div class="section-title">DOKUMEN LAMPIRAN</div>
            @foreach($requestLetter->documentRequestLetters as $index => $document)
                <div class="row">
                    <div class="label">{{ $index + 1 }}. {{ $document->name }}</div>
                    <div class="value">: Terlampir</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <p>Cicalengka Kulon, {{ date('d F Y') }}</p>
        <div class="signature">
            <p>Kepala Desa Cicalengka Kulon</p>
            <div class="signature-line"></div>
            <p>{{ $data->village_head ?? 'Nama Kepala Desa' }}</p>
        </div>
    </div>
</body>
</html> 