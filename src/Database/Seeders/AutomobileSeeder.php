<?php

namespace Automobile\Database\Seeders;

use Automobile\Models\Manufacturer;
use Automobile\Models\Part;
use Automobile\Models\Variant;
use Automobile\Models\Vehicle;
use Automobile\Models\VehicleModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AutomobileSeeder extends Seeder
{
    /**
     * The full catalog, keyed by fixed primary-key id at every level
     * (manufacturer id => model id => variant id). Each vehicle takes the id of its
     * variant. IDS ARE PERMANENT: to add an entry, give it the next unused id and
     * append it - never reuse, renumber, or reorder ids.
     */
    private array $catalog = [
        1 => ['name' => 'Maruti Suzuki', 'models' => [
            1 => [
                'name' => 'Swift',
                'body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2018-02-09', 'origin' => 'India',
                'variants' => [1 => 'LXi', 2 => 'VXi', 3 => 'ZXi', 4 => 'ZXi+'],
            ],
            2 => [
                'name' => 'Baleno',
                'body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2022-01-18', 'origin' => 'India',
                'variants' => [5 => 'Sigma', 6 => 'Delta', 7 => 'Zeta', 8 => 'Alpha'],
            ],
            3 => [
                'name' => 'Brezza',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2022-06-30', 'origin' => 'India',
                'variants' => [9 => 'LXi', 10 => 'VXi', 11 => 'ZXi', 12 => 'ZXi+'],
            ],
            4 => [
                'name' => 'Dzire',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2020-05-24', 'origin' => 'India',
                'variants' => [13 => 'LXi', 14 => 'VXi', 15 => 'ZXi', 16 => 'ZXi+'],
            ],
            5 => [
                'name' => 'Ertiga',
                'body_type' => 'MPV', 'fuel_type' => 'Petrol', 'seating_capacity' => 7,
                'launch_date' => '2018-11-21', 'origin' => 'India',
                'variants' => [17 => 'LXi', 18 => 'VXi', 19 => 'ZXi', 20 => 'ZXi+'],
            ],
        ]],
        2 => ['name' => 'Tata Motors', 'models' => [
            6 => [
                'name' => 'Nexon',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2023-09-14', 'origin' => 'India',
                'variants' => [21 => 'Smart', 22 => 'Pure', 23 => 'Creative', 24 => 'Fearless'],
            ],
            7 => [
                'name' => 'Punch',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-10-19', 'origin' => 'India',
                'variants' => [25 => 'Smart', 26 => 'Pure', 27 => 'Adventure', 28 => 'Accomplished'],
            ],
            8 => [
                'name' => 'Altroz',
                'body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2020-01-22', 'origin' => 'India',
                'variants' => [29 => 'XE', 30 => 'XM', 31 => 'XT', 32 => 'XZ'],
            ],
            9 => [
                'name' => 'Harrier',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5,
                'launch_date' => '2023-10-19', 'origin' => 'India',
                'variants' => [33 => 'Smart', 34 => 'Pure X', 35 => 'Adventure X', 36 => 'Fearless X'],
            ],
        ]],
        3 => ['name' => 'Hyundai', 'models' => [
            10 => [
                'name' => 'Creta',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2024-01-16', 'origin' => 'India',
                'variants' => [37 => 'E', 38 => 'EX', 39 => 'S', 40 => 'SX', 41 => 'SX(O)'],
            ],
            11 => [
                'name' => 'Venue',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2019-05-21', 'origin' => 'India',
                'variants' => [42 => 'E', 43 => 'S', 44 => 'SX', 45 => 'SX(O)'],
            ],
            12 => [
                'name' => 'i20',
                'body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2020-11-04', 'origin' => 'India',
                'variants' => [46 => 'Magna', 47 => 'Sportz', 48 => 'Asta', 49 => 'Asta(O)'],
            ],
        ]],
        4 => ['name' => 'Mahindra', 'models' => [
            13 => [
                'name' => 'XUV700',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2021-08-14', 'origin' => 'India',
                'variants' => [50 => 'MX', 51 => 'AX3', 52 => 'AX5', 53 => 'AX7'],
            ],
            14 => [
                'name' => 'Thar',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 4,
                'launch_date' => '2020-10-02', 'origin' => 'India',
                'variants' => [54 => 'AX(O)', 55 => 'LX'],
            ],
            15 => [
                'name' => 'Scorpio-N',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2022-06-27', 'origin' => 'India',
                'variants' => [56 => 'Z2', 57 => 'Z4', 58 => 'Z6', 59 => 'Z8'],
            ],
        ]],
        5 => ['name' => 'Kia', 'models' => [
            16 => [
                'name' => 'Seltos',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2019-08-22', 'origin' => 'India',
                'variants' => [60 => 'HTE', 61 => 'HTK', 62 => 'HTX', 63 => 'GTX'],
            ],
            17 => [
                'name' => 'Sonet',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2020-09-18', 'origin' => 'India',
                'variants' => [64 => 'HTE', 65 => 'HTK', 66 => 'HTX', 67 => 'GTX'],
            ],
        ]],
        6 => ['name' => 'Toyota', 'models' => [
            18 => [
                'name' => 'Innova Crysta',
                'body_type' => 'MPV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2016-05-03', 'origin' => 'India',
                'variants' => [68 => 'GX', 69 => 'VX', 70 => 'ZX'],
            ],
            19 => [
                'name' => 'Fortuner',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2021-01-06', 'origin' => 'India',
                'variants' => [71 => '4x2', 72 => '4x4', 73 => 'Legender'],
            ],
        ]],
        7 => ['name' => 'Honda', 'models' => [
            20 => [
                'name' => 'City',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2020-07-15', 'origin' => 'India',
                'variants' => [74 => 'SV', 75 => 'V', 76 => 'ZX', 77 => 'ZX+'],
            ],
            21 => [
                'name' => 'Amaze',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-08-16', 'origin' => 'India',
                'variants' => [78 => 'V', 79 => 'VX', 80 => 'ZX'],
            ],
            22 => [
                'name' => 'Activa 125',
                'body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2019-02-01', 'origin' => 'India',
                'variants' => [81 => 'Standard', 82 => 'DLX', 83 => 'Smart Key'],
            ],
            23 => [
                'name' => 'Shine 125',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2016-01-01', 'origin' => 'India',
                'variants' => [84 => 'Standard', 85 => 'DLX'],
            ],
            24 => [
                'name' => 'Unicorn',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2004-01-01', 'origin' => 'India',
                'variants' => [86 => 'Standard'],
            ],
            25 => [
                'name' => 'SP 125',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2018-08-01', 'origin' => 'India',
                'variants' => [87 => 'Standard', 88 => 'Disc'],
            ],
            26 => [
                'name' => 'Dio 125',
                'body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2021-11-01', 'origin' => 'India',
                'variants' => [89 => 'Standard', 90 => 'DLX'],
            ],
        ]],
        8 => ['name' => 'MG Motor', 'models' => [
            27 => [
                'name' => 'Hector',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2019-06-27', 'origin' => 'India',
                'variants' => [91 => 'Style', 92 => 'Super', 93 => 'Smart', 94 => 'Sharp'],
            ],
            28 => [
                'name' => 'Astor',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-10-15', 'origin' => 'India',
                'variants' => [95 => 'Style', 96 => 'Super', 97 => 'Sharp', 98 => 'Sharp Pro'],
            ],
            29 => [
                'name' => 'Gloster',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2020-11-04', 'origin' => 'India',
                'variants' => [99 => 'Super', 100 => 'Smart', 101 => 'Sharp', 102 => 'Savvy'],
            ],
            30 => [
                'name' => 'Comet EV',
                'body_type' => 'Hatchback', 'fuel_type' => 'Electric', 'seating_capacity' => 4,
                'launch_date' => '2023-05-24', 'origin' => 'India',
                'variants' => [103 => 'Pace', 104 => 'Play'],
            ],
            31 => [
                'name' => 'Windsor EV',
                'body_type' => 'MPV', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2024-09-11', 'origin' => 'India',
                'variants' => [105 => 'Excite', 106 => 'Exclusive', 107 => 'Essence'],
            ],
        ]],
        9 => ['name' => 'Skoda', 'models' => [
            32 => [
                'name' => 'Kylaq',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2024-11-15', 'origin' => 'India',
                'variants' => [108 => 'Classic', 109 => 'Signature', 110 => 'Signature+', 111 => 'Sportline'],
            ],
            33 => [
                'name' => 'Slavia',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2022-02-24', 'origin' => 'India',
                'variants' => [112 => 'Active', 113 => 'Ambition', 114 => 'Style'],
            ],
            34 => [
                'name' => 'Kushaq',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-06-07', 'origin' => 'India',
                'variants' => [115 => 'Active', 116 => 'Ambition', 117 => 'Style'],
            ],
        ]],
        10 => ['name' => 'Volkswagen', 'models' => [
            35 => [
                'name' => 'Virtus',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2022-06-09', 'origin' => 'India',
                'variants' => [118 => 'Comfortline', 119 => 'Highline', 120 => 'Topline'],
            ],
            36 => [
                'name' => 'Taigun',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-09-23', 'origin' => 'India',
                'variants' => [121 => 'Comfortline', 122 => 'Highline', 123 => 'Topline'],
            ],
            37 => [
                'name' => 'Tiguan',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2024-11-06', 'origin' => 'Germany',
                'variants' => [124 => 'Elegance', 125 => 'R-Line'],
            ],
        ]],
        11 => ['name' => 'Renault', 'models' => [
            38 => [
                'name' => 'Kwid',
                'body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2015-09-01', 'origin' => 'India',
                'variants' => [126 => 'RXE', 127 => 'RXL', 128 => 'RXT', 129 => 'Climber'],
            ],
            39 => [
                'name' => 'Triber',
                'body_type' => 'MPV', 'fuel_type' => 'Petrol', 'seating_capacity' => 7,
                'launch_date' => '2019-08-28', 'origin' => 'India',
                'variants' => [130 => 'RXE', 131 => 'RXL', 132 => 'RXT', 133 => 'Emotion'],
            ],
            40 => [
                'name' => 'Kiger',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-02-15', 'origin' => 'India',
                'variants' => [134 => 'RXE', 135 => 'RXL', 136 => 'RXT', 137 => 'RXZ'],
            ],
        ]],
        12 => ['name' => 'Nissan', 'models' => [
            41 => [
                'name' => 'Magnite',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2020-12-02', 'origin' => 'India',
                'variants' => [138 => 'Visia', 139 => 'Acenta', 140 => 'N-Connecta', 141 => 'Tekna'],
            ],
            42 => [
                'name' => 'X-Trail',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 7,
                'launch_date' => '2023-11-01', 'origin' => 'Japan',
                'variants' => [142 => 'Acenta', 143 => 'N-Connecta', 144 => 'Tekna'],
            ],
        ]],
        13 => ['name' => 'Citroen', 'models' => [
            43 => [
                'name' => 'C3',
                'body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2022-07-20', 'origin' => 'India',
                'variants' => [145 => 'Live', 146 => 'You', 147 => 'Feel', 148 => 'Shine'],
            ],
            44 => [
                'name' => 'Basalt',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2024-08-05', 'origin' => 'India',
                'variants' => [149 => 'You', 150 => 'Plus', 151 => 'Max'],
            ],
            45 => [
                'name' => 'C5 Aircross',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5,
                'launch_date' => '2021-10-07', 'origin' => 'India',
                'variants' => [152 => 'Feel', 153 => 'Shine'],
            ],
        ]],
        14 => ['name' => 'Audi', 'models' => [
            46 => [
                'name' => 'A4',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2016-06-01', 'origin' => 'India',
                'variants' => [154 => 'Premium', 155 => 'Premium Plus', 156 => 'Technology'],
            ],
            47 => [
                'name' => 'Q3',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2019-09-19', 'origin' => 'India',
                'variants' => [157 => 'Premium', 158 => 'Premium Plus', 159 => 'Technology'],
            ],
            48 => [
                'name' => 'Q5',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-01-14', 'origin' => 'Germany',
                'variants' => [160 => 'Premium Plus', 161 => 'Technology'],
            ],
            49 => [
                'name' => 'Q7',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2022-06-15', 'origin' => 'India',
                'variants' => [162 => 'Premium Plus', 163 => 'Technology'],
            ],
        ]],
        15 => ['name' => 'BMW', 'models' => [
            50 => [
                'name' => '3 Series',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2019-08-08', 'origin' => 'India',
                'variants' => [164 => 'Sport', 165 => 'Luxury Line', 166 => 'M Sport'],
            ],
            51 => [
                'name' => '5 Series',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2024-03-01', 'origin' => 'India',
                'variants' => [167 => 'Sport', 168 => 'Luxury Line', 169 => 'M Sport'],
            ],
            52 => [
                'name' => 'X1',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5,
                'launch_date' => '2023-01-24', 'origin' => 'India',
                'variants' => [170 => 'sDrive20i', 171 => 'xDrive20d'],
            ],
            53 => [
                'name' => 'X3',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5,
                'launch_date' => '2021-11-18', 'origin' => 'India',
                'variants' => [172 => 'xDrive20', 173 => 'xDrive20d', 174 => 'M40i'],
            ],
            54 => [
                'name' => 'X5',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2019-08-01', 'origin' => 'India',
                'variants' => [175 => 'xDrive40i', 176 => 'M Competition'],
            ],
        ]],
        16 => ['name' => 'Mercedes-Benz', 'models' => [
            55 => [
                'name' => 'C-Class',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2022-08-10', 'origin' => 'India',
                'variants' => [177 => 'Progressive', 178 => 'Avantgarde'],
            ],
            56 => [
                'name' => 'E-Class',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2024-04-01', 'origin' => 'India',
                'variants' => [179 => 'Avantgarde', 180 => 'AMG Line'],
            ],
            57 => [
                'name' => 'GLA',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2020-11-19', 'origin' => 'Germany',
                'variants' => [181 => 'Progressive', 182 => 'Avantgarde'],
            ],
            58 => [
                'name' => 'GLC',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2023-08-08', 'origin' => 'India',
                'variants' => [183 => 'Progressive', 184 => 'Avantgarde'],
            ],
            59 => [
                'name' => 'GLE',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5,
                'launch_date' => '2019-11-01', 'origin' => 'India',
                'variants' => [185 => 'Avantgarde', 186 => 'AMG Line'],
            ],
        ]],
        17 => ['name' => 'Mini', 'models' => [
            60 => [
                'name' => 'Cooper',
                'body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 4,
                'launch_date' => '2021-08-01', 'origin' => 'United Kingdom',
                'variants' => [187 => 'Cooper', 188 => 'Cooper S'],
            ],
            61 => [
                'name' => 'Countryman',
                'body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2024-10-01', 'origin' => 'Germany',
                'variants' => [189 => 'Classic', 190 => 'Favoured Pack', 191 => 'JCW'],
            ],
        ]],
        18 => ['name' => 'Volvo', 'models' => [
            62 => [
                'name' => 'XC40',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2018-08-08', 'origin' => 'Sweden',
                'variants' => [192 => 'Momentum', 193 => 'Inscription', 194 => 'Ultimate'],
            ],
            63 => [
                'name' => 'XC60',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-04-07', 'origin' => 'Sweden',
                'variants' => [195 => 'Inscription', 196 => 'Ultimate'],
            ],
            64 => [
                'name' => 'XC90',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2015-11-01', 'origin' => 'Sweden',
                'variants' => [197 => 'Inscription', 198 => 'Ultimate'],
            ],
        ]],
        19 => ['name' => 'Porsche', 'models' => [
            65 => [
                'name' => 'Macan',
                'body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2024-02-01', 'origin' => 'Germany',
                'variants' => [199 => 'Macan', 200 => 'Macan S', 201 => 'Macan GTS'],
            ],
            66 => [
                'name' => 'Cayenne',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2023-05-01', 'origin' => 'Germany',
                'variants' => [202 => 'Cayenne', 203 => 'Cayenne S', 204 => 'Cayenne Turbo'],
            ],
            67 => [
                'name' => 'Panamera',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2024-05-01', 'origin' => 'Germany',
                'variants' => [205 => 'Panamera', 206 => 'Panamera 4', 207 => 'Panamera Turbo'],
            ],
            68 => [
                'name' => '911',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 4,
                'launch_date' => '2019-11-01', 'origin' => 'Germany',
                'variants' => [208 => 'Carrera', 209 => 'Carrera S', 210 => 'Turbo'],
            ],
        ]],
        20 => ['name' => 'BYD', 'models' => [
            69 => [
                'name' => 'Atto 3',
                'body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2022-10-11', 'origin' => 'China',
                'variants' => [211 => 'Dynamic', 212 => 'Premium'],
            ],
            70 => [
                'name' => 'Seal',
                'body_type' => 'Sedan', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2024-03-05', 'origin' => 'China',
                'variants' => [213 => 'Premium', 214 => 'Performance'],
            ],
            71 => [
                'name' => 'Sealion 7',
                'body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2025-04-01', 'origin' => 'China',
                'variants' => [215 => 'Premium', 216 => 'Performance'],
            ],
            72 => [
                'name' => 'eMax 7',
                'body_type' => 'MPV', 'fuel_type' => 'Electric', 'seating_capacity' => 7,
                'launch_date' => '2024-11-06', 'origin' => 'China',
                'variants' => [217 => 'Premium', 218 => 'Superior'],
            ],
        ]],
        21 => ['name' => 'Land Rover', 'models' => [
            73 => [
                'name' => 'Defender',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5,
                'launch_date' => '2020-10-15', 'origin' => 'United Kingdom',
                'variants' => [219 => '90', 220 => '110', 221 => '130'],
            ],
            74 => [
                'name' => 'Discovery Sport',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2020-02-01', 'origin' => 'India',
                'variants' => [222 => 'S', 223 => 'SE', 224 => 'HSE'],
            ],
            75 => [
                'name' => 'Range Rover Evoque',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2019-11-01', 'origin' => 'India',
                'variants' => [225 => 'S', 226 => 'SE', 227 => 'HSE'],
            ],
            76 => [
                'name' => 'Range Rover Sport',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5,
                'launch_date' => '2023-02-01', 'origin' => 'United Kingdom',
                'variants' => [228 => 'SE', 229 => 'HSE', 230 => 'Autobiography'],
            ],
        ]],
        22 => ['name' => 'Jaguar', 'models' => [
            77 => [
                'name' => 'F-Pace',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-05-01', 'origin' => 'United Kingdom',
                'variants' => [231 => 'R-Dynamic S'],
            ],
        ]],
        23 => ['name' => 'Lexus', 'models' => [
            78 => [
                'name' => 'ES',
                'body_type' => 'Sedan', 'fuel_type' => 'Hybrid', 'seating_capacity' => 5,
                'launch_date' => '2019-01-24', 'origin' => 'Japan',
                'variants' => [232 => '350h', 233 => '500e'],
            ],
            79 => [
                'name' => 'RX',
                'body_type' => 'SUV', 'fuel_type' => 'Hybrid', 'seating_capacity' => 5,
                'launch_date' => '2023-08-01', 'origin' => 'Japan',
                'variants' => [234 => '350h', 235 => '500h'],
            ],
            80 => [
                'name' => 'NX',
                'body_type' => 'SUV', 'fuel_type' => 'Hybrid', 'seating_capacity' => 5,
                'launch_date' => '2021-12-01', 'origin' => 'Japan',
                'variants' => [236 => '350h'],
            ],
        ]],
        24 => ['name' => 'Bajaj', 'models' => [
            81 => [
                'name' => 'Qute',
                'body_type' => 'Quadricycle', 'fuel_type' => 'CNG', 'seating_capacity' => 4,
                'launch_date' => '2019-11-01', 'origin' => 'India',
                'variants' => [237 => 'Standard', 238 => 'CNG'],
            ],
            82 => [
                'name' => 'Pulsar NS200',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2012-03-01', 'origin' => 'India',
                'variants' => [239 => 'Standard', 240 => 'ABS'],
            ],
            83 => [
                'name' => 'Pulsar N250',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2022-07-01', 'origin' => 'India',
                'variants' => [241 => 'Standard'],
            ],
            84 => [
                'name' => 'Platina 100',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2006-01-01', 'origin' => 'India',
                'variants' => [242 => 'Standard', 243 => 'ES'],
            ],
            85 => [
                'name' => 'Dominar 400',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2017-12-01', 'origin' => 'India',
                'variants' => [244 => 'Standard'],
            ],
            86 => [
                'name' => 'Chetak',
                'body_type' => 'Scooter', 'fuel_type' => 'Electric', 'seating_capacity' => 2,
                'launch_date' => '2020-01-16', 'origin' => 'India',
                'variants' => [245 => 'Standard', 246 => 'Premium'],
            ],
        ]],
        25 => ['name' => 'Force Motors', 'models' => [
            87 => [
                'name' => 'Gurkha',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 4,
                'launch_date' => '2021-09-16', 'origin' => 'India',
                'variants' => [247 => '3-Door', 248 => '5-Door'],
            ],
            88 => [
                'name' => 'Trax Cruiser',
                'body_type' => 'MPV', 'fuel_type' => 'Diesel', 'seating_capacity' => 9,
                'launch_date' => '2017-01-01', 'origin' => 'India',
                'variants' => [249 => 'Standard', 250 => 'Deluxe'],
            ],
            89 => [
                'name' => 'Urbania',
                'body_type' => 'Van', 'fuel_type' => 'Diesel', 'seating_capacity' => 13,
                'launch_date' => '2021-08-19', 'origin' => 'India',
                'variants' => [251 => 'Standard', 252 => 'Premium'],
            ],
        ]],
        26 => ['name' => 'Isuzu', 'models' => [
            90 => [
                'name' => 'D-Max',
                'body_type' => 'Pickup', 'fuel_type' => 'Diesel', 'seating_capacity' => 5,
                'launch_date' => '2022-01-01', 'origin' => 'India',
                'variants' => [253 => 'Regular Cab', 254 => 'V-Cross', 255 => 'Hi-Lander'],
            ],
            91 => [
                'name' => 'MU-X',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2022-06-01', 'origin' => 'India',
                'variants' => [256 => 'Standard', 257 => '4x4'],
            ],
        ]],
        27 => ['name' => 'Jeep', 'models' => [
            92 => [
                'name' => 'Compass',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5,
                'launch_date' => '2017-07-01', 'origin' => 'India',
                'variants' => [258 => 'Longitude', 259 => 'Limited', 260 => 'Trailhawk'],
            ],
            93 => [
                'name' => 'Meridian',
                'body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7,
                'launch_date' => '2022-06-07', 'origin' => 'India',
                'variants' => [261 => 'Longitude', 262 => 'Limited'],
            ],
            94 => [
                'name' => 'Wrangler',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2023-01-01', 'origin' => 'United States',
                'variants' => [263 => 'Sahara', 264 => 'Rubicon'],
            ],
            95 => [
                'name' => 'Grand Cherokee',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2022-08-01', 'origin' => 'United States',
                'variants' => [265 => 'Limited', 266 => 'Overland'],
            ],
        ]],
        28 => ['name' => 'Aston Martin', 'models' => [
            96 => [
                'name' => 'Vantage',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2024-05-01', 'origin' => 'United Kingdom',
                'variants' => [267 => 'Standard'],
            ],
            97 => [
                'name' => 'DB12',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 4,
                'launch_date' => '2023-11-01', 'origin' => 'United Kingdom',
                'variants' => [268 => 'Standard'],
            ],
            98 => [
                'name' => 'Vanquish',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2025-01-01', 'origin' => 'United Kingdom',
                'variants' => [269 => 'Standard'],
            ],
            99 => [
                'name' => 'DBX',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-02-01', 'origin' => 'United Kingdom',
                'variants' => [270 => 'DBX707'],
            ],
        ]],
        29 => ['name' => 'Bentley', 'models' => [
            100 => [
                'name' => 'Continental GT',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 4,
                'launch_date' => '2021-03-01', 'origin' => 'United Kingdom',
                'variants' => [271 => 'Standard', 272 => 'Azure', 273 => 'Speed'],
            ],
            101 => [
                'name' => 'Bentayga',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-01-01', 'origin' => 'United Kingdom',
                'variants' => [274 => 'Standard', 275 => 'Azure', 276 => 'Speed'],
            ],
            102 => [
                'name' => 'Flying Spur',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2022-01-01', 'origin' => 'United Kingdom',
                'variants' => [277 => 'Standard', 278 => 'Azure', 279 => 'Speed'],
            ],
        ]],
        30 => ['name' => 'Ferrari', 'models' => [
            103 => [
                'name' => 'Roma',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 4,
                'launch_date' => '2021-02-01', 'origin' => 'Italy',
                'variants' => [280 => 'Coupe', 281 => 'Spider'],
            ],
            104 => [
                'name' => 'Purosangue',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 4,
                'launch_date' => '2024-01-01', 'origin' => 'Italy',
                'variants' => [282 => 'Standard'],
            ],
            105 => [
                'name' => '296',
                'body_type' => 'Coupe', 'fuel_type' => 'Hybrid', 'seating_capacity' => 2,
                'launch_date' => '2023-06-01', 'origin' => 'Italy',
                'variants' => [283 => 'GTB', 284 => 'GTS'],
            ],
        ]],
        31 => ['name' => 'Lamborghini', 'models' => [
            106 => [
                'name' => 'Urus',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2018-01-01', 'origin' => 'Italy',
                'variants' => [285 => 'S', 286 => 'Performante'],
            ],
            107 => [
                'name' => 'Huracan',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2015-01-01', 'origin' => 'Italy',
                'variants' => [287 => 'EVO', 288 => 'Sterrato'],
            ],
            108 => [
                'name' => 'Temerario',
                'body_type' => 'Coupe', 'fuel_type' => 'Hybrid', 'seating_capacity' => 2,
                'launch_date' => '2025-01-01', 'origin' => 'Italy',
                'variants' => [289 => 'Standard'],
            ],
            109 => [
                'name' => 'Revuelto',
                'body_type' => 'Coupe', 'fuel_type' => 'Hybrid', 'seating_capacity' => 2,
                'launch_date' => '2024-01-01', 'origin' => 'Italy',
                'variants' => [290 => 'Standard'],
            ],
        ]],
        32 => ['name' => 'Lotus', 'models' => [
            110 => [
                'name' => 'Emira',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2025-01-01', 'origin' => 'United Kingdom',
                'variants' => [291 => 'V6 First Edition', 292 => 'V6 SE'],
            ],
            111 => [
                'name' => 'Eletre',
                'body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2024-01-01', 'origin' => 'China',
                'variants' => [293 => 'Standard', 294 => 'S', 295 => 'R'],
            ],
            112 => [
                'name' => 'Emeya',
                'body_type' => 'Sedan', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2025-01-01', 'origin' => 'China',
                'variants' => [296 => 'Standard', 297 => 'R'],
            ],
        ]],
        33 => ['name' => 'Maserati', 'models' => [
            113 => [
                'name' => 'Ghibli',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2014-01-01', 'origin' => 'Italy',
                'variants' => [298 => 'Standard', 299 => 'Modena', 300 => 'Trofeo'],
            ],
            114 => [
                'name' => 'Levante',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2017-01-01', 'origin' => 'Italy',
                'variants' => [301 => 'Standard', 302 => 'Modena', 303 => 'Trofeo'],
            ],
            115 => [
                'name' => 'Grecale',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2023-01-01', 'origin' => 'Italy',
                'variants' => [304 => 'GT', 305 => 'Modena', 306 => 'Trofeo'],
            ],
        ]],
        34 => ['name' => 'Rolls-Royce', 'models' => [
            116 => [
                'name' => 'Ghost',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2021-01-01', 'origin' => 'United Kingdom',
                'variants' => [307 => 'Standard', 308 => 'Extended', 309 => 'Black Badge'],
            ],
            117 => [
                'name' => 'Phantom',
                'body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2018-01-01', 'origin' => 'United Kingdom',
                'variants' => [310 => 'Standard', 311 => 'Extended'],
            ],
            118 => [
                'name' => 'Cullinan',
                'body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5,
                'launch_date' => '2019-01-01', 'origin' => 'United Kingdom',
                'variants' => [312 => 'Standard', 313 => 'Black Badge'],
            ],
            119 => [
                'name' => 'Spectre',
                'body_type' => 'Coupe', 'fuel_type' => 'Electric', 'seating_capacity' => 4,
                'launch_date' => '2024-01-01', 'origin' => 'United Kingdom',
                'variants' => [314 => 'Standard'],
            ],
        ]],
        35 => ['name' => 'McLaren', 'models' => [
            120 => [
                'name' => 'Artura',
                'body_type' => 'Coupe', 'fuel_type' => 'Hybrid', 'seating_capacity' => 2,
                'launch_date' => '2023-01-01', 'origin' => 'United Kingdom',
                'variants' => [315 => 'Standard'],
            ],
            121 => [
                'name' => '750S',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2024-01-01', 'origin' => 'United Kingdom',
                'variants' => [316 => 'Coupe', 317 => 'Spider'],
            ],
            122 => [
                'name' => 'GTS',
                'body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2025-01-01', 'origin' => 'United Kingdom',
                'variants' => [318 => 'Standard'],
            ],
        ]],
        36 => ['name' => 'Pravaig', 'models' => [
            123 => [
                'name' => 'Defy',
                'body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2023-11-25', 'origin' => 'India',
                'variants' => [319 => 'Standard'],
            ],
            124 => [
                'name' => 'Extinction',
                'body_type' => 'Sedan', 'fuel_type' => 'Electric', 'seating_capacity' => 4,
                'launch_date' => '2019-01-01', 'origin' => 'India',
                'variants' => [320 => 'Standard'],
            ],
        ]],
        37 => ['name' => 'Strom Motors', 'models' => [
            125 => [
                'name' => 'R3',
                'body_type' => 'Microcar', 'fuel_type' => 'Electric', 'seating_capacity' => 2,
                'launch_date' => '2023-01-01', 'origin' => 'India',
                'variants' => [321 => 'Standard'],
            ],
        ]],
        38 => ['name' => 'VinFast', 'models' => [
            126 => [
                'name' => 'VF 6',
                'body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2025-09-01', 'origin' => 'India',
                'variants' => [322 => 'Eco', 323 => 'Plus'],
            ],
            127 => [
                'name' => 'VF 7',
                'body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5,
                'launch_date' => '2025-09-01', 'origin' => 'India',
                'variants' => [324 => 'Eco', 325 => 'Plus'],
            ],
        ]],
        39 => ['name' => 'Hero MotoCorp', 'models' => [
            128 => [
                'name' => 'Splendor Plus',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-01-01', 'origin' => 'India',
                'variants' => [326 => 'Standard', 327 => 'Black and Accent', 328 => 'i3S', 329 => 'Million Edition'],
            ],
            129 => [
                'name' => 'HF Deluxe',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-06-01', 'origin' => 'India',
                'variants' => [330 => 'Standard', 331 => 'i3S'],
            ],
            130 => [
                'name' => 'Passion Pro',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2022-01-01', 'origin' => 'India',
                'variants' => [332 => 'Standard', 333 => 'i3S'],
            ],
            131 => [
                'name' => 'Glamour',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2021-01-01', 'origin' => 'India',
                'variants' => [334 => 'Drum', 335 => 'Disc'],
            ],
            132 => [
                'name' => 'Xtreme 160R',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2020-02-01', 'origin' => 'India',
                'variants' => [336 => 'Single Channel ABS', 337 => 'Dual Channel ABS'],
            ],
            133 => [
                'name' => 'Xpulse 200',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2019-04-01', 'origin' => 'India',
                'variants' => [338 => 'Standard', 339 => '4V'],
            ],
        ]],
        40 => ['name' => 'TVS Motor', 'models' => [
            134 => [
                'name' => 'Apache RTR 160',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2018-01-01', 'origin' => 'India',
                'variants' => [340 => 'Single Disc', 341 => 'Double Disc'],
            ],
            135 => [
                'name' => 'Apache RTR 310',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-11-01', 'origin' => 'India',
                'variants' => [342 => 'Standard', 343 => 'RTX'],
            ],
            136 => [
                'name' => 'Jupiter 125',
                'body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2021-11-01', 'origin' => 'India',
                'variants' => [344 => 'Standard', 345 => 'ZX', 346 => 'ZX Disc'],
            ],
            137 => [
                'name' => 'Ntorq 125',
                'body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2018-04-01', 'origin' => 'India',
                'variants' => [347 => 'Race Edition', 348 => 'Super Squad Edition'],
            ],
            138 => [
                'name' => 'Raider 125',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2021-08-01', 'origin' => 'India',
                'variants' => [349 => 'Single Disc', 350 => 'Dual Disc'],
            ],
        ]],
        41 => ['name' => 'Royal Enfield', 'models' => [
            139 => [
                'name' => 'Classic 350',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2021-09-01', 'origin' => 'India',
                'variants' => [351 => 'Standard', 352 => 'Signals', 353 => 'Chrome', 354 => 'Redditch'],
            ],
            140 => [
                'name' => 'Hunter 350',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2022-08-01', 'origin' => 'India',
                'variants' => [355 => 'Metro', 356 => 'Rebel'],
            ],
            141 => [
                'name' => 'Bullet 350',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-04-01', 'origin' => 'India',
                'variants' => [357 => 'Standard', 358 => 'Military'],
            ],
            142 => [
                'name' => 'Himalayan 450',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-11-01', 'origin' => 'India',
                'variants' => [359 => 'Standard', 360 => 'Kaza Brown'],
            ],
            143 => [
                'name' => 'Meteor 350',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2020-11-01', 'origin' => 'India',
                'variants' => [361 => 'Fireball', 362 => 'Stellar', 363 => 'Supernova'],
            ],
            144 => [
                'name' => 'Continental GT 650',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2018-11-01', 'origin' => 'India',
                'variants' => [364 => 'Standard', 365 => 'Chrome'],
            ],
        ]],
        42 => ['name' => 'Yamaha', 'models' => [
            145 => [
                'name' => 'R15 V4',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2021-03-01', 'origin' => 'India',
                'variants' => [366 => 'Standard', 367 => 'S', 368 => 'M'],
            ],
            146 => [
                'name' => 'MT-15',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2019-09-01', 'origin' => 'India',
                'variants' => [369 => 'Version 2.0', 370 => 'Darknight'],
            ],
            147 => [
                'name' => 'FZ-S FI',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2019-01-01', 'origin' => 'India',
                'variants' => [371 => 'Version 3.0', 372 => 'Version 4.0'],
            ],
        ]],
        43 => ['name' => 'Suzuki', 'models' => [
            148 => [
                'name' => 'Access 125',
                'body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2016-08-01', 'origin' => 'India',
                'variants' => [373 => 'Standard', 374 => 'SE', 375 => 'Special Edition'],
            ],
            149 => [
                'name' => 'Gixxer',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2014-11-01', 'origin' => 'India',
                'variants' => [376 => 'Standard', 377 => 'SF'],
            ],
            150 => [
                'name' => 'Burgman Street 125',
                'body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2019-01-01', 'origin' => 'India',
                'variants' => [378 => 'Standard', 379 => 'EX'],
            ],
            151 => [
                'name' => 'V-Strom SX',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-01-01', 'origin' => 'India',
                'variants' => [380 => 'Standard', 381 => 'ABS'],
            ],
        ]],
        44 => ['name' => 'KTM', 'models' => [
            152 => [
                'name' => '200 Duke',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2020-01-01', 'origin' => 'India',
                'variants' => [382 => 'Standard'],
            ],
            153 => [
                'name' => '250 Duke',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2017-07-01', 'origin' => 'India',
                'variants' => [383 => 'Standard'],
            ],
            154 => [
                'name' => '390 Duke',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2013-01-01', 'origin' => 'India',
                'variants' => [384 => 'Standard'],
            ],
            155 => [
                'name' => 'RC 390',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2014-11-01', 'origin' => 'India',
                'variants' => [385 => 'Standard'],
            ],
            156 => [
                'name' => '390 Adventure',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2020-03-01', 'origin' => 'India',
                'variants' => [386 => 'Standard', 387 => 'X'],
            ],
        ]],
        45 => ['name' => 'Kawasaki', 'models' => [
            157 => [
                'name' => 'Ninja 300',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2013-01-01', 'origin' => 'Thailand',
                'variants' => [388 => 'Standard'],
            ],
            158 => [
                'name' => 'Z900',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2020-01-01', 'origin' => 'Thailand',
                'variants' => [389 => 'Standard'],
            ],
            159 => [
                'name' => 'Ninja 650',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2017-01-01', 'origin' => 'Thailand',
                'variants' => [390 => 'Standard'],
            ],
            160 => [
                'name' => 'Versys 650',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2015-01-01', 'origin' => 'Thailand',
                'variants' => [391 => 'Standard'],
            ],
        ]],
        46 => ['name' => 'Triumph', 'models' => [
            161 => [
                'name' => 'Speed 400',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-07-05', 'origin' => 'India',
                'variants' => [392 => 'Standard'],
            ],
            162 => [
                'name' => 'Scrambler 400 X',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2024-02-08', 'origin' => 'India',
                'variants' => [393 => 'Standard'],
            ],
            163 => [
                'name' => 'Scrambler 400 XC',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2025-01-01', 'origin' => 'India',
                'variants' => [394 => 'Standard'],
            ],
        ]],
        47 => ['name' => 'Ducati', 'models' => [
            164 => [
                'name' => 'Panigale V2',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2020-01-01', 'origin' => 'Italy',
                'variants' => [395 => 'Standard'],
            ],
            165 => [
                'name' => 'Monster',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2021-11-01', 'origin' => 'Italy',
                'variants' => [396 => 'Standard', 397 => 'Plus'],
            ],
            166 => [
                'name' => 'Multistrada V4',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2021-03-01', 'origin' => 'Italy',
                'variants' => [398 => 'Standard', 399 => 'S'],
            ],
        ]],
        48 => ['name' => 'Harley-Davidson', 'models' => [
            167 => [
                'name' => 'X440',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-07-03', 'origin' => 'India',
                'variants' => [400 => 'Vivid', 401 => 'S'],
            ],
        ]],
        49 => ['name' => 'Vespa', 'models' => [
            168 => [
                'name' => 'VXL 125',
                'body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2019-01-01', 'origin' => 'India',
                'variants' => [402 => 'Standard'],
            ],
            169 => [
                'name' => 'SXL 150',
                'body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2020-01-01', 'origin' => 'India',
                'variants' => [403 => 'Standard'],
            ],
            170 => [
                'name' => 'ZX 125',
                'body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-01-01', 'origin' => 'India',
                'variants' => [404 => 'Standard'],
            ],
        ]],
        50 => ['name' => 'Aprilia', 'models' => [
            171 => [
                'name' => 'RS 457',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2024-01-08', 'origin' => 'India',
                'variants' => [405 => 'Standard'],
            ],
            172 => [
                'name' => 'Tuono 457',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2024-11-01', 'origin' => 'India',
                'variants' => [406 => 'Standard', 407 => 'Special Edition'],
            ],
        ]],
        51 => ['name' => 'BMW Motorrad', 'models' => [
            173 => [
                'name' => 'G 310 RR',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2023-01-01', 'origin' => 'India',
                'variants' => [408 => 'Standard'],
            ],
            174 => [
                'name' => 'F 450 GS',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2025-01-01', 'origin' => 'Germany',
                'variants' => [409 => 'Standard'],
            ],
            175 => [
                'name' => 'S 1000 RR',
                'body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2,
                'launch_date' => '2019-01-01', 'origin' => 'Germany',
                'variants' => [410 => 'Standard'],
            ],
        ]],
    ];

    /**
     * Spare parts, keyed by fixed primary-key id. Same rule: append with the next id.
     *
     * @var array<int, array{name: string, category: string, brand: string}>
     */
    private array $parts = [
        1 => ['name' => 'Air Filter', 'category' => 'Engine', 'brand' => 'Bosch'],
        2 => ['name' => 'Oil Filter', 'category' => 'Engine', 'brand' => 'Mahle'],
        3 => ['name' => 'Fuel Filter', 'category' => 'Engine', 'brand' => 'Mahle'],
        4 => ['name' => 'Spark Plug', 'category' => 'Engine', 'brand' => 'NGK'],
        5 => ['name' => 'Timing Belt', 'category' => 'Engine', 'brand' => 'Gates'],
        6 => ['name' => 'Timing Chain', 'category' => 'Engine', 'brand' => 'Rane'],
        7 => ['name' => 'Piston Ring Set', 'category' => 'Engine', 'brand' => 'Federal-Mogul'],
        8 => ['name' => 'Cylinder Head Gasket', 'category' => 'Engine', 'brand' => 'Elring'],
        9 => ['name' => 'Engine Oil Pump', 'category' => 'Engine', 'brand' => 'Rane'],
        10 => ['name' => 'Radiator', 'category' => 'Cooling', 'brand' => 'Denso'],
        11 => ['name' => 'Water Pump', 'category' => 'Cooling', 'brand' => 'GMB'],
        12 => ['name' => 'Thermostat', 'category' => 'Cooling', 'brand' => 'Mahle'],
        13 => ['name' => 'Cabin Air Filter', 'category' => 'HVAC', 'brand' => 'Bosch'],
        14 => ['name' => 'AC Compressor', 'category' => 'HVAC', 'brand' => 'Denso'],
        15 => ['name' => 'AC Condenser', 'category' => 'HVAC', 'brand' => 'Valeo'],
        16 => ['name' => 'Brake Pad Front', 'category' => 'Brakes', 'brand' => 'Bosch'],
        17 => ['name' => 'Brake Pad Rear', 'category' => 'Brakes', 'brand' => 'Bosch'],
        18 => ['name' => 'Brake Disc Rotor', 'category' => 'Brakes', 'brand' => 'TRW'],
        19 => ['name' => 'Brake Caliper', 'category' => 'Brakes', 'brand' => 'Brembo'],
        20 => ['name' => 'Clutch Plate', 'category' => 'Transmission', 'brand' => 'Luk'],
        21 => ['name' => 'Clutch Disc', 'category' => 'Transmission', 'brand' => 'Valeo'],
        22 => ['name' => 'Gearbox Mount', 'category' => 'Transmission', 'brand' => 'Rane'],
        23 => ['name' => 'Shock Absorber Front', 'category' => 'Suspension', 'brand' => 'Gabriel'],
        24 => ['name' => 'Shock Absorber Rear', 'category' => 'Suspension', 'brand' => 'Gabriel'],
        25 => ['name' => 'Wheel Bearing', 'category' => 'Suspension', 'brand' => 'SKF'],
        26 => ['name' => 'Ball Joint', 'category' => 'Suspension', 'brand' => 'Delphi'],
        27 => ['name' => 'Tie Rod End', 'category' => 'Steering', 'brand' => 'Delphi'],
        28 => ['name' => 'Power Steering Pump', 'category' => 'Steering', 'brand' => 'ZF'],
        29 => ['name' => 'Alternator', 'category' => 'Electrical', 'brand' => 'Bosch'],
        30 => ['name' => 'Starter Motor', 'category' => 'Electrical', 'brand' => 'Bosch'],
        31 => ['name' => 'Battery', 'category' => 'Electrical', 'brand' => 'Exide'],
        32 => ['name' => 'Ignition Coil', 'category' => 'Electrical', 'brand' => 'Denso'],
        33 => ['name' => 'Headlight Assembly', 'category' => 'Body', 'brand' => 'Lumax'],
        34 => ['name' => 'Tail Light Assembly', 'category' => 'Body', 'brand' => 'Lumax'],
        35 => ['name' => 'Side Mirror', 'category' => 'Body', 'brand' => 'Minda'],
        36 => ['name' => 'Wiper Blade', 'category' => 'Body', 'brand' => 'Bosch'],
        37 => ['name' => 'Door Handle', 'category' => 'Body', 'brand' => 'Minda'],
        38 => ['name' => 'Bumper Front', 'category' => 'Body', 'brand' => 'Minda'],
        39 => ['name' => 'Bumper Rear', 'category' => 'Body', 'brand' => 'Minda'],
        40 => ['name' => 'Exhaust Muffler', 'category' => 'Exhaust', 'brand' => 'Bosal'],
        41 => ['name' => 'Catalytic Converter', 'category' => 'Exhaust', 'brand' => 'Faurecia'],
        42 => ['name' => 'CV Joint', 'category' => 'Drivetrain', 'brand' => 'GKN'],
        43 => ['name' => 'Fuel Pump', 'category' => 'Fuel System', 'brand' => 'Bosch'],
        44 => ['name' => 'Fuel Injector', 'category' => 'Fuel System', 'brand' => 'Bosch'],
    ];

    /**
     * Seed the automobile database from the fixed-id catalog above.
     *
     * Every row keeps the id it has in $catalog / $parts, so a flush + re-seed is
     * byte-for-byte reproducible - safe to point external data at these ids.
     */
    public function run(): void
    {
        // Truncate first (outside the transaction: TRUNCATE auto-commits on MySQL)
        // so a re-seed starts from empty tables with reset auto-increment counters.
        $this->flush();

        DB::transaction(function () {
            $this->seedParts();
            $this->seedVehicleHierarchy();
        });
    }

    /**
     * Empty every table this seeder owns so it can be re-run with the same ids.
     *
     * MySQL refuses to TRUNCATE a table that any foreign key points at - even when
     * the referencing table is already empty - so child-first ordering is not
     * enough on its own; foreign key checks have to be off for the duration.
     */
    private function flush(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            DB::table('part_vehicle')->truncate();
            Vehicle::truncate();
            Variant::truncate();
            VehicleModel::truncate();
            Manufacturer::truncate();
            Part::truncate();
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }

    private function seedParts(): void
    {
        foreach ($this->parts as $id => $part) {
            $row = new Part([
                'name' => $part['name'],
                'part_number' => sprintf('%s-%04d', strtoupper(substr($part['category'], 0, 3)), $id),
                'category' => $part['category'],
                'details' => [
                    'manufacturer' => $part['brand'],
                    'compatibility' => 'Petrol & Diesel engines',
                ],
            ]);
            $row->id = $id;
            $row->save();
        }
    }

    private function seedVehicleHierarchy(): void
    {
        $partIds = array_keys($this->parts);

        foreach ($this->catalog as $manufacturerId => $manufacturer) {
            $m = new Manufacturer(['name' => $manufacturer['name']]);
            $m->id = $manufacturerId;
            $m->save();

            foreach ($manufacturer['models'] as $modelId => $model) {
                $vm = new VehicleModel(['manufacturer_id' => $manufacturerId, 'name' => $model['name']]);
                $vm->id = $modelId;
                $vm->save();

                foreach ($model['variants'] as $variantId => $variantName) {
                    $variant = new Variant(['model_id' => $modelId, 'name' => $variantName]);
                    $variant->id = $variantId;
                    $variant->save();

                    // One vehicle per variant; it takes the variant's id.
                    $vehicle = new Vehicle([
                        'variant_id' => $variantId,
                        'fuel_type' => $model['fuel_type'],
                        'body_type' => $model['body_type'],
                        'seating_capacity' => $model['seating_capacity'],
                        'launch_date' => $model['launch_date'],
                        'discontinue_date' => null,
                        'details' => [
                            'manufacturing_origin' => $model['origin'],
                        ],
                    ]);
                    $vehicle->id = $variantId;
                    $vehicle->save();

                    $vehicle->parts()->sync($this->partsForVehicle($variantId, $partIds));
                }
            }
        }
    }

    /**
     * Deterministically pick a handful of parts for a vehicle - a rotating window
     * over the part list keyed by the vehicle id, so the pivot rows are stable too.
     *
     * @param  int[]  $partIds
     * @return int[]
     */
    private function partsForVehicle(int $vehicleId, array $partIds): array
    {
        $total = count($partIds);
        $take = min($total, 5);
        $start = ($vehicleId - 1) * $take;

        $picked = [];
        for ($i = 0; $i < $take; $i++) {
            $picked[] = $partIds[($start + $i) % $total];
        }

        return array_values(array_unique($picked));
    }
}
