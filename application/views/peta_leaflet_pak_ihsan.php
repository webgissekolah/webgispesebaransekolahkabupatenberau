<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/js/leaflet-search/dist/leaflet-search.min.css" />
<div class="content">
	<div id="map" style="width: 100%; height: 530px; color:black;"></div>
</div>
<script src="<?=base_url()?>/assets/js/leaflet-search/dist/leaflet-search.src.js"></script>
<script>
	//var indonesia = new L.LayerGroup();
	var batasadm = new L.LayerGroup();
	var titiksd = new L.LayerGroup();
	var titiksmp = new L.LayerGroup();


	var map = L.map('map', {
			/*center: [-1.7912605, 116.42311],*/
			center: [1.997275, 117.594519],
			zoom: 8,
			zoomControl: false,
			layers: []
		}

	);


	var GoogleRoads = new L.TileLayer('https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}', {
			opacity: 1.0,
			attribution: 'WebGIS'
		}

	);

	var GoogleMaps = new L.TileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
			opacity: 1.0,
			attribution: 'WebGIS'
		}

	);

	var Esri_NatGeoWorldMap = L.tileLayer(
		'https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', {
			attribution: 'Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC',
			maxZoom: 16
		}

	);

	var GoogleSatelliteHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
			maxZoom: 22,
			attribution: 'WebGIS'
		}

	).addTo(map);

	var baseLayers = {
		'Google Satellite Hybrid': GoogleSatelliteHybrid,
		'Esri National Geography': Esri_NatGeoWorldMap,
		'Google Maps': GoogleMaps,
		'Google Roads': GoogleRoads
	}

	;

	var groupedOverlays = {
		'Pilihan Layer': {
			'Batas Kecamatan Berau': batasadm,
			'Sekolah Dasar (SD)': titiksd,
			'Sekolah Menengah Pertama (SMP)': titiksmp
		}

	}


	L.control.groupedLayers(baseLayers, groupedOverlays, {
			collapsed: true
		}

	).addTo(map);

	var osmUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
	var osmAttrib = 'Map data &copy; OpenStreetMap contributors';

	var osm2 = new L.TileLayer(osmUrl, {
			minZoom: 0,
			maxZoom: 13,
			attribution: osmAttrib
		}

	);

	var rect1 = {
		color: "#ff1100",
		weight: 3
	}

	;

	var rect2 = {
		color: "#0000AA",
		weight: 1,
		opacity: 0,
		fillOpacity: 0
	}

	;

	var miniMap = new L.Control.MiniMap(osm2, {
			toggleDisplay: true,
			position: "bottomright",
			aimingRectOptions: rect1,
			shadowRectOptions: rect2
		}

	).addTo(map);

	//L.Control.geocoder({position :"topleft", collapsed:true}).addTo(map);
	L.control.search({
			layer: titiksd,
			initial: false,
			propertyName: 'namasklh',
			position: "topleft",
			// collapsed:true
			//buildTip: function(text, val) {
			//	var type = val.layer.features.properties.jenis;
			//	return '<a href="#" class="'+type+'">'+text+'<b>'+type+'</b></a>';
			//}
		}

	).addTo(map);

	/* GPS enabled geolocation control set to follow the user's location */
	var locateControl = L.control.locate({

			position: "topleft",
			drawCircle: true,
			follow: true,
			setView: true,
			keepCurrentZoomLevel: true,
			markerStyle: {
				weight: 1,
				opacity: 0.8,
				fillOpacity: 0.8
			}

			,

			circleStyle: {
				weight: 1,
				clickable: false
			}

			,

			icon: "fa fa-location-arrow",
			metric: false,
			strings: {
				title: "My location",
				popup: "You are within {distance} {unit} from this point",
				outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
			}

			,

			locateOptions: {
				maxZoom: 18,
				watch: true,
				enableHighAccuracy: true,
				maximumAge: 10000,
				timeout: 10000
			}
		}

	).addTo(map);

	var zoom_bar = new L.Control.ZoomBar({
			position: 'topleft'
		}

	).addTo(map);

	L.control.coordinates({
			position: "bottomleft",
			decimals: 2,
			decimalSeperator: ",",
			labelTemplateLat: "Latitude: {y}",
			labelTemplateLng: "Longitude: {x}"
		}

	).addTo(map);

	var north = L.control({
			position: "bottomleft"
		}

	);

	north.onAdd = function (map) {
		var div = L.DomUtil.create("div", "info legend");
		div.innerHTML = '<img src="<?=base_url()?>assets/north-arrow.png">';
		return div;
	}

	north.addTo(map);


	/*var markerrio = L.icon({
	iconUrl: 'marker.png',
	iconSize: [38, 95],
	iconAnchor: [2, 117],
	popupAnchor: [2, 117]
	});*/

	/*L.marker([2, 117], {icon: markerrio}).addTo(map);*/

	var styleku = {
		"color": "black",
		"weight": 3
	}

	function popUp(f, l) {
		var out = [];

		if (f.properties) {
			for (key in f.properties) {
				out.push(key + ": " + f.properties[key]);
			}

			l.bindPopup(out.join("<br />"));
		}
	}

	/*var jsonTest = new L.GeoJSON.AJAX(["<?=base_url()?>/assets/batascamat.geojson"],{onEachFeature:popUp, style:styleku}).addTo(batasadm);*/
	$.getJSON("<?=base_url()?>/assets/batascamat.geojson", function (kode) {
			geoLayer = L.geoJson(kode, {
					style: function (feature) {
							var fillColor,
								kode = feature.properties.kode;
							if (kode > 21) fillColor = "#006837";
							else if (kode > 20) fillColor = "#fec44f"
							else if (kode > 19) fillColor = "#c2e699"
							else if (kode > 18) fillColor = "#fee0d2"
							else if (kode > 17) fillColor = "#756bb1"
							else if (kode > 16) fillColor = "#8c510a"
							else if (kode > 15) fillColor = "#01665e"
							else if (kode > 14) fillColor = "#e41a1c"
							else if (kode > 13) fillColor = "#636363"
							else if (kode > 12) fillColor = "#762a83"
							else if (kode > 11) fillColor = "#1b7837"
							else if (kode > 10) fillColor = "#d53e4f"
							else if (kode > 9) fillColor = "#67001f"
							else if (kode > 8) fillColor = "#c994c7"
							else if (kode > 7) fillColor = "#fdbb84"
							else if (kode > 6) fillColor = "#dd1c77"
							else if (kode > 5) fillColor = "#3182bd"
							else if (kode > 4) fillColor = "#f03b20"
							else if (kode > 3) fillColor = "#31a354";
							else if (kode > 2) fillColor = "#78c679";
							else if (kode > 1) fillColor = "#7abaac";
							else if (kode > 0) fillColor = "#ffffcc";
							else fillColor = "#f7f7f7"; // no data

							return {
								color: "#999",
								weight: 1,
								fillColor: fillColor,
								fillOPacity: .6
							}

							;
						}

						,

					onEachFeature: function (feature, layer) {

						layer.bindPopup(feature.properties.KECAMATAN.totalSD),
							that = this;

						layer.on('mouseover', function (e) {
								this.setStyle({
										weight: 4,
										color: '#32a89d',
										dashArray: '',
										fillOPacity: 0.8,


									}

								);

								if (!L.Browser.ie && !L.Browser.opera) {
									layer.bringToFront();
								}

								infop.update(layer.feature.properties);
							}

						);

						layer.on('mouseout', function (e) {
								this.setStyle({
										weight: 0,
										color: '#32a89d',
										dashArray: '',
										fillOpacity: 0.3
									}

								);
							}

						);
					}

				}

			).addTo(batasadm);



		}

	);

	$.getJSON("<?=base_url()?>/assets/pointoSD.geojson", function (data2) {
			geoLayer = L.geoJson(data2, {
					onEachFeature: function (feature, layer) {

						layer.bindPopup("<strong>" + feature.properties.namasklh + "</strong>" + "<br>" +
								feature.properties.alamat),
							that = this;

						layer.on('mouseover', function (e) {
								this.setStyle({}

								);

								if (!L.Browser.ie && !L.Browser.opera) {
									layer.bringToFront();
								}

								infop.update(layer.feature.properties);
							}

						);

						layer.on('mouseout', function (e) {
								this.setStyle({}

								);
							}

						);
					}


				}

			).addTo(titiksd);

		}

	);

	$.getJSON("<?=base_url()?>/assets/pointSMP.geojson", function (data2) {
			geoLayer = L.geoJson(data2, {
					onEachFeature: function (feature, layer) {

						layer.bindPopup("<strong>" + feature.properties.namasklh + "</strong>" + "<br>" +
								feature.properties.alamat),
							that = this;

						layer.on('mouseover', function (e) {
								this.setStyle({}

								);

								if (!L.Browser.ie && !L.Browser.opera) {
									layer.bringToFront();
								}

								infop.update(layer.feature.properties);
							}

						);

						layer.on('mouseout', function (e) {
								this.setStyle({}

								);
							}

						);
					}


				}

			).addTo(titiksmp);

		}

	);

	//pencarian


	//end pencarian

</script>
