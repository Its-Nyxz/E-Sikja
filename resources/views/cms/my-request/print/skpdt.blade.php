@php
function indoDate($date){
  return \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd D MMMM Y');
}
@endphp
@php
   $settingsPath = public_path('setting/settings.json');
  $setting = json_decode(file_get_contents($settingsPath), true)??[];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= strtoupper($requestType->name) ?></title>
  <link rel="icon" href="{{ asset('storage/settings/logo.png') }}">

<style>
@page {
        margin-top: 0;
        margin-left: 3rem;
        margin-right: 3rem;
        }
        
    body {
      font-family: 'Times New Roman', Times, serif;
      /* margin: 50px; */
      font-size: 15.5px;
    }
    .center {
      text-align: center;
    }
    .bold {
      font-weight: bold;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    td {
      vertical-align: top;
      padding: 4px;
    }
    .signature-table {
      margin-top: 60px;
      width: 100%;
    }
    .signature-table td {
      width: 50%;
      text-align: center;
      vertical-align: top;
    }
    .logo {
      width: 70px;
      height: auto;
    }</style>
  
  <style>

  </style>
</head>
<body>

@include('cms.my-request.print.header')

<table width="100%" border="0">
  <tr style="margin: 0px;">
    <td class="center bold"><h4 style="margin: 0px;"><u><?= strtoupper($requestType->name) ?></u></h4></td>
  </tr>
  <tr style="margin: 0px;">
    <td class="center" >No: {{ $requestLetter->document_number }}</td>
  </tr>
</table>
<table width="100%" border="0" style="margin-top: 10px;">
    <tr>
        <td colspan="3">Yang bertanda tangan dibawah ini : </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Nama</span></td>
        <td width="1%">:</td>
        <td>Budi Triyono, S.Sos.MM </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Jabatan</span></td>
        <td>:</td>
        <td>Lurah Jantiharjo </td>
    </tr>
    <tr>
        <td colspan="3">Yang Menerangkan dengan sesungguhnya bahwa : </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Nama</span></td>
        <td width="1%">:</td>
        <td>{{ $data->name }}</td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Tempat/Tanggal Lahir</span></td>
        <td>:</td>
        <td>{{ $data->pob }}, {{ indoDate($data->dob) }} </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">No. KTP</span></td>
        <td>:</td>
        <td>{{ $data->nik }} </td>
    </tr>
    
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Pekerjaan</span></td>
        <td>:</td>
        <td>{{ $data->occupation }} </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Jenis Kelamin</span></td>
        <td>:</td>
        <td>{{ $data->gender }} </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Agama</span></td>
        <td>:</td>
        <td>{{ $data->religion }} </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Status Perkawinan</span></td>
        <td>:</td>
        <td>{{ $data->marital_status }} </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Agama</span></td>
        <td>:</td>
        <td>{{ $data->religion }} </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Alamat Asal</span></td>
        <td>:</td>
        <td>{{ $data->current_address }} </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Pindah Ke</span></td>
        <td>:</td>
        <td>{{ $data->destination_address }} </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Alasan Pindah</span></td>
        <td>:</td>
        <td>{{ $data->moving_reason }} </td>
    </tr>
    <tr>
        <td width="35%"><span style="margin-left: 40px;">Pengikut Sejumlah</span></td>
        <td>:</td>
        <td>{{ $data->followers_count }} </td>
    </tr>
    <tr>
        <td style="text-align: justify; line-height: 1.5;" colspan="3">
          Nama tersebut diatas adalah benar warga kami yang berdomisili alamat diatas serta kami menerangkan nama tersebut benar berkelakuan baik dan belum pernah tersangkut perkara Polisi.
            <br>
            <br>
            Demikian surat keterangan ini kami buat agar dapat digunakan sebagaimana mestinya.
        </td>
    </tr>
</table>
<table style="float: right; margin-top: 20px;" border="0">
    <tr>
        <td width="60%"></td>
        <td colspan="3" style="text-align: center;">Jatiharjo, {{ indoDate($requestLetter->created_at) }}
            <br>
            Lurah Jantiharjo
        </td>
    </tr>
    <tr>
         <td width="60%" style="text-align: center; padding-top: 100px;">
            @if ($setting['cap_lurah'])
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('setting/'.$setting['cap_lurah']))) }}" class="logo" style="position: absolute; top: 47rem; left: 25rem; width: 250px; height: auto;">
                
            @endif
            @if ($setting['ttd_lurah'])
                
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('setting/'.$setting['ttd_lurah']))) }}" class="logo" style="position: absolute; top: 46rem; left: 28rem; width: 200px; height: auto;">
            @endif
        </td>
        <td colspan="3" style="text-align: center; vertical-align: bottom;">{{  $setting['nama_lurah'] }}</td>
    </tr>
</table>
</body>
</html>



