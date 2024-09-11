<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Message;
use App\Models\EventUser;
use App\Models\ForbiddenWord;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(40)->create();
        Event::factory(10)->create();
        Message::factory(50)->create();
        EventUser::factory(50)->create();
        ForbiddenWord::insert([
            ['word' => 'connard'],
            ['word' => 'conne'],
            ['word' => 'abruti'],
            ['word' => 'enfoiré'],
            ['word' => 'salopard'],
            ['word' => 'ordure'],
            ['word' => 'idiot'],
            ['word' => 'imbécile'],
            ['word' => 'débile'],
            ['word' => 'crétin'],
            ['word' => 'trou du cul'],
            ['word' => 'va te faire'],
            ['word' => 'merde'],
            ['word' => 'ta gueule'],
            ['word' => 'casse-toi'],
            ['word' => 'bouffon'],
            ['word' => 'bâtard'],
            ['word' => 'fils de pute'],
            ['word' => 'pétasse'],
            ['word' => 'salope'],
            ['word' => 'enculé'],
            ['word' => 'sexe'],
            ['word' => 'porno'],
            ['word' => 'pédophile'],
            ['word' => 'prostitution'],
            ['word' => 'viol'],
            ['word' => 'violer'],
            ['word' => 'sodomie'],
            ['word' => 'pénétration'],
            ['word' => 'orgie'],
            ['word' => 'masturbation'],
            ['word' => 'éjaculation'],
            ['word' => 'jouir'],
            ['word' => 'foutre'],
            ['word' => 'chatte'],
            ['word' => 'bite'],
            ['word' => 'nichon'],
            ['word' => 'téton'],
            ['word' => 'cul'],
            ['word' => 'fesses'],
            ['word' => 'branler'],
            ['word' => 'baiser'],
            ['word' => 'pute'],
            ['word' => 'putain'],
            ['word' => 'strip-tease'],
            ['word' => 'escort'],
            ['word' => 'tuer'],
            ['word' => 'assassiner'],
            ['word' => 'massacrer'],
            ['word' => 'exploser'],
            ['word' => 'poignarder'],
            ['word' => 'frapper'],
            ['word' => 'étrangler'],
            ['word' => 'lyncher'],
            ['word' => 'terroriste'],
            ['word' => 'haineux'],
            ['word' => 'raciste'],
            ['word' => 'nazi'],
            ['word' => 'fasciste'],
            ['word' => 'brûler'],
            ['word' => 'bombarder'],
            ['word' => 'exterminer'],
            ['word' => 'nègre'],
            ['word' => 'sale arabe'],
            ['word' => 'youpin'],
            ['word' => 'chinetoque'],
            ['word' => 'bougnoule'],
            ['word' => 'raton'],
            ['word' => 'pédé'],
            ['word' => 'gouine'],
            ['word' => 'trans']]
        );
    }
}
