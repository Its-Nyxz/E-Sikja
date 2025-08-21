<table style="width: 100%;" border="0">
  <tr>
    
    <td class="bold" style="text-align: center; margin:left: 100px !important;">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('setting/'.$setting['logo']))) }}" class="logo" style="position: absolute; top: 5px; left: 0; width: 100px; height: auto;">
      <h3 style="margin:3px; margin-left: 0px;">PEMERINTAH KABUPATEN KARANGANYAR</h3>
      <h3 style="margin:3px; margin-left: 0px;">KECAMATAN KARANGANYAR</h3>
      <h3 style="margin:3px; margin-left: 0px;">KELURAHAN JANTIHARJO</h3>
      <h5 style="margin:3px; margin-left: 0px;">{{ $setting['alamat'] }}</h5>
      <h5 style="margin:3px; margin-left: 0px;">Email:{{ $setting['email'] }}</h5>
    </td>
  </tr>
</table>
<hr style="border-top: 4px double black; border-bottom: 1px solid black; margin-top: 15px; margin-bottom: 15px;">

