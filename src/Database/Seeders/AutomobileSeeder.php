<?php

namespace Automobile\Database\Seeders;

use Automobile\Models\Manufacturer;
use Automobile\Models\Part;
use Automobile\Models\Variant;
use Automobile\Models\Vehicle;
use Automobile\Models\VehicleModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AutomobileSeeder extends Seeder
{
    /**
     * Real manufacturer -> model -> variant catalog for vehicles sold in India (as of 2026).
     *
     * @var array<string, array<string, string[]>>
     */
    private array $catalog = [
        'Maruti Suzuki' => [
            'Swift' => ['LXi', 'VXi', 'ZXi', 'ZXi+'],
            'Baleno' => ['Sigma', 'Delta', 'Zeta', 'Alpha'],
            'Brezza' => ['LXi', 'VXi', 'ZXi', 'ZXi+'],
            'Dzire' => ['LXi', 'VXi', 'ZXi', 'ZXi+'],
            'Ertiga' => ['LXi', 'VXi', 'ZXi', 'ZXi+'],
        ],
        'Tata Motors' => [
            'Nexon' => ['Smart', 'Pure', 'Creative', 'Fearless'],
            'Punch' => ['Smart', 'Pure', 'Adventure', 'Accomplished'],
            'Altroz' => ['XE', 'XM', 'XT', 'XZ'],
            'Harrier' => ['Smart', 'Pure X', 'Adventure X', 'Fearless X'],
        ],
        'Hyundai' => [
            'Creta' => ['E', 'EX', 'S', 'SX', 'SX(O)'],
            'Venue' => ['E', 'S', 'SX', 'SX(O)'],
            'i20' => ['Magna', 'Sportz', 'Asta', 'Asta(O)'],
        ],
        'Mahindra' => [
            'XUV700' => ['MX', 'AX3', 'AX5', 'AX7'],
            'Thar' => ['AX(O)', 'LX'],
            'Scorpio-N' => ['Z2', 'Z4', 'Z6', 'Z8'],
        ],
        'Kia' => [
            'Seltos' => ['HTE', 'HTK', 'HTX', 'GTX'],
            'Sonet' => ['HTE', 'HTK', 'HTX', 'GTX'],
        ],
        'Toyota' => [
            'Innova Crysta' => ['GX', 'VX', 'ZX'],
            'Fortuner' => ['4x2', '4x4', 'Legender'],
        ],
        'Honda' => [
            'City' => ['SV', 'V', 'ZX', 'ZX+'],
            'Amaze' => ['V', 'VX', 'ZX'],
            'Activa 125' => ['Standard', 'DLX', 'Smart Key'],
            'Shine 125' => ['Standard', 'DLX'],
            'Unicorn' => ['Standard'],
            'SP 125' => ['Standard', 'Disc'],
            'Dio 125' => ['Standard', 'DLX'],
        ],
        'MG Motor' => [
            'Hector' => ['Style', 'Super', 'Smart', 'Sharp'],
            'Astor' => ['Style', 'Super', 'Sharp', 'Sharp Pro'],
            'Gloster' => ['Super', 'Smart', 'Sharp', 'Savvy'],
            'Comet EV' => ['Pace', 'Play'],
            'Windsor EV' => ['Excite', 'Exclusive', 'Essence'],
        ],
        'Skoda' => [
            'Kylaq' => ['Classic', 'Signature', 'Signature+', 'Sportline'],
            'Slavia' => ['Active', 'Ambition', 'Style'],
            'Kushaq' => ['Active', 'Ambition', 'Style'],
        ],
        'Volkswagen' => [
            'Virtus' => ['Comfortline', 'Highline', 'Topline'],
            'Taigun' => ['Comfortline', 'Highline', 'Topline'],
            'Tiguan' => ['Elegance', 'R-Line'],
        ],
        'Renault' => [
            'Kwid' => ['RXE', 'RXL', 'RXT', 'Climber'],
            'Triber' => ['RXE', 'RXL', 'RXT', 'Emotion'],
            'Kiger' => ['RXE', 'RXL', 'RXT', 'RXZ'],
        ],
        'Nissan' => [
            'Magnite' => ['Visia', 'Acenta', 'N-Connecta', 'Tekna'],
            'X-Trail' => ['Acenta', 'N-Connecta', 'Tekna'],
        ],
        'Citroen' => [
            'C3' => ['Live', 'You', 'Feel', 'Shine'],
            'Basalt' => ['You', 'Plus', 'Max'],
            'C5 Aircross' => ['Feel', 'Shine'],
        ],
        'Audi' => [
            'A4' => ['Premium', 'Premium Plus', 'Technology'],
            'Q3' => ['Premium', 'Premium Plus', 'Technology'],
            'Q5' => ['Premium Plus', 'Technology'],
            'Q7' => ['Premium Plus', 'Technology'],
        ],
        'BMW' => [
            '3 Series' => ['Sport', 'Luxury Line', 'M Sport'],
            '5 Series' => ['Sport', 'Luxury Line', 'M Sport'],
            'X1' => ['sDrive20i', 'xDrive20d'],
            'X3' => ['xDrive20', 'xDrive20d', 'M40i'],
            'X5' => ['xDrive40i', 'M Competition'],
        ],
        'Mercedes-Benz' => [
            'C-Class' => ['Progressive', 'Avantgarde'],
            'E-Class' => ['Avantgarde', 'AMG Line'],
            'GLA' => ['Progressive', 'Avantgarde'],
            'GLC' => ['Progressive', 'Avantgarde'],
            'GLE' => ['Avantgarde', 'AMG Line'],
        ],
        'Mini' => [
            'Cooper' => ['Cooper', 'Cooper S'],
            'Countryman' => ['Classic', 'Favoured Pack', 'JCW'],
        ],
        'Volvo' => [
            'XC40' => ['Momentum', 'Inscription', 'Ultimate'],
            'XC60' => ['Inscription', 'Ultimate'],
            'XC90' => ['Inscription', 'Ultimate'],
        ],
        'Porsche' => [
            'Macan' => ['Macan', 'Macan S', 'Macan GTS'],
            'Cayenne' => ['Cayenne', 'Cayenne S', 'Cayenne Turbo'],
            'Panamera' => ['Panamera', 'Panamera 4', 'Panamera Turbo'],
            '911' => ['Carrera', 'Carrera S', 'Turbo'],
        ],
        'BYD' => [
            'Atto 3' => ['Dynamic', 'Premium'],
            'Seal' => ['Premium', 'Performance'],
            'Sealion 7' => ['Premium', 'Performance'],
            'eMax 7' => ['Premium', 'Superior'],
        ],
        'Land Rover' => [
            'Defender' => ['90', '110', '130'],
            'Discovery Sport' => ['S', 'SE', 'HSE'],
            'Range Rover Evoque' => ['S', 'SE', 'HSE'],
            'Range Rover Sport' => ['SE', 'HSE', 'Autobiography'],
        ],
        'Jaguar' => [
            'F-Pace' => ['R-Dynamic S'],
        ],
        'Lexus' => [
            'ES' => ['350h', '500e'],
            'RX' => ['350h', '500h'],
            'NX' => ['350h'],
        ],
        'Bajaj' => [
            'Qute' => ['Standard', 'CNG'],
            'Pulsar NS200' => ['Standard', 'ABS'],
            'Pulsar N250' => ['Standard'],
            'Platina 100' => ['Standard', 'ES'],
            'Dominar 400' => ['Standard'],
            'Chetak' => ['Standard', 'Premium'],
        ],
        'Force Motors' => [
            'Gurkha' => ['3-Door', '5-Door'],
            'Trax Cruiser' => ['Standard', 'Deluxe'],
            'Urbania' => ['Standard', 'Premium'],
        ],
        'Isuzu' => [
            'D-Max' => ['Regular Cab', 'V-Cross', 'Hi-Lander'],
            'MU-X' => ['Standard', '4x4'],
        ],
        'Jeep' => [
            'Compass' => ['Longitude', 'Limited', 'Trailhawk'],
            'Meridian' => ['Longitude', 'Limited'],
            'Wrangler' => ['Sahara', 'Rubicon'],
            'Grand Cherokee' => ['Limited', 'Overland'],
        ],
        'Aston Martin' => [
            'Vantage' => ['Standard'],
            'DB12' => ['Standard'],
            'Vanquish' => ['Standard'],
            'DBX' => ['DBX707'],
        ],
        'Bentley' => [
            'Continental GT' => ['Standard', 'Azure', 'Speed'],
            'Bentayga' => ['Standard', 'Azure', 'Speed'],
            'Flying Spur' => ['Standard', 'Azure', 'Speed'],
        ],
        'Ferrari' => [
            'Roma' => ['Coupe', 'Spider'],
            'Purosangue' => ['Standard'],
            '296' => ['GTB', 'GTS'],
        ],
        'Lamborghini' => [
            'Urus' => ['S', 'Performante'],
            'Huracan' => ['EVO', 'Sterrato'],
            'Temerario' => ['Standard'],
            'Revuelto' => ['Standard'],
        ],
        'Lotus' => [
            'Emira' => ['V6 First Edition', 'V6 SE'],
            'Eletre' => ['Standard', 'S', 'R'],
            'Emeya' => ['Standard', 'R'],
        ],
        'Maserati' => [
            'Ghibli' => ['Standard', 'Modena', 'Trofeo'],
            'Levante' => ['Standard', 'Modena', 'Trofeo'],
            'Grecale' => ['GT', 'Modena', 'Trofeo'],
        ],
        'Rolls-Royce' => [
            'Ghost' => ['Standard', 'Extended', 'Black Badge'],
            'Phantom' => ['Standard', 'Extended'],
            'Cullinan' => ['Standard', 'Black Badge'],
            'Spectre' => ['Standard'],
        ],
        'McLaren' => [
            'Artura' => ['Standard'],
            '750S' => ['Coupe', 'Spider'],
            'GTS' => ['Standard'],
        ],
        'Pravaig' => [
            'Defy' => ['Standard'],
            'Extinction' => ['Standard'],
        ],
        'Strom Motors' => [
            'R3' => ['Standard'],
        ],
        'VinFast' => [
            'VF 6' => ['Eco', 'Plus'],
            'VF 7' => ['Eco', 'Plus'],
        ],

        'Hero MotoCorp' => [
            'Splendor Plus' => ['Standard', 'Black and Accent', 'i3S', 'Million Edition'],
            'HF Deluxe' => ['Standard', 'i3S'],
            'Passion Pro' => ['Standard', 'i3S'],
            'Glamour' => ['Drum', 'Disc'],
            'Xtreme 160R' => ['Single Channel ABS', 'Dual Channel ABS'],
            'Xpulse 200' => ['Standard', '4V'],
        ],
        'TVS Motor' => [
            'Apache RTR 160' => ['Single Disc', 'Double Disc'],
            'Apache RTR 310' => ['Standard', 'RTX'],
            'Jupiter 125' => ['Standard', 'ZX', 'ZX Disc'],
            'Ntorq 125' => ['Race Edition', 'Super Squad Edition'],
            'Raider 125' => ['Single Disc', 'Dual Disc'],
        ],
        'Royal Enfield' => [
            'Classic 350' => ['Standard', 'Signals', 'Chrome', 'Redditch'],
            'Hunter 350' => ['Metro', 'Rebel'],
            'Bullet 350' => ['Standard', 'Military'],
            'Himalayan 450' => ['Standard', 'Kaza Brown'],
            'Meteor 350' => ['Fireball', 'Stellar', 'Supernova'],
            'Continental GT 650' => ['Standard', 'Chrome'],
        ],
        'Yamaha' => [
            'R15 V4' => ['Standard', 'S', 'M'],
            'MT-15' => ['Version 2.0', 'Darknight'],
            'FZ-S FI' => ['Version 3.0', 'Version 4.0'],
        ],
        'Suzuki' => [
            'Access 125' => ['Standard', 'SE', 'Special Edition'],
            'Gixxer' => ['Standard', 'SF'],
            'Burgman Street 125' => ['Standard', 'EX'],
            'V-Strom SX' => ['Standard', 'ABS'],
        ],
        'KTM' => [
            '200 Duke' => ['Standard'],
            '250 Duke' => ['Standard'],
            '390 Duke' => ['Standard'],
            'RC 390' => ['Standard'],
            '390 Adventure' => ['Standard', 'X'],
        ],
        'Kawasaki' => [
            'Ninja 300' => ['Standard'],
            'Z900' => ['Standard'],
            'Ninja 650' => ['Standard'],
            'Versys 650' => ['Standard'],
        ],
        'Triumph' => [
            'Speed 400' => ['Standard'],
            'Scrambler 400 X' => ['Standard'],
            'Scrambler 400 XC' => ['Standard'],
        ],
        'Ducati' => [
            'Panigale V2' => ['Standard'],
            'Monster' => ['Standard', 'Plus'],
            'Multistrada V4' => ['Standard', 'S'],
        ],
        'Harley-Davidson' => [
            'X440' => ['Vivid', 'S'],
        ],
        'Vespa' => [
            'VXL 125' => ['Standard'],
            'SXL 150' => ['Standard'],
            'ZX 125' => ['Standard'],
        ],
        'Aprilia' => [
            'RS 457' => ['Standard'],
            'Tuono 457' => ['Standard', 'Special Edition'],
        ],
        'BMW Motorrad' => [
            'G 310 RR' => ['Standard'],
            'F 450 GS' => ['Standard'],
            'S 1000 RR' => ['Standard'],
        ],
    ];

    /**
     * Real body type / fuel type / seating capacity / launch date / manufacturing origin per model.
     *
     * @var array<string, array{body_type: string, fuel_type: string, seating_capacity: int, launch_date: string, origin: string}>
     */
    private array $modelDetails = [
        'Swift' => ['body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2018-02-09', 'origin' => 'India'],
        'Baleno' => ['body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2022-01-18', 'origin' => 'India'],
        'Brezza' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2022-06-30', 'origin' => 'India'],
        'Dzire' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2020-05-24', 'origin' => 'India'],
        'Ertiga' => ['body_type' => 'MPV', 'fuel_type' => 'Petrol', 'seating_capacity' => 7, 'launch_date' => '2018-11-21', 'origin' => 'India'],
        'Nexon' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2023-09-14', 'origin' => 'India'],
        'Punch' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-10-19', 'origin' => 'India'],
        'Altroz' => ['body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2020-01-22', 'origin' => 'India'],
        'Harrier' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5, 'launch_date' => '2023-10-19', 'origin' => 'India'],
        'Creta' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2024-01-16', 'origin' => 'India'],
        'Venue' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2019-05-21', 'origin' => 'India'],
        'i20' => ['body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2020-11-04', 'origin' => 'India'],
        'XUV700' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2021-08-14', 'origin' => 'India'],
        'Thar' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 4, 'launch_date' => '2020-10-02', 'origin' => 'India'],
        'Scorpio-N' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2022-06-27', 'origin' => 'India'],
        'Seltos' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2019-08-22', 'origin' => 'India'],
        'Sonet' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2020-09-18', 'origin' => 'India'],
        'Innova Crysta' => ['body_type' => 'MPV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2016-05-03', 'origin' => 'India'],
        'Fortuner' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2021-01-06', 'origin' => 'India'],
        'City' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2020-07-15', 'origin' => 'India'],
        'Amaze' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-08-16', 'origin' => 'India'],

        'Hector' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2019-06-27', 'origin' => 'India'],
        'Astor' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-10-15', 'origin' => 'India'],
        'Gloster' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2020-11-04', 'origin' => 'India'],
        'Comet EV' => ['body_type' => 'Hatchback', 'fuel_type' => 'Electric', 'seating_capacity' => 4, 'launch_date' => '2023-05-24', 'origin' => 'India'],
        'Windsor EV' => ['body_type' => 'MPV', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2024-09-11', 'origin' => 'India'],

        'Kylaq' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2024-11-15', 'origin' => 'India'],
        'Slavia' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2022-02-24', 'origin' => 'India'],
        'Kushaq' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-06-07', 'origin' => 'India'],

        'Virtus' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2022-06-09', 'origin' => 'India'],
        'Taigun' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-09-23', 'origin' => 'India'],
        'Tiguan' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2024-11-06', 'origin' => 'Germany'],

        'Kwid' => ['body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2015-09-01', 'origin' => 'India'],
        'Triber' => ['body_type' => 'MPV', 'fuel_type' => 'Petrol', 'seating_capacity' => 7, 'launch_date' => '2019-08-28', 'origin' => 'India'],
        'Kiger' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-02-15', 'origin' => 'India'],

        'Magnite' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2020-12-02', 'origin' => 'India'],
        'X-Trail' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 7, 'launch_date' => '2023-11-01', 'origin' => 'Japan'],

        'C3' => ['body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2022-07-20', 'origin' => 'India'],
        'Basalt' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2024-08-05', 'origin' => 'India'],
        'C5 Aircross' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5, 'launch_date' => '2021-10-07', 'origin' => 'India'],

        'A4' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2016-06-01', 'origin' => 'India'],
        'Q3' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2019-09-19', 'origin' => 'India'],
        'Q5' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-01-14', 'origin' => 'Germany'],
        'Q7' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2022-06-15', 'origin' => 'India'],

        '3 Series' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2019-08-08', 'origin' => 'India'],
        '5 Series' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2024-03-01', 'origin' => 'India'],
        'X1' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5, 'launch_date' => '2023-01-24', 'origin' => 'India'],
        'X3' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5, 'launch_date' => '2021-11-18', 'origin' => 'India'],
        'X5' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2019-08-01', 'origin' => 'India'],

        'C-Class' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2022-08-10', 'origin' => 'India'],
        'E-Class' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2024-04-01', 'origin' => 'India'],
        'GLA' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2020-11-19', 'origin' => 'Germany'],
        'GLC' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2023-08-08', 'origin' => 'India'],
        'GLE' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5, 'launch_date' => '2019-11-01', 'origin' => 'India'],

        'Cooper' => ['body_type' => 'Hatchback', 'fuel_type' => 'Petrol', 'seating_capacity' => 4, 'launch_date' => '2021-08-01', 'origin' => 'United Kingdom'],
        'Countryman' => ['body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2024-10-01', 'origin' => 'Germany'],

        'XC40' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2018-08-08', 'origin' => 'Sweden'],
        'XC60' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-04-07', 'origin' => 'Sweden'],
        'XC90' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2015-11-01', 'origin' => 'Sweden'],

        'Macan' => ['body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2024-02-01', 'origin' => 'Germany'],
        'Cayenne' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2023-05-01', 'origin' => 'Germany'],
        'Panamera' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2024-05-01', 'origin' => 'Germany'],
        '911' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 4, 'launch_date' => '2019-11-01', 'origin' => 'Germany'],

        'Atto 3' => ['body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2022-10-11', 'origin' => 'China'],
        'Seal' => ['body_type' => 'Sedan', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2024-03-05', 'origin' => 'China'],
        'Sealion 7' => ['body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2025-04-01', 'origin' => 'China'],
        'eMax 7' => ['body_type' => 'MPV', 'fuel_type' => 'Electric', 'seating_capacity' => 7, 'launch_date' => '2024-11-06', 'origin' => 'China'],

        'Defender' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5, 'launch_date' => '2020-10-15', 'origin' => 'United Kingdom'],
        'Discovery Sport' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2020-02-01', 'origin' => 'India'],
        'Range Rover Evoque' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2019-11-01', 'origin' => 'India'],
        'Range Rover Sport' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5, 'launch_date' => '2023-02-01', 'origin' => 'United Kingdom'],

        'F-Pace' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-05-01', 'origin' => 'United Kingdom'],

        'ES' => ['body_type' => 'Sedan', 'fuel_type' => 'Hybrid', 'seating_capacity' => 5, 'launch_date' => '2019-01-24', 'origin' => 'Japan'],
        'RX' => ['body_type' => 'SUV', 'fuel_type' => 'Hybrid', 'seating_capacity' => 5, 'launch_date' => '2023-08-01', 'origin' => 'Japan'],
        'NX' => ['body_type' => 'SUV', 'fuel_type' => 'Hybrid', 'seating_capacity' => 5, 'launch_date' => '2021-12-01', 'origin' => 'Japan'],

        'Qute' => ['body_type' => 'Quadricycle', 'fuel_type' => 'CNG', 'seating_capacity' => 4, 'launch_date' => '2019-11-01', 'origin' => 'India'],

        'Gurkha' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 4, 'launch_date' => '2021-09-16', 'origin' => 'India'],
        'Trax Cruiser' => ['body_type' => 'MPV', 'fuel_type' => 'Diesel', 'seating_capacity' => 9, 'launch_date' => '2017-01-01', 'origin' => 'India'],
        'Urbania' => ['body_type' => 'Van', 'fuel_type' => 'Diesel', 'seating_capacity' => 13, 'launch_date' => '2021-08-19', 'origin' => 'India'],

        'D-Max' => ['body_type' => 'Pickup', 'fuel_type' => 'Diesel', 'seating_capacity' => 5, 'launch_date' => '2022-01-01', 'origin' => 'India'],
        'MU-X' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2022-06-01', 'origin' => 'India'],

        'Compass' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 5, 'launch_date' => '2017-07-01', 'origin' => 'India'],
        'Meridian' => ['body_type' => 'SUV', 'fuel_type' => 'Diesel', 'seating_capacity' => 7, 'launch_date' => '2022-06-07', 'origin' => 'India'],
        'Wrangler' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2023-01-01', 'origin' => 'United States'],
        'Grand Cherokee' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2022-08-01', 'origin' => 'United States'],

        'Vantage' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2024-05-01', 'origin' => 'United Kingdom'],
        'DB12' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 4, 'launch_date' => '2023-11-01', 'origin' => 'United Kingdom'],
        'Vanquish' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2025-01-01', 'origin' => 'United Kingdom'],
        'DBX' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-02-01', 'origin' => 'United Kingdom'],

        'Continental GT' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 4, 'launch_date' => '2021-03-01', 'origin' => 'United Kingdom'],
        'Bentayga' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-01-01', 'origin' => 'United Kingdom'],
        'Flying Spur' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2022-01-01', 'origin' => 'United Kingdom'],

        'Roma' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 4, 'launch_date' => '2021-02-01', 'origin' => 'Italy'],
        'Purosangue' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 4, 'launch_date' => '2024-01-01', 'origin' => 'Italy'],
        '296' => ['body_type' => 'Coupe', 'fuel_type' => 'Hybrid', 'seating_capacity' => 2, 'launch_date' => '2023-06-01', 'origin' => 'Italy'],

        'Urus' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2018-01-01', 'origin' => 'Italy'],
        'Huracan' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2015-01-01', 'origin' => 'Italy'],
        'Temerario' => ['body_type' => 'Coupe', 'fuel_type' => 'Hybrid', 'seating_capacity' => 2, 'launch_date' => '2025-01-01', 'origin' => 'Italy'],
        'Revuelto' => ['body_type' => 'Coupe', 'fuel_type' => 'Hybrid', 'seating_capacity' => 2, 'launch_date' => '2024-01-01', 'origin' => 'Italy'],

        'Emira' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2025-01-01', 'origin' => 'United Kingdom'],
        'Eletre' => ['body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2024-01-01', 'origin' => 'China'],
        'Emeya' => ['body_type' => 'Sedan', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2025-01-01', 'origin' => 'China'],

        'Ghibli' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2014-01-01', 'origin' => 'Italy'],
        'Levante' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2017-01-01', 'origin' => 'Italy'],
        'Grecale' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2023-01-01', 'origin' => 'Italy'],

        'Ghost' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2021-01-01', 'origin' => 'United Kingdom'],
        'Phantom' => ['body_type' => 'Sedan', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2018-01-01', 'origin' => 'United Kingdom'],
        'Cullinan' => ['body_type' => 'SUV', 'fuel_type' => 'Petrol', 'seating_capacity' => 5, 'launch_date' => '2019-01-01', 'origin' => 'United Kingdom'],
        'Spectre' => ['body_type' => 'Coupe', 'fuel_type' => 'Electric', 'seating_capacity' => 4, 'launch_date' => '2024-01-01', 'origin' => 'United Kingdom'],

        'Artura' => ['body_type' => 'Coupe', 'fuel_type' => 'Hybrid', 'seating_capacity' => 2, 'launch_date' => '2023-01-01', 'origin' => 'United Kingdom'],
        '750S' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2024-01-01', 'origin' => 'United Kingdom'],
        'GTS' => ['body_type' => 'Coupe', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2025-01-01', 'origin' => 'United Kingdom'],

        'Defy' => ['body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2023-11-25', 'origin' => 'India'],
        'Extinction' => ['body_type' => 'Sedan', 'fuel_type' => 'Electric', 'seating_capacity' => 4, 'launch_date' => '2019-01-01', 'origin' => 'India'],
        'R3' => ['body_type' => 'Microcar', 'fuel_type' => 'Electric', 'seating_capacity' => 2, 'launch_date' => '2023-01-01', 'origin' => 'India'],

        'VF 6' => ['body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2025-09-01', 'origin' => 'India'],
        'VF 7' => ['body_type' => 'SUV', 'fuel_type' => 'Electric', 'seating_capacity' => 5, 'launch_date' => '2025-09-01', 'origin' => 'India'],

        'Activa 125' => ['body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2019-02-01', 'origin' => 'India'],
        'Shine 125' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2016-01-01', 'origin' => 'India'],
        'Unicorn' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2004-01-01', 'origin' => 'India'],
        'SP 125' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2018-08-01', 'origin' => 'India'],
        'Dio 125' => ['body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2021-11-01', 'origin' => 'India'],

        'Pulsar NS200' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2012-03-01', 'origin' => 'India'],
        'Pulsar N250' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2022-07-01', 'origin' => 'India'],
        'Platina 100' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2006-01-01', 'origin' => 'India'],
        'Dominar 400' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2017-12-01', 'origin' => 'India'],
        'Chetak' => ['body_type' => 'Scooter', 'fuel_type' => 'Electric', 'seating_capacity' => 2, 'launch_date' => '2020-01-16', 'origin' => 'India'],

        'Splendor Plus' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-01-01', 'origin' => 'India'],
        'HF Deluxe' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-06-01', 'origin' => 'India'],
        'Passion Pro' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2022-01-01', 'origin' => 'India'],
        'Glamour' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2021-01-01', 'origin' => 'India'],
        'Xtreme 160R' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2020-02-01', 'origin' => 'India'],
        'Xpulse 200' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2019-04-01', 'origin' => 'India'],

        'Apache RTR 160' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2018-01-01', 'origin' => 'India'],
        'Apache RTR 310' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-11-01', 'origin' => 'India'],
        'Jupiter 125' => ['body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2021-11-01', 'origin' => 'India'],
        'Ntorq 125' => ['body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2018-04-01', 'origin' => 'India'],
        'Raider 125' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2021-08-01', 'origin' => 'India'],

        'Classic 350' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2021-09-01', 'origin' => 'India'],
        'Hunter 350' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2022-08-01', 'origin' => 'India'],
        'Bullet 350' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-04-01', 'origin' => 'India'],
        'Himalayan 450' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-11-01', 'origin' => 'India'],
        'Meteor 350' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2020-11-01', 'origin' => 'India'],
        'Continental GT 650' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2018-11-01', 'origin' => 'India'],

        'R15 V4' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2021-03-01', 'origin' => 'India'],
        'MT-15' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2019-09-01', 'origin' => 'India'],
        'FZ-S FI' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2019-01-01', 'origin' => 'India'],

        'Access 125' => ['body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2016-08-01', 'origin' => 'India'],
        'Gixxer' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2014-11-01', 'origin' => 'India'],
        'Burgman Street 125' => ['body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2019-01-01', 'origin' => 'India'],
        'V-Strom SX' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-01-01', 'origin' => 'India'],

        '200 Duke' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2020-01-01', 'origin' => 'India'],
        '250 Duke' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2017-07-01', 'origin' => 'India'],
        '390 Duke' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2013-01-01', 'origin' => 'India'],
        'RC 390' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2014-11-01', 'origin' => 'India'],
        '390 Adventure' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2020-03-01', 'origin' => 'India'],

        'Ninja 300' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2013-01-01', 'origin' => 'Thailand'],
        'Z900' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2020-01-01', 'origin' => 'Thailand'],
        'Ninja 650' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2017-01-01', 'origin' => 'Thailand'],
        'Versys 650' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2015-01-01', 'origin' => 'Thailand'],

        'Speed 400' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-07-05', 'origin' => 'India'],
        'Scrambler 400 X' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2024-02-08', 'origin' => 'India'],
        'Scrambler 400 XC' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2025-01-01', 'origin' => 'India'],

        'Panigale V2' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2020-01-01', 'origin' => 'Italy'],
        'Monster' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2021-11-01', 'origin' => 'Italy'],
        'Multistrada V4' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2021-03-01', 'origin' => 'Italy'],

        'X440' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-07-03', 'origin' => 'India'],

        'VXL 125' => ['body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2019-01-01', 'origin' => 'India'],
        'SXL 150' => ['body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2020-01-01', 'origin' => 'India'],
        'ZX 125' => ['body_type' => 'Scooter', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-01-01', 'origin' => 'India'],

        'RS 457' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2024-01-08', 'origin' => 'India'],
        'Tuono 457' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2024-11-01', 'origin' => 'India'],

        'G 310 RR' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2023-01-01', 'origin' => 'India'],
        'F 450 GS' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2025-01-01', 'origin' => 'Germany'],
        'S 1000 RR' => ['body_type' => 'Motorcycle', 'fuel_type' => 'Petrol', 'seating_capacity' => 2, 'launch_date' => '2019-01-01', 'origin' => 'Germany'],
    ];

    /**
     * Real automotive spare part names, grouped by category with a common OEM/aftermarket brand.
     *
     * @var array<string, array<string, string>>
     */
    private array $parts = [
        'Engine' => [
            'Air Filter' => 'Bosch',
            'Oil Filter' => 'Mahle',
            'Fuel Filter' => 'Mahle',
            'Spark Plug' => 'NGK',
            'Timing Belt' => 'Gates',
            'Timing Chain' => 'Rane',
            'Piston Ring Set' => 'Federal-Mogul',
            'Cylinder Head Gasket' => 'Elring',
            'Engine Oil Pump' => 'Rane',
        ],
        'Cooling' => [
            'Radiator' => 'Denso',
            'Water Pump' => 'GMB',
            'Thermostat' => 'Mahle',
        ],
        'HVAC' => [
            'Cabin Air Filter' => 'Bosch',
            'AC Compressor' => 'Denso',
            'AC Condenser' => 'Valeo',
        ],
        'Brakes' => [
            'Brake Pad Front' => 'Bosch',
            'Brake Pad Rear' => 'Bosch',
            'Brake Disc Rotor' => 'TRW',
            'Brake Caliper' => 'Brembo',
        ],
        'Transmission' => [
            'Clutch Plate' => 'Luk',
            'Clutch Disc' => 'Valeo',
            'Gearbox Mount' => 'Rane',
        ],
        'Suspension' => [
            'Shock Absorber Front' => 'Gabriel',
            'Shock Absorber Rear' => 'Gabriel',
            'Wheel Bearing' => 'SKF',
            'Ball Joint' => 'Delphi',
        ],
        'Steering' => [
            'Tie Rod End' => 'Delphi',
            'Power Steering Pump' => 'ZF',
        ],
        'Electrical' => [
            'Alternator' => 'Bosch',
            'Starter Motor' => 'Bosch',
            'Battery' => 'Exide',
            'Ignition Coil' => 'Denso',
        ],
        'Body' => [
            'Headlight Assembly' => 'Lumax',
            'Tail Light Assembly' => 'Lumax',
            'Side Mirror' => 'Minda',
            'Wiper Blade' => 'Bosch',
            'Door Handle' => 'Minda',
            'Bumper Front' => 'Minda',
            'Bumper Rear' => 'Minda',
        ],
        'Exhaust' => [
            'Exhaust Muffler' => 'Bosal',
            'Catalytic Converter' => 'Faurecia',
        ],
        'Drivetrain' => [
            'CV Joint' => 'GKN',
        ],
        'Fuel System' => [
            'Fuel Pump' => 'Bosch',
            'Fuel Injector' => 'Bosch',
        ],
    ];

    /**
     * Seed the automobile database tables with real manufacturer/model/variant/vehicle/part data.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $partIds = $this->seedParts();
            $this->seedVehicleHierarchy($partIds);
        });
    }

    /**
     * @return int[]
     */
    private function seedParts(): array
    {
        $ids = [];
        $counter = 1;

        foreach ($this->parts as $category => $items) {
            foreach ($items as $name => $brand) {
                $part = Part::create([
                    'name' => $name,
                    'part_number' => sprintf('%s-%04d', strtoupper(substr($category, 0, 3)), $counter++),
                    'category' => $category,
                    'details' => [
                        'manufacturer' => $brand,
                        'compatibility' => 'Petrol & Diesel engines',
                    ],
                ]);

                $ids[] = $part->id;
            }
        }

        return $ids;
    }

    /**
     * @param  int[]  $partIds
     */
    private function seedVehicleHierarchy(array $partIds): void
    {
        foreach ($this->catalog as $manufacturerName => $models) {
            $manufacturer = Manufacturer::create(['name' => $manufacturerName]);

            foreach ($models as $modelName => $variants) {
                $model = VehicleModel::create([
                    'manufacturer_id' => $manufacturer->id,
                    'name' => $modelName,
                ]);

                $details = $this->modelDetails[$modelName];

                foreach ($variants as $variantName) {
                    $variant = Variant::create([
                        'model_id' => $model->id,
                        'name' => $variantName,
                    ]);

                    $vehicle = Vehicle::create([
                        'variant_id' => $variant->id,
                        'launch_date' => $details['launch_date'],
                        'discontinue_date' => null,
                        'details' => [
                            'manufacturing_origin' => $details['origin'],
                            'fuel_type' => $details['fuel_type'],
                            'body_type' => $details['body_type'],
                            'seating_capacity' => $details['seating_capacity'],
                        ],
                    ]);

                    $vehicle->parts()->attach(
                        collect($partIds)->random(min(count($partIds), 5))->all()
                    );
                }
            }
        }
    }
}
