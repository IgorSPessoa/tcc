function apiDistanciaGoogle(id, cepOng, cepReport){
     //Find the distance
     var distanceService = new google.maps.DistanceMatrixService();
     distanceService.getDistanceMatrix({
        origins: [ cepOng ],
        destinations: [ cepReport ],
        travelMode: google.maps.TravelMode.WALKING,
        unitSystem: google.maps.UnitSystem.METRIC,
        durationInTraffic: true,
        avoidHighways: false,
        avoidTolls: false
    },
    function (response, status) {
        if (status !== google.maps.DistanceMatrixStatus.OK) {
            console.log('Error:', status);
        } else {
            var distancia = response.rows[0].elements[0].distance.text;
            $(id).html(distancia);
        }      
    });
}
