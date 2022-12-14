import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:geolocator/geolocator.dart';
import 'package:latlong2/latlong.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';
import 'package:waste_mobile/views/widgets/zoombuttons_plugin_option.dart';

class LocationMap extends StatefulWidget {
  final Function(LatLng?) onChangeLocation;
  final double? latitude;
  final double? longitude;
  const LocationMap({
    Key? key,
    required this.onChangeLocation,
    this.latitude,
    this.longitude,
  }) : super(key: key);

  @override
  State<LocationMap> createState() => _LocationMapState();
}

class _LocationMapState extends State<LocationMap> {
  Position? _currentLocation;
  late final MapController _mapController;
  int interActiveFlags = InteractiveFlag.all;

  final pointSize = 20.0;
  final pointY = 100.0;
  LatLng? latLng;

  @override
  void initState() {
    super.initState();
    _mapController = MapController();
    // initLocationService();
    if (widget.latitude == null && widget.latitude == null) {
      _determinePosition();
    }
    WidgetsBinding.instance.addPostFrameCallback((_) {
      updatePoint(null, context);
    });
  }

  Future<Position> _determinePosition() async {
    bool serviceEnabled;
    LocationPermission permission;

    // Test if location services are enabled.
    serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) {
      // Location services are not enabled don't continue
      // accessing the position and request users of the
      // App to enable the location services.
      return Future.error('Location services are disabled.');
    }

    permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
      if (permission == LocationPermission.denied) {
        // Permissions are denied, next time you could try
        // requesting permissions again (this is also where
        // Android's shouldShowRequestPermissionRationale
        // returned true. According to Android guidelines
        // your App should show an explanatory UI now.
        return Future.error('Location permissions are denied');
      }
    }

    if (permission == LocationPermission.deniedForever) {
      // Permissions are denied forever, handle appropriately.
      return Future.error(
          'Location permissions are permanently denied, we cannot request permissions.');
    }

    // When we reach here, permissions are granted and we can
    // continue accessing the position of the device.
    final ss = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.medium);
    setState(() {
      _currentLocation = ss;
      final latlong =
          LatLng(_currentLocation!.latitude, _currentLocation!.longitude);
      widget.onChangeLocation(latlong);
      _mapController.move(latlong, _mapController.zoom);
    });
    return ss;
  }

  void updatePoint(MapEvent? event, BuildContext context) {
    final pointX = _getPointX(context);
    setState(() {
      latLng = _mapController.pointToLatLng(CustomPoint(pointX, pointY));
      if (latLng != null) widget.onChangeLocation(latLng);
    });
  }

  double _getPointX(BuildContext context) {
    return MediaQuery.of(context).size.width / 2;
  }

  @override
  Widget build(BuildContext context) {
    double width = MediaQuery.of(context).size.width;

    LatLng currentLatLng;

    if (_currentLocation != null) {
      currentLatLng =
          LatLng(_currentLocation!.latitude, _currentLocation!.longitude);
    } else {
      currentLatLng = LatLng(
        widget.latitude ?? 47.9173283,
        widget.longitude ?? 106.9247419,
      );
    }

    return TopContainer(
      padding: const EdgeInsets.all(0),
      height: 200,
      width: width,
      child: Stack(
        children: [
          FlutterMap(
            mapController: _mapController,
            options: MapOptions(
              onMapEvent: (event) {
                updatePoint(null, context);
              },
              center: currentLatLng,
              zoom: 15,
              minZoom: 3,
            ),
            nonRotatedChildren: const [
              FlutterMapZoomButtons(
                minZoom: 4,
                maxZoom: 19,
                mini: true,
                padding: 5,
                alignment: Alignment.topRight,
              ),
            ],
            children: [
              TileLayer(
                urlTemplate: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                userAgentPackageName: 'dev.fleaflet.flutter_map.example',
              ),
              if (latLng != null)
                MarkerLayer(
                  markers: [
                    Marker(
                      width: pointSize,
                      height: pointSize,
                      point: latLng!,
                      builder: (ctx) => Icon(Icons.crop_free, size: pointSize),
                    )
                  ],
                )
            ],
          ),
          Positioned(
              top: pointY - pointSize / 2,
              left: _getPointX(context) - pointSize / 2,
              child: Icon(Icons.crop_free, size: pointSize)),
          Positioned(
            right: 0,
            bottom: 0,
            child: FloatingActionButton(
              heroTag: 'cancel',
              mini: true,
              child: const Icon(Icons.my_location),
              onPressed: () => _determinePosition(),
            ),
          ),
        ],
      ),
    );
  }
}
