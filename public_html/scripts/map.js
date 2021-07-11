let map;

function mapStyle() {
    return {
        fillColor: '#657976',
        strokeColor: '#ddecf0',
        strokeWeight: 1,
        fillOpacity: 0.5
    }
}

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: 62.6399, lng: -99.5070 },
        zoom: 3.2,
        styles: [
            { "featureType": "all", "elementType": "geometry.fill", "stylers": [{ "weight": "2.00" }] },
            { "featureType": "all", "elementType": "geometry.stroke", "stylers": [{ "color": "#9c9c9c" }] },
            { "featureType": "all", "elementType": "labels.text", "stylers": [{ "visibility": "on" }] },
            { "featureType": "landscape", "elementType": "all", "stylers": [{ "color": "#f2f2f2" }] },
            { "featureType": "landscape", "elementType": "geometry.fill", "stylers": [{ "color": "#ffffff" }] },
            { "featureType": "landscape.man_made", "elementType": "geometry.fill", "stylers": [{ "color": "#ffffff" }] },
            { "featureType": "poi", "elementType": "all", "stylers": [{ "visibility": "off" }] },
            { "featureType": "road", "elementType": "all", "stylers": [{ "saturation": -100 }, { "lightness": 45 }] },
            { "featureType": "road", "elementType": "geometry.fill", "stylers": [{ "color": "#eeeeee" }] },
            { "featureType": "road", "elementType": "labels.text.fill", "stylers": [{ "color": "#7b7b7b" }] },
            { "featureType": "road", "elementType": "labels.text.stroke", "stylers": [{ "color": "#ffffff" }] },
            { "featureType": "road.highway", "elementType": "all", "stylers": [{ "visibility": "simplified" }] },
            { "featureType": "road.arterial", "elementType": "labels.icon", "stylers": [{ "visibility": "off" }] },
            { "featureType": "transit", "elementType": "all", "stylers": [{ "visibility": "off" }] },
            { "featureType": "water", "elementType": "all", "stylers": [{ "color": "#46bcec" }, { "visibility": "on" }] },
            { "featureType": "water", "elementType": "geometry.fill", "stylers": [{ "color": "#c8d7d4" }] },
            { "featureType": "water", "elementType": "labels.text.fill", "stylers": [{ "color": "#070707" }] },
            { "featureType": "water", "elementType": "labels.text.stroke", "stylers": [{ "color": "#ffffff" }] }
        ]
    });
    
    map.data.loadGeoJson("canada_provinces.geojson");
    
    map.data.setStyle(mapStyle());
    
    map.data.addListener("mouseover", (event) => {
        map.data.revertStyle();
        map.data.overrideStyle(event.feature, { fillOpacity: 0.8 });
        
        var windowdata="";
        var PRUID=event.feature.getProperty('PRUID');
        var jsondata=<?=$json_cache; ?>;
        for(i=0; i<jsondata.length; i++){
                if (jsondata[i].ID == PRUID) {
                    windowdata ='<p><b>Province: </b>'+jsondata[i].province+'</p>'
                    windowdata+='<p><b>Livable citytown: </b>'+jsondata[i].livable_citytown1+'</p>'
                    if(jsondata[i].livable_citytown2)
                        windowdata+='<p><b>Livable city town: </b>'+jsondata[i].livable_citytown2+'</p>'
                    if(jsondata[i].livable_citytown3)
                        windowdata+='<p><b>Livable city town: </b>'+jsondata[i].livable_citytown3+'</p>'
                }
                infowindow.setContent(windowdata);
                infowindow.setPosition(event.latLng);
                infowindow.setOptions({pixelOffset: new google.maps.Size(0,-30)});
                infowindow.open(map);
            }
        });
            //mouseout handler
            map.data.addListener("mouseout", (event) => {
                map.data.revertStyle();
                infowindow.close(map);
            });
}
