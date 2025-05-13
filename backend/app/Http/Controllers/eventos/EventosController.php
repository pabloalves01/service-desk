<?php

namespace App\Http\Controllers\eventos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventosController extends Controller
{
    public function store() {
        return response()->json(['message' => 'Evento criado com sucesso!']);
    }
}
