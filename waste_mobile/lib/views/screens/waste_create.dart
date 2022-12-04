import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:get/get.dart';
import 'package:latlong2/latlong.dart';
import 'package:location/location.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/utils/contants.dart';
import 'package:waste_mobile/views/screens/picker_page.dart';
import 'package:waste_mobile/views/widgets/app_dropdown_input.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';
import 'package:waste_mobile/views/widgets/zoombuttons_plugin_option.dart';

class WasteCreate extends StatefulWidget {
  const WasteCreate({Key? key}) : super(key: key);

  @override
  State<WasteCreate> createState() => _WasteCreateState();
}

class _WasteCreateState extends State<WasteCreate> {
  final Location _locationService = Location();
  LocationData? _currentLocation;
  bool _liveUpdate = false;
  bool _permission = false;
  late final MapController _mapController;
  String? _serviceError = '';
  int interActiveFlags = InteractiveFlag.all;
  final AuthController _authManager = Get.find();
  final WasteController _wasteController = Get.put(WasteController());
  final pointSize = 20.0;
  final pointY = 100.0;
  LatLng? latLng;

  final _formKey = GlobalKey<FormState>();
  @override
  void initState() {
    super.initState();
    _mapController = MapController();
    // initLocationService();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      updatePoint(null, context);
    });
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
    } on PlatformException catch (e) {
      debugPrint(e.toString());
      if (e.code == 'PERMISSION_DENIED') {
        _serviceError = e.message;
      } else if (e.code == 'SERVICE_STATUS_ERROR') {
        _serviceError = e.message;
      }
      location = null;
    }
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
          LatLng(_currentLocation!.latitude!, _currentLocation!.longitude!);
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
            'Бүртгэх',
            style: TextStyle(fontSize: 25.0, fontWeight: FontWeight.w700),
          ),
        ),
        body: SafeArea(
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
                                  builder: (ctx) =>
                                      Icon(Icons.crop_free, size: pointSize),
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
                ),
                Form(
                  key: _formKey,
                  autovalidateMode: AutovalidateMode.onUserInteraction,
                  child: _RegisterForm(downwardIcon: downwardIcon),
                ),
                SizedBox(
                  height: 80,
                  width: width,
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: <Widget>[
                      ElevatedButton(
                        onPressed: () {
                          Get.to(const PickerPage());
                        },
                        child: const Text(
                          'Зураг, Видео',
                          style: TextStyle(
                              color: Colors.white,
                              fontWeight: FontWeight.w700,
                              fontSize: 18),
                        ),
                      ),
                      ElevatedButton(
                        onPressed: () {
                          if (_formKey.currentState?.validate() ?? false) {
                            print('valodate');
                          }
                        },
                        child: const Text(
                          'Хадгалах',
                          style: TextStyle(
                              color: Colors.white,
                              fontWeight: FontWeight.w700,
                              fontSize: 18),
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ));
  }
}

class _RegisterForm extends StatefulWidget {
  const _RegisterForm({
    Key? key,
    required this.downwardIcon,
  }) : super(key: key);

  final Icon downwardIcon;

  @override
  State<_RegisterForm> createState() => _RegisterFormState();
}

class _RegisterFormState extends State<_RegisterForm> {
  NameModel? aimagCity;
  NameModel? soumDistrict;
  NameModel? bagHoroo;
  TextEditingController addressCtr = TextEditingController();
  TextEditingController descriptionCtr = TextEditingController();
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(20.0),
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: <Widget>[
          AppDropdownInput<NameModel>(
            hintText: "Аймаг,Нийслэл:",
            options: Constants.aimagCities,
            value: aimagCity,
            onChanged: (NameModel? value) {
              setState(() {
                aimagCity = value;
              });
            },
            getLabel: (NameModel value) => value.name,
          ),
          const SizedBox(height: 20),
          AppDropdownInput<NameModel>(
            hintText: "Сум,Дүүрэг:",
            enabled: aimagCity != null,
            options: Constants.soumDistricts
                .where(
                    (element) => element.aimag_city_id == (aimagCity?.id ?? -1))
                .toList(),
            value: soumDistrict,
            onChanged: (NameModel? value) {
              setState(() {
                soumDistrict = value;
              });
            },
            getLabel: (NameModel value) => value.name,
          ),
          const SizedBox(height: 20),
          AppDropdownInput<NameModel>(
            hintText: "Баг,Хороо:",
            enabled: soumDistrict != null,
            value: bagHoroo,
            options: Constants.bagHoroos
                .where((element) =>
                    element.soum_district_id == (soumDistrict?.id ?? -1))
                .toList(),
            onChanged: (NameModel? value) {
              setState(() {
                bagHoroo = value;
              });
            },
            getLabel: (NameModel value) => value.name,
          ),
          const SizedBox(height: 20),
          TextFormField(
            controller: addressCtr,
            validator: (value) {
              return (value == null || value.isEmpty)
                  ? 'Хаяг тоот хоосон байна'
                  : null;
            },
            decoration: InputDecoration(
              contentPadding:
                  const EdgeInsets.symmetric(horizontal: 20.0, vertical: 15.0),
              labelText: 'Хаяг тоот:',
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(5.0),
              ),
            ),
          ),
          const SizedBox(height: 20),
          TextFormField(
            validator: (value) {
              return (value == null || value.isEmpty)
                  ? 'Тайлбар хоосон байна'
                  : null;
            },
            decoration: InputDecoration(
              contentPadding:
                  const EdgeInsets.symmetric(horizontal: 20.0, vertical: 15.0),
              labelText: 'Тайлбар:',
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(5.0),
              ),
            ),
            minLines: 3,
            maxLines: 10,
          ),
          const SizedBox(height: 20),
        ],
      ),
    );
  }
}
