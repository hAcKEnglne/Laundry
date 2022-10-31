<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Http\Resources\UserResource;

use App\Models\Reservation;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{   
    // Visualizza tutte le prenotazioni dell'utente selezionato
    public function visualizzaPrenotazioniUtente(User $user)
    {
        return ReservationResource::collection($user->prenotazione);
    }

    // Cancella tutte le prenotazioni dell'utente selezionato
    public function cancellaPrenotazioniUtente(User $user)
    {
        $user->prenotazione()->delete();
    }

    // Cancella la singola prenotazione dell'utente selezionato
    public function cancellaPrenotazioneUtente(User $user)
    {
        $user->prenotazione->delete();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // Visualizza tutti gli utenti
    public function index()
    {
        return ['utente' => UserResource::collection(User::all())];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ['utente' => ReservationResource::collection(Reservation::all())];
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
