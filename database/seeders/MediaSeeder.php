<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['anime', 'Fullmetal Alchemist: Brotherhood', ['Action','Adventure','Drama'], 2009, 9.1, 64, null, null],
            ['anime', 'Attack on Titan', ['Action','Drama'], 2013, 8.6, 25, null, null],
            ['anime', 'Your Lie in April', ['Drama','Romance'], 2014, 8.7, 22, null, null],
            ['drama', 'Crash Landing on You', ['Romance','Comedy'], 2019, 8.7, 16, 'Korea Selatan', null],
            ['manga', 'One Piece', ['Action','Adventure'], 1997, 9.2, 1100, null, 'Eiichiro Oda'],
            ['light_novel', 'Sword Art Online', ['Action','Adventure','Romance'], 2009, 7.5, 27, null, 'Reki Kawahara'],
        ];

        foreach ($data as [$type, $title, $genres, $year, $score, $units, $country, $author]) {
            Media::create([
                'type' => $type, 'title' => $title, 'genres' => $genres,
                'year' => $year, 'score' => $score, 'unit_count' => $units,
                'country' => $country, 'author' => $author,
            ]);
        }
    }
}
