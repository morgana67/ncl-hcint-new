<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array (
                    0 =>
                        array (
                            'title' => 'Alaska',
                            'code' => 'AK',
                        ),
                    1 =>
                        array (
                            'title' => 'Alabama',
                            'code' => 'AL',
                        ),
                    2 =>
                        array (
                            'title' => 'Arkansas',
                            'code' => 'AR',
                        ),
                    3 =>
                        array (
                            'title' => 'Arizona',
                            'code' => 'AZ',
                        ),
                    4 =>
                        array (
                            'title' => 'California',
                            'code' => 'CA',
                        ),
                    5 =>
                        array (
                            'title' => 'Colorado',
                            'code' => 'CO',
                        ),
                    6 =>
                        array (
                            'title' => 'Connecticut',
                            'code' => 'CT',
                        ),
                    7 =>
                        array (
                            'title' => 'District of Columbia',
                            'code' => 'DC',
                        ),
                    8 =>
                        array (
                            'title' => 'Delaware',
                            'code' => 'DE',
                        ),
                    9 =>
                        array (
                            'title' => 'Florida',
                            'code' => 'FL',
                        ),
                    10 =>
                        array (
                            'title' => 'Georgia',
                            'code' => 'GA',
                        ),
                    11 =>
                        array (
                            'title' => 'Hawaii',
                            'code' => 'HI',
                        ),
                    12 =>
                        array (
                            'title' => 'Iowa',
                            'code' => 'IA',
                        ),
                    13 =>
                        array (
                            'title' => 'Idaho',
                            'code' => 'ID',
                        ),
                    14 =>
                        array (
                            'title' => 'Illinois',
                            'code' => 'IL',
                        ),
                    15 =>
                        array (
                            'title' => 'Indiana',
                            'code' => 'IN',
                        ),
                    16 =>
                        array (
                            'title' => 'Kansas',
                            'code' => 'KS',
                        ),
                    17 =>
                        array (
                            'title' => 'Kentucky',
                            'code' => 'KY',
                        ),
                    18 =>
                        array (
                            'title' => 'Louisiana',
                            'code' => 'LA',
                        ),
                    19 =>
                        array (
                            'title' => 'Massachusetts',
                            'code' => 'MA',
                        ),
                    20 =>
                        array (
                            'title' => 'Maryland',
                            'code' => 'MD',
                        ),
                    21 =>
                        array (
                            'title' => 'Maine',
                            'code' => 'ME',
                        ),
                    22 =>
                        array (
                            'title' => 'Michigan',
                            'code' => 'MI',
                        ),
                    23 =>
                        array (
                            'title' => 'Minnesota',
                            'code' => 'MN',
                        ),
                    24 =>
                        array (
                            'title' => 'Missouri',
                            'code' => 'MO',
                        ),
                    25 =>
                        array (
                            'title' => 'Mississippi',
                            'code' => 'MS',
                        ),
                    26 =>
                        array (
                            'title' => 'Montana',
                            'code' => 'MT',
                        ),
                    27 =>
                        array (
                            'title' => 'North Carolina',
                            'code' => 'NC',
                        ),
                    28 =>
                        array (
                            'title' => 'North Dakota',
                            'code' => 'ND',
                        ),
                    29 =>
                        array (
                            'title' => 'Nebraska',
                            'code' => 'NE',
                        ),
                    30 =>
                        array (
                            'title' => 'New Hampshire',
                            'code' => 'NH',
                        ),
                    31 =>
                        array (
                            'title' => 'New Jersey',
                            'code' => 'NJ',
                        ),
                    32 =>
                        array (
                            'title' => 'New Mexico',
                            'code' => 'NM',
                        ),
                    33 =>
                        array (
                            'title' => 'Nevada',
                            'code' => 'NV',
                        ),
                    34 =>
                        array (
                            'title' => 'New York',
                            'code' => 'NY',
                        ),
                    35 =>
                        array (
                            'title' => 'Ohio',
                            'code' => 'OH',
                        ),
                    36 =>
                        array (
                            'title' => 'Oklahoma',
                            'code' => 'OK',
                        ),
                    37 =>
                        array (
                            'title' => 'Oregon',
                            'code' => 'OR',
                        ),
                    38 =>
                        array (
                            'title' => 'Pennsylvania',
                            'code' => 'PA',
                        ),
                    39 =>
                        array (
                            'title' => 'Rhode Island',
                            'code' => 'RI',
                        ),
                    40 =>
                        array (
                            'title' => 'South Carolina',
                            'code' => 'SC',
                        ),
                    41 =>
                        array (
                            'title' => 'South Dakota',
                            'code' => 'SD',
                        ),
                    42 =>
                        array (
                            'title' => 'Tennessee',
                            'code' => 'TN',
                        ),
                    43 =>
                        array (
                            'title' => 'Texas',
                            'code' => 'TX',
                        ),
                    44 =>
                        array (
                            'title' => 'Utah',
                            'code' => 'UT',
                        ),
                    45 =>
                        array (
                            'title' => 'Virginia',
                            'code' => 'VA',
                        ),
                    46 =>
                        array (
                            'title' => 'Vermont',
                            'code' => 'VT',
                        ),
                    47 =>
                        array (
                            'title' => 'Washington',
                            'code' => 'WA',
                        ),
                    48 =>
                        array (
                            'title' => 'Wisconsin',
                            'code' => 'WI',
                        ),
                    49 =>
                        array (
                            'title' => 'West Virginia',
                            'code' => 'WV',
                        ),
                    50 =>
                        array (
                            'title' => 'Wyoming',
                            'code' => 'WY',
                        ),
        );
        \App\Models\State::insert($data);
    }
}
