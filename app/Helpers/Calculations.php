<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Validator;

class Calculations
{
  public static function calculateGasVolume($data)
  {

    $validator = Validator::make($data, [
      'specific_gravity' => 'required',
      'CO2' => 'required',
      'N2' => 'required',
      'heating_value' => 'required',
      'temperature' => 'required',
      'pressure' => 'required',
      'tube_volume' => 'required',
    ]);

    if ($validator->fails()) {
      return [
        'status' => 'error',
        'messages' => $validator->errors()->all()
      ];
    }

    // Mengambil data dari input yang sudah divalidasi
    $specific_gravity = $data['specific_gravity'];
    $CO2 = $data['CO2'];
    $N2 = $data['N2'];
    $heating_value = $data['heating_value'];
    $temperature = $data['temperature'];
    $pressure = $data['pressure'];
    $tube_volume = $data['tube_volume'];

    $tube_volume2 = $tube_volume / 1000;
    $P = $pressure * 14.504;
    $P2 = (($P * (156.47 / (160.8 - 7.22 * $specific_gravity + $CO2 - 0.392 * $N2))) + 14.7) / 1000;
    $T = $temperature * 9 / 5 + 32;
    $T2 = (($T + 460) * 226.29 / (99.15 + 211.9 * $specific_gravity - ($CO2 + 1.681 * $N2))) / 500;
    $H = 0.0330378 * pow($T2, -2) - 0.0221323 * pow($T2, -3) + 0.0161353 * pow($T2, -5);
    $I = (0.265827 * pow($T2, -2) + 0.0457697 * pow($T2, -4) - 0.133185 * pow($T2, -1)) / $H;
    $B = (3 - $H * pow($I, 2)) / (9 * $H * pow($P2, 2));

    // Hitung E1 dan E2
    $E1 = ($T2 < 1.09)
      ? (1 - 0.00075 * pow($P2, 2.3) * (2 - exp(-20 * (1.09 - $T2))))
      : (1 - 0.00075 * pow($P2, 2.3) * exp(-20 * ($T2 - 1.09)));

    $E2 = ($T2 < 1.09)
      ? $E1 - 1.317 * pow((1.09 - $T2), 4) * $P2 * (1.69 - pow($P2, 2))
      : $E1 - 0.0011 * sqrt($T2 - 1.09) * pow($P2, 2) * pow((2.17 + 1.4 * sqrt($T2 - 1.09) - $P2), 2);

    // Hitung F, D, FPV
    $F = (9 * $I - 2 * $H * pow($I, 3)) / (54 * $H * pow($P2, 3)) - ($E2 / (2 * $H * pow($P2, 2)));
    $D = pow(($F + sqrt(pow($F, 2) + pow($B, 3))), 1 / 3);
    $FPV = sqrt($B / $D - $D + $I / (3 * $P2)) / (1 + 0.00132 / pow($T2, 3.25));

    // Hitung m3, volume_std, heating_quantity
    $m3 = $tube_volume2 * ($pressure + 1.01325) / 1.01325 * (273 + 27) / (273 + $temperature) * $FPV ** 2;
    $m3 = number_format($m3, 2, '.', '');
    $volume_std = $m3 * 35.3147 * 288.56 / 300 / 1000000;
    $heating_quantity = $volume_std * $heating_value;

    // Mengembalikan ketiga nilai dalam array
    return [
      'status' => 'success',
      'data' => [
        'm3' => $m3,
        'volume_std' => $volume_std,
        'heating_quantity' => $heating_quantity,
      ],
    ];
  }
}
