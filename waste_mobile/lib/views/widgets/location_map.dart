import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import 'package:location/location.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';
import 'package:waste_mobile/views/widgets/zoombuttons_plugin_option.dart';

class LocationMap extends StatefulWidget {
  final Function(LatLng?) onChangeLocation;
  final double? latitude;
  final double? longitude;
  const LocationMap({
    Key? key,
    required this.onChangeLocation,
    this.latitude = 47.9173283,
    this.longitude = 106.9247419,
  }) : super(key: key);

  @override
  State<LocationMap> createState() => _LocationMapState();
}

class _LocationMapState extends State<LocationMap> {
  final Location _locationService = Location();
  LocationData? _currentLocation;
  bool _liveUpdate = false;
  bool _permission = false;
  late final MapController _mapController;
  String? _serviceError;
  int interActiveFlags = InteractiveFlag.all;

  final pointSize = 20.0;
  final pointY = 100.0;
  LatLng? latLng;

  @override
  void initState() {
    super.initState();
    _mapController = MapController();
    // initLocationService();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      updatePoint(null, context);
    });
    initLocationService();
  }

  void initLocationService() async {
    _liveUpdate = true;
    await _locationService.changeSettings(
      accuracy: LocationAccuracy.high,
      interval: 1000,
    );
    LocationData? currentLocation;
    LocationData? location;
    bool serviceEnabled;
    bool serviceRequestResult;

    try {
      serviceEnabled = await _locationService.serviceEnabled();

      if (serviceEnabled) {
        final permission = await _locationService.requestPermission();
        _permission = permission == PermissionStatus.granted;

        if (_permission) {
          location = await _locationService.getLocation();
          currentLocation = location;
          _locationService.onLocationChanged
              .listen((LocationData result) async {
            if (mounted) {
              setState(() {
                currentLocation = result;

                // If Live Update is enabled, move map center
                if (_liveUpdate) {
                  _mapController.move(
                      LatLng(currentLocation!.latitude!,
                          currentLocation!.longitude!),
                      _mapController.zoom);
                  _liveUpdate = false;
                }
              });
            }
          });
        }
      } else {
        serviceRequestResult = await _locationService.requestService();
        if (serviceRequestResult) {
          initLocationService();
          return;
        }
      }
      _serviceError = null;
    } on PlatformException catch (e) {
      debugPrint(e.toString());
      if (e.code == 'PERMISSION_DENIED') {
        _serviceError = e.message;
      } else if (e.code == 'SERVICE_STATUS_ERROR') {
        _serviceError = e.message;
      }
      _serviceError = e.message;
      location = null;
    }
  }

  void updatePoint(MapEvent? event, BuildContext context) {
    final pointX = _getPointX(context);
    setState(() {
      latLng = _mapController.pointToLatLng(CustomPoint(pointX, pointY));
      widget.onChangeLocation(latLng);
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
          LatLng(_currentLocation!.latitude!, _currentLocation!.longitude!);
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
              onPressed: () => initLocationService(),
            ),
          ),
        ],
      ),
    );
  }
}
