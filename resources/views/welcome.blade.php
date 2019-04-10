<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            <div class="container">
                <div class="card">
                    <div class="card-body">
<!-- Begin Accordion for the traffic lines -->
                        <div class="accordion" id="accordion">
                        <!-- First foreach to iterate the single traffic lines and fetch the name oit of the key -->
                            @foreach($stellen AS $line => $stations)
                                <div class="card">
                                    <div class="card-header" id="heading{{ $line }}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $line }}" aria-expanded="true" aria-controls="collapse{{ $line }}">
                                                Linie {{ $line }}
                                            </button>
                                        </h2>
                                    </div>
                                    <!-- Start the content -->
                                    <div id="collapse{{ $line }}" class="collapse" aria-labelledby="heading{{ $line }}" data-parent="#accordion">
                                            <div class="card-body">
                                                <table class="table">
                                    @foreach( $stations AS $station)
                                                    <tr>
                                                        <td>{{ $station->NAME }}</td>
                                                        <td>{{ $station->VERKEHRSMITTEL }}</td>
                                                        <td>{{ $station->RBL_NUMMER }}</td>
                                                        <td>{{ $station->STEIG_WGS84_LAT }}</td>
                                                        <td>{{ $station->STEIG_WGS84_LON }}</td>
                                                    </tr>
                                                    @endforeach  
                                            </table>
                                        </div>
                                    </div>
                                </div>  
                            @endforeach
                        </div>
<!-- End Accordion -->
{{--                         <table class="table table-dark">
                            <tbody>
                                @foreach($stellen AS $line => $stations)
                                    <tr>
                                        <th>Linie {{ $line }}</th>
                                    </tr>
                                    @foreach($stations AS $station)
                                    <tr>
                                        <td>{{ $station->NAME }}</td>
                                        <td>{{ $station->VERKEHRSMITTEL }}</td>
                                        <td>{{ $station->RBL_NUMMER }}</td>
                                        <td>{{ $station->STEIG_WGS84_LAT }}</td>
                                        <td>{{ $station->STEIG_WGS84_LON }}</td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table> --}}
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
