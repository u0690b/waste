import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:get/get.dart';
import 'package:latlong2/latlong.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/views/screens/Image_screen.dart';
import 'package:waste_mobile/views/screens/video_payer.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';
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
  late Waste waste;
  @override
  void initState() {
    super.initState();
    _mapController = MapController();
    waste = widget.waste;
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
                Column(
                  mainAxisSize: MainAxisSize.min,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: <Widget>[
                    ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title: const Text("Албан байгууллага, Иргэний овог нэр:"),
                      subtitle: Text(waste.name),
                    ),
                    ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title:
                          const Text("Байгууллага, ААН, Иргэний Овог регистр:"),
                      subtitle: Text(waste.register ?? ''),
                    ),
                    ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title: const Text("Үйл Ажиллагааны чиглэл:"),
                      subtitle: Text(waste.chiglel ?? ''),
                    ),
                    ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title: const Text("Хаяг тоот, утас:"),
                      subtitle: Text(waste.fullAddress()),
                    ),
                    ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title: const Text("Гаргасан зөрчилийн байдал"),
                      subtitle: Text(waste.description),
                    ),
                    ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title: const Text("Зөрчилийн Төрөл:"),
                      subtitle: Text(waste.reason.name),
                    ),
                    ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title:
                          const Text("Зөрчсөн хууль тогтоомжийн зүйл, заалт:"),
                      subtitle: Text(waste.zuilZaalt ?? ''),
                    ),
                    ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title: const Text("Гаргасан зөрчилийн байдал:"),
                      subtitle: Text(waste.description),
                    ),
                    ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title: const Text("Бүртгэсэн хүн:"),
                      subtitle: Text(waste.regUser.name),
                    ),
                    if (waste.resolveDesc != null)
                      ListTile(
                        dense: true,
                        style: ListTileStyle.drawer,
                        title: const Text("Шийдвэрлэсэн тэмэдэглэл:"),
                        subtitle: Text(waste.resolveDesc ?? ''),
                      ),
                    const SizedBox(height: 20),
                    const ListTile(
                      dense: true,
                      style: ListTileStyle.drawer,
                      title: Text('Хавсаргасан файл'),
                    ),
                    if (waste.video != null)
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 20),
                        child: ElevatedButton(
                            onPressed: () {
                              Get.dialog(MyVideoPlayer(url: waste.video!.path));
                            },
                            child: const Text('Бичлэг харах')),
                      ),
                    ImageScreen(galleryItems: waste.imgs),
                  ],
                ),
              ],
            ),
          ),
        ));
  }
}
