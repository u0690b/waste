import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';

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
  late final GoogleMapController? controller;
  late LatLng latlong;

  MapType _mapType = MapType.normal;

  @override
  void initState() {
    super.initState();

    if (widget.latitude == null || widget.longitude == null) {
      _determinePosition();
    }
    latlong = LatLng(
      widget.latitude ?? 47.9173283,
      widget.longitude ?? 106.9247419,
    );
  }

  void _onMapCreated(GoogleMapController controller) {
    this.controller = controller;
  }

  Widget _mapTypeCycler() {
    final MapType nextType =
        MapType.values[(_mapType.index + 1) % MapType.values.length];
    return ElevatedButton(
      style: ElevatedButton.styleFrom(
          elevation: 2,
          backgroundColor: Colors.white70,
          minimumSize: Size(36, 36),
          fixedSize: Size(36, 36),
          padding: EdgeInsets.all(0)),
      child: Icon(
        Icons.map,
        color: Colors.black,
      ),
      onPressed: () {
        setState(() {
          _mapType =
              _mapType == MapType.normal ? MapType.satellite : MapType.normal;
        });
      },
    );
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
      final latlong = LatLng(ss.latitude, ss.longitude);
      widget.onChangeLocation(latlong);
      controller?.moveCamera(
        CameraUpdate.newCameraPosition(
          CameraPosition(target: latlong, zoom: 14.0),
        ),
      );
    });
    return ss;
  }

  ScreenCoordinate? ss;
  @override
  Widget build(BuildContext context) {
    double width = MediaQuery.of(context).size.width;
    Map<MarkerId, Marker> markers = <MarkerId, Marker>{};

    return TopContainer(
      padding: const EdgeInsets.all(0),
      height: 200,
      width: width,
      child: Stack(
        children: [
          GoogleMap(
            mapType: _mapType,
            myLocationEnabled: true,
            onMapCreated: _onMapCreated,
            initialCameraPosition: CameraPosition(target: latlong, zoom: 11.0),
            markers: Set<Marker>.of(markers.values),
            onCameraMove: (position) async {
              widget.onChangeLocation(position.target);
              print(position.target);
            },
          ),
          Positioned(
            top: 100 - 9,
            left: width / 2 - 9,
            child: Icon(
              Icons.crop_free,
              size: 18,
              color: Colors.white,
            ),
          ),
          Positioned(
            top: 100 - 7,
            left: width / 2 - 7,
            child: Icon(
              Icons.crop_free,
              size: 14,
              color: Colors.white,
            ),
          ),
          Positioned(
            top: 100 - 8,
            left: width / 2 - 8,
            child: Icon(
              Icons.crop_free,
              size: 16,
              color: Colors.red,
            ),
          ),
          Positioned(
            top: 0,
            left: 0,
            child: _mapTypeCycler(),
          )
        ],
      ),
    );
  }
}
