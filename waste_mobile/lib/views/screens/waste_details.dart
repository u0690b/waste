import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:geolocator/geolocator.dart';
import 'package:get/get.dart';
import 'package:latlong2/latlong.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';
import 'package:waste_mobile/views/widgets/my_text_field.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';
import 'package:waste_mobile/views/widgets/zoombuttons_plugin_option.dart';

class WasteDetails extends StatefulWidget {
  final int id;
  const WasteDetails({Key? key, required this.id}) : super(key: key);

  @override
  State<WasteDetails> createState() => _WasteDetailsState();
}

class _WasteDetailsState extends State<WasteDetails> {
  late final MapController _mapController;
  int interActiveFlags = InteractiveFlag.all;
  Position? _currentLocation;
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
        desiredAccuracy: LocationAccuracy.high);
    setState(() {
      _currentLocation = ss;
    });
    return ss;
  }

  void updatePoint(MapEvent? event, BuildContext context) {
    final pointX = _getPointX(context);
    setState(() {
      latLng = _mapController.pointToLatLng(CustomPoint(pointX, pointY));
    });
  }

  double _getPointX(BuildContext context) {
    return MediaQuery.of(context).size.width / 2;
  }

  @override
  Widget build(BuildContext context) {
    double width = MediaQuery.of(context).size.width;
    var downwardIcon = const Icon(
      Icons.keyboard_arrow_down,
      color: Colors.black54,
    );
    LatLng currentLatLng;

    // Until currentLocation is initially updated, Widget can locate to 0, 0
    // by default or store previous location value to show.
    if (_currentLocation != null) {
      currentLatLng =
          LatLng(_currentLocation!.latitude, _currentLocation!.longitude);
    } else {
      currentLatLng = LatLng(47.9173283, 106.9247419);
    }
    final markers = <Marker>[
      Marker(
        width: 10,
        height: 10,
        point: currentLatLng,
        builder: (ctx) => const Icon(Icons.pin_drop_outlined),
      ),
    ];
    return Scaffold(
        appBar: AppBar(
          leading: Padding(
            padding: const EdgeInsets.all(8.0),
            child: MyBackButton(),
          ),
          backgroundColor: LightColors.kDarkYellow,
          foregroundColor: LightColors.kDarkBlue,
          title: const Text(
            'Хог хаягдал',
            style: TextStyle(fontSize: 25.0, fontWeight: FontWeight.w700),
          ),
        ),
        body: FutureBuilder(
          builder: (context, snapshot) {
            return SafeArea(
              child: SingleChildScrollView(
                child: Column(
                  children: <Widget>[
                    TopContainer(
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
                              zoom: 18,
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
                                urlTemplate:
                                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                                userAgentPackageName:
                                    'dev.fleaflet.flutter_map.example',
                              ),
                              if (latLng != null)
                                MarkerLayer(
                                  markers: [
                                    Marker(
                                      width: pointSize,
                                      height: pointSize,
                                      point: latLng!,
                                      builder: (ctx) => Icon(Icons.crop_free,
                                          size: pointSize),
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
                    ),
                    Padding(
                      padding: const EdgeInsets.all(20.0),
                      child: Column(
                        mainAxisSize: MainAxisSize.min,
                        children: <Widget>[
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: <Widget>[
                              Expanded(
                                  child: MyTextField(
                                controller:
                                    TextEditingController(text: "Улаанбаатар"),
                                label: 'Аймаг,Нийслэл:',
                                icon: downwardIcon,
                              )),
                            ],
                          ),
                          MyTextField(
                            controller: TextEditingController(text: "СХД"),
                            label: 'Сум,Дүүрэг:',
                            icon: downwardIcon,
                          ),
                          MyTextField(
                            controller: TextEditingController(text: "6-хороо"),
                            label: 'Баг,Хороо:',
                            icon: downwardIcon,
                          ),
                          MyTextField(
                            controller:
                                TextEditingController(text: "Номингийн урд"),
                            label: 'Хаяг тоот:',
                          ),
                          const SizedBox(height: 20),
                          MyTextField(
                            controller: TextEditingController(
                                text:
                                    "Номингийн үүдэнд их хэмжээний гутал шатаасан"),
                            label: 'Тайлбар',
                            minLines: 3,
                            maxLines: 10,
                          ),
                          const SizedBox(height: 20),
                          const Text('Хавсаргасан Файл'),
                          SizedBox(
                            height: 200,
                            width: Get.width,
                            child: Row(
                              children: [
                                Image.network(
                                    width: Get.width / 2.4,
                                    fit: BoxFit.cover,
                                    'https://cdn-bgcpe.nitrocdn.com/tapIsOYLQITMVlpOMSyRVnxukdutbLtB/assets/static/optimized/rev-b4e273a/wp-content/uploads/2021/01/33139-768x814.jpg'),
                                Image.network(
                                    width: Get.width / 2.4,
                                    fit: BoxFit.cover,
                                    'https://u4d2z7k9.rocketcdn.me/wp-content/uploads/2020/07/WasteManagement9.png')
                              ],
                            ),
                          )
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            );
          },
        ));
  }
}
