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

/**
 * Starts the Click Event on the single Stations
 */
$('.detail-row').on('click', function() {
    removeMonitor();
    detailMonitor();

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
                
                console.log(response);
                if(stationDetails.length === 0 || stationDetails.error) {
                    var newHeader = $('<h3>')
                                        .appendTo('#detail-monitor:first-child')
                                        .html('<i class="large material-icons">close</i>' + stationDetails.error);
                    return newHeader;
                }
                for(let i = 0; stationDetails.length > i; i++){
                    $('<ul>').addClass('list-group').appendTo('#detail-monitor');
                    var station = stationDetails[ i ];
                    var newLi = $('<li>').appendTo('#detail-monitor ul:last-child').addClass('list-group-item');


                    if(station.barrierFree === true) {
                        newLi.html('<i class="material-icons">accessible</i>');
                    }
                    //console.log(stationDetails[ i ]);
                }
            },
            error: function(response, response2) {
                console.log('tot');
                console.log('"response2"');
            }
        });
    }

});