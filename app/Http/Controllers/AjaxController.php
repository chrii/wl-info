<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function details(Request $request) {
        //$url = 'http://www.wienerlinien.at/ogd_realtime/monitor?rbl=104&activateTrafficInfo=stoerungkurz&activateTrafficInfo=stoerunglang&activateTrafficInfo=aufzugsinfo&sender=' . config('app.wl-dev-key');
        $hs = App\Wl_steige::all()
                            ->first()
                            ->getByStation($request->type)
                            ->where('NAME', $request->station)
                            ->where('BEZEICHNUNG', $request->line)
                            ->pluck('RBL_NUMMER');
            $json = [];
            foreach ($hs AS $value) {
                $url = 'http://www.wienerlinien.at/ogd_realtime/monitor?rbl=' . $value . '&activateTrafficInfo=stoerungkurz&activateTrafficInfo=stoerunglang&activateTrafficInfo=aufzugsinfo&sender=' . config('app.wl-dev-key');
            $fetch = json_decode(file_get_contents($url));
            $fetch = collect($fetch);
            
            if(!empty($fetch['data']->monitors)){
                $fetch = $fetch['data']->monitors;
                foreach($fetch AS $fetchKey => $fetchValue) {
                    if($fetchValue->lines[0]->name === $request->line) {
                        $fetch = $fetch[$fetchKey];
                    }   
                }
                /**
                 * @FIXME
                 * lines does not work
                 * Linie O GET 500 Internal
                 */
                if($fetch->lines[0]->type === 'ptTramVRT'){
                    continue;
                }
                $json[] = [
                    'name' => $fetch->lines[0]->name,
                    'locationStop' => $fetch->locationStop,
                    'barrierFree' => $fetch->lines[0]->barrierFree,
                    'realtimeSupported' => $fetch->lines[0]->realtimeSupported,
                    'departures' => $fetch->lines[0]->departures->departure,
                    'torwards' => $fetch->lines[0]->towards
                ];
            } else {
                $json = ['error' => 'Derzeit keine Daten vorhanden'];
                $json = collect($json);
                return response($json);
            }
        }
        $json = collect($json);
        return response(json_decode($json));
    }
}
