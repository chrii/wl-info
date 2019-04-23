<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class LinesController extends Controller
{
    public function home() {
        //dump($this->getInterruptionData('stoerunglang'));
        $interruptionInfo = collect($this->getInterruptionInfo());
        if($interruptionInfo === false) {
            return $interruptionInfo = 'Die Daten konnten nicht geladen werden';
        } else {
            $lol = collect($interruptionInfo);
        }
        return view('home.index-home', ['interrupt' => $lol]);
    }

    public function index(Request $request) {
        $hs = App\Wl_steige::all()->first();
        $hs = $hs->getByStation($request->type)->where('RICHTUNG', 'H')->groupBy('BEZEICHNUNG');
        //dump($hs = $hs->getByStation('ptMetro')->groupBy('BEZEICHNUNG'))
        $name = empty($request->name) ? 'Alle Linien' : $request->name;

        return view('lines-overview.index-lines', ['stellen' => collect($hs), 'name' => $name]);
    }

    public function getInterruptionData(String $interruptionType) {
        $responseJson = file_get_contents('http://www.wienerlinien.at/ogd_realtime/trafficInfoList?sender=' . config('app.wl-dev-key'));
        $jsonDecoded = collect(json_decode($responseJson));
        $data = $jsonDecoded['data'];

        if(isset($data) && isset($interruptionType)) {
            $trafficInfos = collect($data->trafficInfos);
            $trafficInfoCategories = collect($data->trafficInfoCategories);

            $category = $trafficInfoCategories->where('name', $interruptionType)->pluck('id')->first();
            $output = $trafficInfos->where('refTrafficInfoCategoryId', $category);
            $hs = App\Wl_steige::all()->first();
            $mapped = $output->map(function( $item ) use($hs) {

                $hs = $hs->getByStation(null)
                            ->where('RBL_NUMMER', collect($item->relatedStops)
                            ->first());
                $output = [
                    'info' => collect($item),
                    'station' => $hs                   
                ];
                return $output;
            });
            
            return $mapped;
        } else {
            return false;
        }

        //$stoerung = $jsonDecoded->where($jsonDecoded->first())
        //dd($trafficInfos->where('refTrafficInfoCategoryId', $trafficInfoCategories->id));
    }

    public function getInterruptionInfo() {
        $responseJson = file_get_contents('http://www.wienerlinien.at/ogd_realtime/trafficInfoList?sender=' . config('app.wl-dev-key'));
        $jsonDecoded = collect(json_decode($responseJson));
        $data = $jsonDecoded['data'];

        if(isset($data)) {
            $trafficInfos = collect($data->trafficInfos);
            $trafficInfoCategories = collect($data->trafficInfoCategories);

            $infoTypes = $trafficInfos->groupBy('refTrafficInfoCategoryId');

            return $infoTypes;
        } else {
            return false;
        }
    }
}