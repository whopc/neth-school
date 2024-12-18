<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('teachers')->delete();
        
        \DB::table('teachers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'first_name' => 'Oswaldo',
                'last_name' => 'Hahn',
                'id_number' => '130910185',
                'dob' => '1979-05-23',
                'gender' => 'male',
                'address' => '161 Scot Road
Allyland, MN 49431-5985',
                'phone' => '+1-845-490-7037',
                'email' => 'jacobson.angeline@example.net',
                'specialization' => 'nostrum',
                'academic_degree' => 'culpa',
                'hire_date' => '1980-06-22',
                'status' => 1,
                'contract_type' => 'Private',
                'salary' => 28244,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            1 => 
            array (
                'id' => 2,
                'first_name' => 'Kiarra',
                'last_name' => 'Rempel',
                'id_number' => '153005486',
                'dob' => '1971-12-14',
                'gender' => 'other',
                'address' => '266 Aufderhar Pass Suite 870
Soledadside, MT 95361',
                'phone' => '+1.484.830.3537',
                'email' => 'rmoen@example.org',
                'specialization' => NULL,
                'academic_degree' => NULL,
                'hire_date' => '1981-03-09',
                'status' => 0,
                'contract_type' => 'MINERD',
                'salary' => 30857,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            2 => 
            array (
                'id' => 3,
                'first_name' => 'Dangelo',
                'last_name' => 'Greenholt',
                'id_number' => '510203032',
                'dob' => '1986-06-03',
                'gender' => 'female',
                'address' => '761 Prosacco Squares Apt. 656
Stehrstad, AL 53831-4948',
            'phone' => '+1 (609) 918-9772',
                'email' => 'blangosh@example.org',
                'specialization' => NULL,
                'academic_degree' => NULL,
                'hire_date' => '2014-01-26',
                'status' => 1,
                'contract_type' => 'MINERD',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            3 => 
            array (
                'id' => 4,
                'first_name' => 'Connor',
                'last_name' => 'Hackett',
                'id_number' => '525932756',
                'dob' => '1992-09-07',
                'gender' => 'female',
                'address' => '73209 Maribel Underpass Apt. 309
Feestchester, WI 07347',
            'phone' => '(270) 362-2979',
                'email' => 'jmoen@example.org',
                'specialization' => 'autem',
                'academic_degree' => NULL,
                'hire_date' => '1989-03-23',
                'status' => 0,
                'contract_type' => 'Private',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            4 => 
            array (
                'id' => 5,
                'first_name' => 'Kara',
                'last_name' => 'Dach',
                'id_number' => '179073458',
                'dob' => '1994-12-22',
                'gender' => 'other',
                'address' => '826 Jewel Island
Grantborough, OK 62843-0374',
            'phone' => '(445) 577-1578',
                'email' => 'mgreen@example.org',
                'specialization' => NULL,
                'academic_degree' => 'vel',
                'hire_date' => '2003-05-12',
                'status' => 1,
                'contract_type' => 'MINERD',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            5 => 
            array (
                'id' => 6,
                'first_name' => 'Aiyana',
                'last_name' => 'Johns',
                'id_number' => '082877164',
                'dob' => '1983-07-01',
                'gender' => 'female',
                'address' => '6548 Gibson Lakes Suite 801
Hueltown, WI 64481-3213',
                'phone' => '+1.458.702.9276',
                'email' => 'qharris@example.org',
                'specialization' => 'rem',
                'academic_degree' => NULL,
                'hire_date' => '2006-09-30',
                'status' => 0,
                'contract_type' => 'Private',
                'salary' => 49114,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            6 => 
            array (
                'id' => 7,
                'first_name' => 'Peggie',
                'last_name' => 'Dooley',
                'id_number' => '068933523',
                'dob' => '1977-10-13',
                'gender' => 'male',
                'address' => '171 Feil Cliffs
East Darienview, NC 00539-5655',
            'phone' => '(818) 258-7928',
                'email' => 'ritchie.fiona@example.net',
                'specialization' => 'molestiae',
                'academic_degree' => NULL,
                'hire_date' => '2019-10-15',
                'status' => 1,
                'contract_type' => 'MINERD',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            7 => 
            array (
                'id' => 8,
                'first_name' => 'Cynthia',
                'last_name' => 'Cummerata',
                'id_number' => '947301030',
                'dob' => '1992-04-19',
                'gender' => 'female',
                'address' => '460 Rowe Estate
Spinkashire, TX 49439',
                'phone' => '1-906-918-4657',
                'email' => 'rosamond07@example.net',
                'specialization' => 'unde',
                'academic_degree' => NULL,
                'hire_date' => '1988-02-25',
                'status' => 0,
                'contract_type' => 'MINERD',
                'salary' => 70907,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            8 => 
            array (
                'id' => 9,
                'first_name' => 'Cecelia',
                'last_name' => 'Roob',
                'id_number' => '915489106',
                'dob' => '1985-08-05',
                'gender' => 'female',
                'address' => '760 Stamm Burgs
Port Quintonville, LA 78369',
            'phone' => '(564) 317-3723',
                'email' => 'izaiah.kilback@example.com',
                'specialization' => NULL,
                'academic_degree' => NULL,
                'hire_date' => '2000-02-28',
                'status' => 1,
                'contract_type' => 'Private',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            9 => 
            array (
                'id' => 10,
                'first_name' => 'Casandra',
                'last_name' => 'Goodwin',
                'id_number' => '161338444',
                'dob' => '1979-04-29',
                'gender' => 'male',
                'address' => '237 Karlee Mill
Gradystad, CA 05020',
                'phone' => '870-783-7925',
                'email' => 'okuneva.keshawn@example.net',
                'specialization' => 'ut',
                'academic_degree' => NULL,
                'hire_date' => '1977-11-16',
                'status' => 0,
                'contract_type' => 'MINERD',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            10 => 
            array (
                'id' => 11,
                'first_name' => 'Althea',
                'last_name' => 'Lehner',
                'id_number' => '612480816',
                'dob' => '1992-09-09',
                'gender' => 'male',
                'address' => '85361 Delta Mountains Suite 932
Princeburgh, FL 15168-9700',
                'phone' => '985-525-1664',
                'email' => 'jose.stracke@example.com',
                'specialization' => 'molestiae',
                'academic_degree' => 'autem',
                'hire_date' => '1973-12-10',
                'status' => 1,
                'contract_type' => 'MINERD',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            11 => 
            array (
                'id' => 12,
                'first_name' => 'Alex',
                'last_name' => 'Raynor',
                'id_number' => '434732610',
                'dob' => '1973-11-10',
                'gender' => 'male',
                'address' => '153 Lonzo Lodge
Port Makenzieview, IN 66767',
                'phone' => '941-487-5275',
                'email' => 'roob.alf@example.com',
                'specialization' => NULL,
                'academic_degree' => NULL,
                'hire_date' => '1972-06-18',
                'status' => 0,
                'contract_type' => 'MINERD',
                'salary' => 47056,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            12 => 
            array (
                'id' => 13,
                'first_name' => 'Norbert',
                'last_name' => 'Kling',
                'id_number' => '916670257',
                'dob' => '1977-12-31',
                'gender' => 'male',
                'address' => '4614 Tillman Groves
Port Sofialand, DE 66356-1225',
            'phone' => '(364) 677-2257',
                'email' => 'therese.considine@example.org',
                'specialization' => 'ducimus',
                'academic_degree' => 'eum',
                'hire_date' => '1996-09-22',
                'status' => 0,
                'contract_type' => 'MINERD',
                'salary' => 69291,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            13 => 
            array (
                'id' => 14,
                'first_name' => 'Julie',
                'last_name' => 'Jaskolski',
                'id_number' => '203775872',
                'dob' => '1980-06-04',
                'gender' => 'other',
                'address' => '749 Balistreri Hills
Wuckertborough, PA 89011',
            'phone' => '(781) 381-5954',
                'email' => 'ifeest@example.org',
                'specialization' => NULL,
                'academic_degree' => 'dolores',
                'hire_date' => '1990-12-21',
                'status' => 0,
                'contract_type' => 'MINERD',
                'salary' => 38247,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            14 => 
            array (
                'id' => 15,
                'first_name' => 'Teagan',
                'last_name' => 'Johns',
                'id_number' => '517288787',
                'dob' => '1990-05-12',
                'gender' => 'male',
                'address' => '1376 Hamill Ford
West Dylan, TN 96728',
                'phone' => '330-260-4174',
                'email' => 'bergnaum.gennaro@example.org',
                'specialization' => NULL,
                'academic_degree' => 'iusto',
                'hire_date' => '2013-12-18',
                'status' => 1,
                'contract_type' => 'Private',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            15 => 
            array (
                'id' => 16,
                'first_name' => 'Molly',
                'last_name' => 'D\'Amore',
                'id_number' => '250280938',
                'dob' => '1970-08-17',
                'gender' => 'female',
                'address' => '8206 Lysanne Ferry Apt. 588
Aidenchester, KY 97199-6073',
            'phone' => '(503) 509-9320',
                'email' => 'xjenkins@example.org',
                'specialization' => NULL,
                'academic_degree' => 'sit',
                'hire_date' => '2014-11-12',
                'status' => 1,
                'contract_type' => 'MINERD',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            16 => 
            array (
                'id' => 17,
                'first_name' => 'Jewell',
                'last_name' => 'Hegmann',
                'id_number' => '784662931',
                'dob' => '1993-06-09',
                'gender' => 'female',
                'address' => '7293 Connelly Fall
Lake Annamae, GA 25732',
                'phone' => '+1.216.958.5910',
                'email' => 'carroll.river@example.com',
                'specialization' => NULL,
                'academic_degree' => 'inventore',
                'hire_date' => '1978-11-13',
                'status' => 0,
                'contract_type' => 'Private',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            17 => 
            array (
                'id' => 18,
                'first_name' => 'Ciara',
                'last_name' => 'Erdman',
                'id_number' => '065225388',
                'dob' => '1988-05-03',
                'gender' => 'other',
                'address' => '332 Swift Course
Muhammadmouth, LA 80046',
                'phone' => '1-586-887-5231',
                'email' => 'sienna81@example.com',
                'specialization' => 'rerum',
                'academic_degree' => 'dolor',
                'hire_date' => '1995-06-21',
                'status' => 1,
                'contract_type' => 'MINERD',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            18 => 
            array (
                'id' => 19,
                'first_name' => 'Everette',
                'last_name' => 'Bechtelar',
                'id_number' => '152938580',
                'dob' => '1997-10-15',
                'gender' => 'male',
                'address' => '8424 Zechariah Corners
Daughertyfort, TN 91426-7403',
            'phone' => '(561) 905-5475',
                'email' => 'xgutmann@example.org',
                'specialization' => NULL,
                'academic_degree' => NULL,
                'hire_date' => '2001-07-12',
                'status' => 0,
                'contract_type' => 'Private',
                'salary' => 42588,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
            19 => 
            array (
                'id' => 20,
                'first_name' => 'Carlie',
                'last_name' => 'Balistreri',
                'id_number' => '768914837',
                'dob' => '1986-06-15',
                'gender' => 'other',
                'address' => '3844 Bailey Mill Suite 978
Port Hunterville, IA 26901-8147',
                'phone' => '+18508076968',
                'email' => 'heaney.dennis@example.org',
                'specialization' => 'sint',
                'academic_degree' => 'dolorem',
                'hire_date' => '2008-10-28',
                'status' => 1,
                'contract_type' => 'Private',
                'salary' => NULL,
                'created_at' => '2024-12-10 17:00:18',
                'updated_at' => '2024-12-10 17:00:18',
            ),
        ));
        
        
    }
}