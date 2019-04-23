'use strict'

/**
 * Sets up Standard CSRF Token for all ajax Requests inside this Script
 */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * Creates a Bootstrap Card and appends it to 'row #station-details'
 */
function detailMonitor() {
    return $('<div>').attr('id', 'detail-monitor').appendTo('#station-details');
}

/**
 * removes the detailMonitor()
 */
function removeMonitor() {
    return $('#detail-monitor').remove();
}

function loadingIcon() {
    $('<div>').appendTo('#detail-monitor').html('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
}

function departureLights(value) {
    if(value <= 5) {
        return 'btn-success';
    } else if(value > 5 && value <= 10) {
        return 'btn-warning';
    } else {
        return 'btn-danger';
    }
}

/**
 * Starts the Click Event on the single Stations
 */
$('.detail-row').on('click', function() {
    removeMonitor();
    detailMonitor();
    loadingIcon();
    var line = $(this).children().attr('value');
    line = line.split('-');
    var station = $(this).children().html();
    /**
     * Checks if RBL Number of Station is set
     */
    if(line !== 'undefined' || station !== '') {
        $.ajax({
            url: '/ajax/details',
            method: 'GET',
            data: {
                station : station,
                line : line[0],
                type : line[1]
            },
            success: function(response) {
                removeMonitor();
                detailMonitor();
                var stationDetails = response;
                if(stationDetails.length === 0 || stationDetails.error) {
                    var newHeader = $('<h3>')
                                        .appendTo('#detail-monitor:first-child')
                                        .html('<i class="large material-icons">close</i>' + stationDetails.error);
                    return newHeader;
                } else {
                    var newHeader = $('<h3>')
                                    .appendTo('#detail-monitor:first-child')
                                    .html(stationDetails[0].locationStop.properties.title);
                    
                    for(let i = 0; stationDetails.length > i; i++){
                        if(i > 0 && stationDetails[0].torwards === stationDetails[1].torwards) {
                            continue;
                        } else {
                            var list = $('<ul>')
                                .addClass('list-group departure-list')
                                .appendTo('#detail-monitor');
                            var station = stationDetails[ i ];

                            var towartsLi = $('<li>').addClass('list-group-item').html('Richtung: ' + station.torwards);
        
                            if(station.barrierFree === true) {
                                var barrierFreeLi = $('<li>').attr('id', i).addClass('list-group-item').html('<i class="material-icons large btn handicap-icon">accessible</i>');
                            }
                            if(station.realtimeSupported === true) {
                                var departures = station.departures;
                                var singleDeparture = 'Abfahrtszeiten: ';
                                for(let u = 0; departures.length > u; u++ ) {
                                    if(u < 2){
                                        singleDeparture += '<span class="btn departure-monitor '+ departureLights(departures[u].departureTime.countdown) + '">' + departures[u].departureTime.countdown + '</span>';
                                    } else if(departures[u].departureTime.countdown === undefined) {
                                        return false;
                                    }
                                }
                                var departureLi = $('<li>').addClass('list-group-item').html(singleDeparture);
                                list.append(towartsLi, departureLi, barrierFreeLi);
                            } else {
                                newLi.html('Keine Echtzeitdaten vorhanden');
                            }
                        }
                    }
                }
            },
            error: function(response, response2) {
                removeMonitor();
                $('<div>').appendTo('#detail-monitor').html('Something went Wrong ' + response2);
            }
        });
    }
});