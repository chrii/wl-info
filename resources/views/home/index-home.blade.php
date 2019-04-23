@extends('layout.welcome')

@section('content')

<div class="card">
{{--     <div class="card-body">
        <div class="card-header">
            <h1>
                Verspätungen
            </h1>
        </div>
        @if(count($lang) === 0)
            <p>Derzeit sind keine Verspätungen gemeldet</p>
        @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Betrifft</th>
                    <th>Dauer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lang AS $shortDetails)
                <tr>
                    <td>Linie {{ $shortDetails['info']['title'] }}</td>
                     <td>{{ empty($shortDetails['info']['time']->resume) ? 'Keine Angabe' : date('i', strtotime( $shortDetails['info']['time']->resume )) . ' Minuten' }} </td>
                </tr>

                @endforeach
            </tbody>
        </table>
        @endif
        <div class="row">
            <div class="col">
                <div class="card-header">
                    <h1>
                        Störung
                    </h1>
                </div>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Stationsname</th>
                            <th>Betroffene Linien</th>
                            <th>Beschreibung</th>
                            <th>Start</th>
                            <th>Ende</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kurz AS $shortDetails)
                        {{ dd($shortDetails['station']->first()) }}
                        <tr>
                            <td>{{ isset($shortDetails['station']->first()->NAME) ? $shortDetails['station']->first()->NAME : 'NIX'}}</td>
                            <td> 
                                @foreach($shortDetails['station'] AS $lineNameShort)
                                    {{ $lineNameShort->BEZEICHNUNG }}
                                    {{ count($shortDetails['station']) === $loop->index + 1 ? '' : ','}}
                                @endforeach
                            </td>
                                <td>{{ $shortDetails['info']['description'] }}</td>
                            <td>{{ date('H:i d.m.Y', strtotime( $shortDetails['info']['time']->start )) }}</td>
                            <td>{{ date('H:i d.m.Y', strtotime( $shortDetails['info']['time']->end )) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col">
                <div class="card-header">
                    <h1>
                        Aufzugsmonitor
                    </h1>
                </div>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Linie</th>
                            <th>Station</th>
                            <th>Zugang</th>
                            <th>Begründung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aufzug AS $shortDetails)
                        <tr>
                            <td>{{ $shortDetails['info']['relatedLines'][0] }}</td>
                            <td>{{ $shortDetails['info']['title'] }}</td>
                            <td>{{ $shortDetails['info']['attributes']->location }}</td>
                            <td>{{ $shortDetails['info']['attributes']->reason }}</td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
</div>
@endsection