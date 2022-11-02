<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

class AuthController extends Controller
{   
    // Costruttore
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    // Funzione di registrazione e query di creazione
    public function register(Request $request)
    {   
        // Controllo validazione campi da inserire nella query
        $validatedData = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'ruolo' => 'required|boolean'
        ]);

        // Query di creazione
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // Utilizzo di una password cifrata tramite algoritmo di hash Bcrypt
            'nome' => $validatedData['nome'],
            'cognome' => $validatedData['cognome'],
            'ruolo' => $validatedData['ruolo']
        ]);
    }

    // Funzione di login e query ricerca
    public function login(Request $request)
    {   
        // Il metodo attempt() accetta un array associativo come primo argomento. Il valore della password verrà sottoposto a hash. 
        // Gli altri valori nell'array verranno utilizzati per trovare l'utente nella tabella del database.
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Informazioni di Login errate'], 401);
        }

        // Query di selezione del primo record dalla tabella users attraverso email. firstOrFail() selezione del primo record oppure errore
        $user = User::where('email', $request['email'])->firstOrFail();

        // Generazione del token
        $token = $user->createToken('auth_token')->plainTextToken;
        
        // Restituzione di un json come risposta tramite codice HTTP di conferma (200)
        return response("Credentials Accepted", 200)->json([
            'access_token' => $token,
            'token_type' => 'Bearer', // I Bearer Token sono un tipo particolare di Access Token, 
            // usati per ottenere l'autorizzazione ad accedere ad una risorsa protetta da un Authorization Server
        ]);
    }
    
    // Funzione di logout e rimozione token
    public function logout(Request $request)
    { 
        // Ottiene il token dalla request
        $accessToken = $request->bearerToken();
        // Ottiene il token dal db
        $token = PersonalAccessToken::findToken($accessToken);
        // Rimuove il token
        $token->delete();
        // Effettua la disconnessione dell'utente
        Auth::logout();
    }
}