import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:get/get.dart';
import 'package:latlong2/latlong.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';
import 'package:waste_mobile/views/widgets/my_text_field.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';
import 'package:waste_mobile/views/widgets/zoombuttons_plugin_option.dart';

class WasteDetails extends StatefulWidget {
  final Waste waste;
  const WasteDetails({Key? key, required this.waste}) : super(key: key);

  @override
  State<WasteDetails> createState() => _WasteDetailsState();
}

class _WasteDetailsState extends State<WasteDetails> {
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
    WidgetsBinding.instance.addPostFrameCallback((_) {
      updatePoint(null, context);
    });
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
                          center: LatLng(
                            widget.waste.lat.toDouble(),
                            widget.waste.long.toDouble(),
                          ),
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
                                  builder: (ctx) =>
                                      Icon(Icons.crop_free, size: pointSize),
                                )
                              ],
                            )
                        ],
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
                                'https://u4d2z7k9.rocketcdn.me/wp-content/uploads/2020/07/WasteManagement9.png'),
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
        ));
  }
}
