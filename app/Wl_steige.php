<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wl_steige extends Model
{
    protected $primaryKey = 'STEIG_ID';
    //WL_haltestellen->HALTESTELLEN_ID -> unique

    public function getByStation($station) {
        return \DB::table('wl_steiges')
        ->select('NAME', 'BEZEICHNUNG', 'VERKEHRSMITTEL', 'RICHTUNG', 'RBL_NUMMER', 'STEIG_WGS84_LAT', 'STEIG_WGS84_LON')
        ->join('wl_haltestellens', 'wl_haltestellens.HALTESTELLEN_ID', '=' , 'wl_steiges.HALTESTELLEN_ID')
        ->join('wl_liniens', 'wl_liniens.LINIEN_ID', '=' , 'wl_steiges.LINIEN_ID')
        ->where('GEMEINDE', 'Wien')
        ->where('VERKEHRSMITTEL', $station)
        ->get();
    }
}
