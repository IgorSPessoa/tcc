const input = document.getElementById("modalAddress");        
const options = {
 componentRestrictions: { country: "br" },
 fields: ["address_components", "geometry", "icon", "name"],
 strictBounds: false,
 };
 
 const autocomplete = new google.maps.places.Autocomplete(input, options);
 