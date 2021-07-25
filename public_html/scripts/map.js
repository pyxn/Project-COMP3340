let map;

function mapStyle() {
  return {
    fillColor: "#657976",
    strokeColor: "#ddecf0",
    strokeWeight: 1,
    fillOpacity: 0.5,
  };
}

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 62.6399, lng: -99.507 },
    zoom: 3.2,
    styles: [
      {
        featureType: "all",
        elementType: "geometry.fill",
        stylers: [{ weight: "2.00" }],
      },
      {
        featureType: "all",
        elementType: "geometry.stroke",
        stylers: [{ color: "#9c9c9c" }],
      },
      {
        featureType: "all",
        elementType: "labels.text",
        stylers: [{ visibility: "on" }],
      },
      {
        featureType: "landscape",
        elementType: "all",
        stylers: [{ color: "#f2f2f2" }],
      },
      {
        featureType: "landscape",
        elementType: "geometry.fill",
        stylers: [{ color: "#ffffff" }],
      },
      {
        featureType: "landscape.man_made",
        elementType: "geometry.fill",
        stylers: [{ color: "#ffffff" }],
      },
      {
        featureType: "poi",
        elementType: "all",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "road",
        elementType: "all",
        stylers: [{ saturation: -100 }, { lightness: 45 }],
      },
      {
        featureType: "road",
        elementType: "geometry.fill",
        stylers: [{ color: "#eeeeee" }],
      },
      {
        featureType: "road",
        elementType: "labels.text.fill",
        stylers: [{ color: "#7b7b7b" }],
      },
      {
        featureType: "road",
        elementType: "labels.text.stroke",
        stylers: [{ color: "#ffffff" }],
      },
      {
        featureType: "road.highway",
        elementType: "all",
        stylers: [{ visibility: "simplified" }],
      },
      {
        featureType: "road.arterial",
        elementType: "labels.icon",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "transit",
        elementType: "all",
        stylers: [{ visibility: "off" }],
      },
      {
        featureType: "water",
        elementType: "all",
        stylers: [{ color: "#46bcec" }, { visibility: "on" }],
      },
      {
        featureType: "water",
        elementType: "geometry.fill",
        stylers: [{ color: "#c8d7d4" }],
      },
      {
        featureType: "water",
        elementType: "labels.text.fill",
        stylers: [{ color: "#070707" }],
      },
      {
        featureType: "water",
        elementType: "labels.text.stroke",
        stylers: [{ color: "#ffffff" }],
      },
    ],
  });
  map.data.loadGeoJson("canada_provinces.geojson");
  map.data.setStyle(mapStyle());

  var mapdata = [
    {
      ID: "59",
      p: "British Columbia",
      c1: "Langford",
      c2: "Kelowna",
      c3: "Rossland",
    },
    {
      ID: "24",
      p: "Quebec",
      c1: "Trois-Rivieres",
      c2: "Quebec City",
      c3: "Saguenay (CMA), Quebec",
    },
    {
      ID: "62",
      p: "Nunavut",
      c1: "",
      c2: "",
      c3: "",
    },
    {
      ID: "11",
      p: "Prince Edward Island",
      c1: "Charlottetown",
      c2: "Summerside",
      c3: "",
    },
    {
      ID: "47",
      p: "Saskatchewan",
      c1: "Saskatoon",
      c2: "Regina",
      c3: "Moose Jaw",
    },
    {
      ID: "60",
      p: "Yukon",
      c1: "Whitehorse",
      c2: "",
      c3: "",
    },
    {
      ID: "46",
      p: "Manitoba",
      c1: "Brandon",
      c2: "Winnipeg",
      c3: "Portage la Prairie",
    },
    {
      ID: "35",
      p: "Ontario",
      c1: "Niagara-on-the-Lake",
      c2: "Ottawa-Gatineau",
      c3: "Windsor",
    },
    {
      ID: "13",
      p: "New Brunswick",
      c1: "Bathurst",
      c2: "Miramichi",
      c3: "Quispamsis-Rothesay",
    },
    {
      ID: "61",
      p: "Northwest Territories",
      c1: "Yellowknife",
      c2: "",
      c3: "",
    },
    {
      ID: "48",
      p: "Alberta",
      c1: "Calgary",
      c2: "Canmore",
      c3: "Cochrane",
    },
    {
      ID: "10",
      p: "Newfoundland and Labrador",
      c1: "Corner Brook",
      c2: "St. John's",
      c3: "Clarenville",
    },
    {
      ID: "12",
      p: "Nova Scotia",
      c1: "Sydney",
      c2: "Halifax",
      c3: "Yarmouth",
    },
  ];
  var infowindow = new google.maps.InfoWindow();
  map.data.addListener("mouseover", (event) => {
    map.data.revertStyle();
    map.data.overrideStyle(event.feature, { fillOpacity: 0.8 });

    var windowdata = "";
    var PRUID = event.feature.getProperty("PRUID");

    for (var i = 0; i < mapdata.length; i++) {
      if (mapdata[i].ID == PRUID) {
        windowdata += "<p><b>Province: </b><br>" + mapdata[i].p + "</p><br>";
        windowdata += "<p><b>Livable cities/towns: </b><br>";
        windowdata += mapdata[i].c1 + "<br>";
        windowdata += mapdata[i].c2 + "<br>";
        windowdata += mapdata[i].c3 + "</p><br>";
      }
      infowindow.setContent(windowdata);
      infowindow.setPosition(event.latLng);
      //infowindow.setOptions({ pixelOffset: new google.maps.Size(0, -30) });
      infowindow.open(map);
    }
  });

  //mouseout handler
  map.data.addListener("mouseout", (event) => {
    map.data.revertStyle();
    infowindow.close(map);
  });
}

