<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Validator;

class Calculations2
{
  public static function calculateGasVolume2($data)
  {

    $validator = Validator::make($data, [
      'vt' => 'required',
      'pressure' => 'required',
      'temperature' => 'required',
      'k' => 'required',
    ]);

    if ($validator->fails()) {
      return [
        'status' => 'error',
        'messages' => $validator->errors()->all()
      ];
    }

    // Mengambil data dari input yang sudah divalidasi
    $vt = $data['vt'];
    $pressure = $data['pressure'];
    $temperature = $data['temperature'];
    $k = $data['k'];

    // Hitung m3
    $m3 = $vt * ((1.01325 + $pressure) / 1.01325) * (300 / (273 + $temperature)) * $k;
    $m3 = number_format($m3, 2, '.', '');

    // Mengembalikan ketiga nilai dalam array
    return [
      'status' => 'success',
      'data' => [
        'm3' => $m3,
      ],
    ];
  }
}
