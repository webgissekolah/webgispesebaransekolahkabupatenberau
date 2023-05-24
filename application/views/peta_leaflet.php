<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/js/leaflet-search/dist/leaflet-search.min.css" />

<div class="content">
	<div id="map" style="width: 100%; height: 530px; color:black;"></div>
</div>

<script src="<?=base_url()?>/assets/js/leaflet-search/dist/leaflet-search.src.js"></script>

<script>
	var indonesia = new L.layerGroup();
	var sd = new L.LayerGroup();
	var smp = new L.LayerGroup();

	var map = L.map('map', {
		center: [1.997275, 117.594519],
		zoom: 8,
		zoomControl: false,
		layers: []
	});
	var GoogleRoads = new L.TileLayer('https://mt1.google.com/vt/lyrs=h&x={x}&y={y}&z={z}', {
		opacity: 1.0,
		attribution: 'WebGIS'
	});
	var GoogleMaps = new L.TileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
		opacity: 1.0,
		attribution: 'WebGIS'
	});

	var Esri_NatGeoWorldMap = L.tileLayer(
		'https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', {
			attribution: 'Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC',
			maxZoom: 16
		});
	var GoogleSatelliteHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
		maxZoom: 22,
		attribution: 'WebGIS'
	}).addTo(map);

	var baseLayers = {
		'Google Satellite Hybrid': GoogleSatelliteHybrid,
		'Esri National Geography': Esri_NatGeoWorldMap,
		'Google Maps': GoogleMaps,
		'Google Roads': GoogleRoads
	};

	var groupedOverlays = {
		'Pilihan Layer': {
			'Batas Kecamatan Berau': indonesia,
			'Sekolah Dasar (SD)': sd,
			'Sekolah Menengah Pertama (SMP)': smp
		}
	};
	L.control.groupedLayers(baseLayers, groupedOverlays, {
		collapsed: true
	}).addTo(map);

	var osmUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
	var osmAttrib = 'Map data &copy; OpenStreetMap contributors';
	var osm2 = new L.TileLayer(osmUrl, {
		minZoom: 0,
		maxZoom: 13,
		attribution: osmAttrib
	});
	var rect1 = {
		color: "#ff1100",
		weight: 3
	};
	var rect2 = {
		color: "#0000AA",
		weight: 1,
		opacity: 0,
		fillOpacity: 0
	};
	var miniMap = new L.Control.MiniMap(osm2, {
		toggleDisplay: true,
		position: "bottomright",
		aimingRectOptions: rect1,
		shadowRectOptions: rect2
	}).addTo(map);


	L.control.search({
		layer: sd,
		initial: false,
		propertyName: 'namasklh',
		position: "topleft",
        layer: smp,
        initial: false,
        propertyName: 'namasklh',
        position: "topleft",

	}).addTo(map);

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
		},
		circleStyle: {
			weight: 1,
			clickable: false
		},
		icon: "fa fa-location-arrow",
		metric: false,
		strings: {
			title: "My location",
			popup: "You are within {distance} {unit} from this point",
			outsideMapBoundsMsg: "You seem located outside the boundaries of the map"
		},
		locateOptions: {
			maxZoom: 18,
			watch: true,
			enableHighAccuracy: true,
			maximumAge: 10000,
			timeout: 10000
		}
	}).addTo(map);

	var zoom_bar = new L.Control.ZoomBar({
		position: 'topleft'
	}).addTo(map);

	L.control.coordinates({
		position: "bottomleft",
		decimals: 2,
		decimalSeperator: ",",
		labelTemplateLat: "Latitude: {y}",
		labelTemplateLng: "Longitude: {x}"
	}).addTo(map);
	var north = L.control({
		position: "bottomleft"
	});
	north.onAdd = function (map) {
		var div = L.DomUtil.create("div", "info legend");
		div.innerHTML = '<img src="<?=base_url()?>assets/north-arrow.png">';
		return div;
	}
	north.addTo(map);

	$.getJSON("<?=base_url()?>/assets/batascamat.geojson", function (data) {

		L.geoJson(data, {
			style: function (feature) {
				var fillColor = feature.properties.warna;

				return {
					color: "#999",
					weight: 1,
					fillColor: fillColor,
					fillOpacity: .6
				};
			},
			onEachFeature: function (feature, layer) {
				layer.bindPopup(feature.properties.KECAMATAN),
					that = this;
				layer.on('mouseover', function (e) {
					this.setStyle({
						weight: 2,
						color: '#32a89d',
						dashArray: '',
						fillOpacity: 0.8
					});

					if (!L.Browser.ie && !L.Browser.opera) {
						layer.bringToFront();
					}

					info.ipdate(layer.feature.properties);
				});
				layer.on('mouseout', function (e) {
					this.setStyle({
						weight: 2,
						color: '#32a89d',
						dashArray: '',
						fillOpacity: 0.8
					});
				});
			}
		}).addTo(indonesia);
	});

	$.getJSON("<?=base_url()?>/assets/pointoSD.geojson", function (data) {
		geoLayer = L.geoJson(data, {
			onEachFeature: function (feature, layer) {

				layer.bindPopup("<strong>" + "Nama Sekolah : " + feature.properties.namasklh +
						"</strong>" + "<br>" + "Alamat Sekolah : "+ feature.properties.alamat + "</strong>" + "<br>" +"Kecamatan : "+
						feature.properties.kecamatan + "</strong>" + "<br>" +"Status Sekolah : "+ feature.properties.jenis
						),
					that = this;
				layer.on('mouseover', function (e) {
					this.setStyle({});
					if (!L.Browser.ie && !L.Browser.opera) {
						layer.bringToFront();
					}
					infop.update(layer.feature.properties);
				});
				layer.on('mouseout', function (e) {
					this.setStyle({

					});
				});
			}


		}).addTo(sd);

	});

	$.getJSON("<?=base_url()?>/assets/smptitik.geojson", function (data3) {
		geoLayer = L.geoJson(data3, {
			onEachFeature: function (feature, layer) {

				layer.bindPopup("<strong>" + "Nama Sekolah : " + feature.properties.namasklh +
						"</strong>" + "<br>" + "Alamat Sekolah : "+ feature.properties.alamat + "</strong>" + "<br>" +"Kecamatan : "+
						feature.properties.kecamatan + "</strong>" + "<br>" +"Status Sekolah : "+ feature.properties.jenis
						),

				that = this;
				layer.on('mouseover', function (e) {
					this.setStyle({});
					if (!L.Browser.ie && !L.Browser.opera) {
						layer.bringToFront();
					}
					infop.update(layer.feature.properties);
				});
				layer.on('mouseout', function (e) {
					this.setStyle({

					});
				});
			}

		}).addTo(smp);


	});

</script>
