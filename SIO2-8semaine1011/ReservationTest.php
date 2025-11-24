<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    /**
     * A test to view the list of reservations.
     *
     * @return void
     */
    public function testAllReservations()
    {
        //When user visit the index page
        $response = $this->get('/');      
        //He should be able to read 'Liste des Reservations'
        $response->assertSee('Liste des Reservations');
    }

    /**
     * A test to create a reservation.
     *
     * @return void
     */
    public function testCreateReservation()
    {
        //When user submits post request to create reservation endpoint
               //A reservation which is created by the user
               $reservation = \App\Models\Reservation::create([
                'user_id' =>  \App\Models\User::all()->random()->id,
                'article_id' => \App\Models\Article::all()->random()->id,
                'debut' => fake()->date(),
                'fin' => fake()->date(),
            ]); 
       //When user visit the reservation's URI
        $response = $this->get('/show/' . $reservation->id);
        //He can see the reservation's
      $response->assertSee('Réservation');
    }
}
