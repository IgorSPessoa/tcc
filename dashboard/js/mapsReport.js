const chave = "AIzaSyChFNJMuEdWzbDHzz1GskqtstVDLe9dcIo";
    let url = `https://maps.googleapis.com/maps/api/geocode/json?address=${address}&key=${chave}`;
    fetch(url)
    .then(response => response.json())
    .then( data => {
        let latLocation = data.results[0].geometry.location.lat;
        let lngLocation = data.results[0].geometry.location.lng;
        const LatLng = {lat: latLocation, lng: lngLocation};
        
        map = new google.maps.Map(document.getElementById('map'),{
            center: {lat: latLocation, lng: lngLocation},
            zoom: 18      
            });
        
            new google.maps.Marker({
            position: LatLng,
            map,
            title: "O animal está aqui!",
        });
    })
    .catch(err => console.warn(err.message));
        
  