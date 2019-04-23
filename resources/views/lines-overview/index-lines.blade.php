@extends('layout.welcome')

@section('content')

<div class="card">
    <div class="card-header">
        <h1>
            {{ $name }}
        </h1>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
<!-- Begin Accordion for the traffic lines -->
                <div class="accordion" id="accordion">
<!-- First foreach to iterate the single traffic lines and fetch the name oit of the key -->
                    @foreach($stellen AS $line => $stations)
                         <div class="card">
                            <a class="btn" id="heading{{ $line }}" data-toggle="collapse" data-target="#collapse{{ $line }}">
                                Linie {{ $line }}
                            </a>
<!-- Start the content -->
                            <div id="collapse{{ $line }}" class="collapse" aria-labelledby="heading{{ $line }}" data-parent="#accordion">
                                <div class="card-body">
                                    <table class="table table-sm">
                                        @foreach( $stations AS $station)
                                            <tr class="detail-row">
                                                <td value="{{ $line }}-{{$station->VERKEHRSMITTEL}}">{{ $station->NAME }}</td>
                                                <td>{{ $station->STEIG_WGS84_LAT }}</td>
                                                <td>{{ $station->STEIG_WGS84_LON }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
<!-- End Content -->
                    @endforeach
                </div>
<!-- End Accordion -->
        </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h1>Stationsinformationen</h1>
                    </div>
                    <div class="card-body">
                        <div id="station-details"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('optional-javascript')
<script src="{{ asset('js/station-details.js') }}"></script>
@endsection