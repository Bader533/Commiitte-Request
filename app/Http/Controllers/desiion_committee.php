<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class desiion_committee extends Controller
{
    public function decision_committee()
    {
        return view('request_committee.decision-to-prepare-a-committee');
    }



}
