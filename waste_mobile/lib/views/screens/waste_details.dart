import 'dart:async';

import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/attached_file.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/views/screens/Image_screen.dart';
import 'package:waste_mobile/views/screens/video_payer.dart';
import 'package:waste_mobile/views/screens/waste_allocation.dart';
import 'package:waste_mobile/views/screens/waste_resolve.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';

class WasteDetails extends StatefulWidget {
  final Waste waste;
  final IPaginationModel<Waste>? wasteController;
  const WasteDetails({Key? key, required this.waste, this.wasteController})
      : super(key: key);

  @override
  State<WasteDetails> createState() => _WasteDetailsState();
}

class _WasteDetailsState extends State<WasteDetails> {
  final Completer<GoogleMapController> _mapController =
      Completer<GoogleMapController>();
  MapType mapType = MapType.normal;
  final pointSize = 20.0;
  final pointY = 100.0;
  LatLng? latLng;
  late Waste waste;
  late CameraPosition _kGooglePlex;
  @override
  void initState() {
    super.initState();

    waste = widget.waste;
    _kGooglePlex = CameraPosition(
      target: LatLng(widget.waste.lat.toDouble(), widget.waste.long.toDouble()),
      zoom: 14.4746,
    );
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
          child: Column(
            children: <Widget>[
              TopContainer(
                padding: const EdgeInsets.all(0),
                height: 200,
                width: width,
                child: Stack(
                  children: [
                    GoogleMap(
                      mapType: mapType,
                      initialCameraPosition: _kGooglePlex,
                      onMapCreated: (GoogleMapController controller) {
                        _mapController.complete(controller);
                      },
                      markers: [
                        Marker(
                          markerId: MarkerId("1"),
                          position: LatLng(widget.waste.lat.toDouble(),
                              widget.waste.long.toDouble()),
                        )
                      ].toSet(),
                    ),
                    Positioned(
                      right: 5,
                      child: ElevatedButton(
                        style: ElevatedButton.styleFrom(
                            padding: EdgeInsets.all(0)),
                        child: Icon(Icons.map),
                        onPressed: () {
                          setState(() {
                            mapType = mapType == MapType.normal
                                ? MapType.satellite
                                : MapType.normal;
                          });
                        },
                      ),
                    ),
                  ],
                ),
              ),
              Expanded(
                child: SingleChildScrollView(
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: <Widget>[
                      ListTile(
                        dense: true,
                        style: ListTileStyle.drawer,
                        title:
                            const Text("Албан байгууллага, Иргэний овог нэр:"),
                        subtitle: Text(waste.name),
                      ),
                      ListTile(
                        dense: true,
                        style: ListTileStyle.drawer,
                        title: const Text(
                            "Байгууллага, ААН, Иргэний Овог регистр:"),
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
                        title: const Text("Гаргасан зөрчлийн байдал"),
                        subtitle: Text(waste.description),
                      ),
                      ListTile(
                        dense: true,
                        style: ListTileStyle.drawer,
                        title: const Text("Зөрчлийн төрөл:"),
                        subtitle: Text(waste.reason.name),
                      ),
                      ListTile(
                        dense: true,
                        style: ListTileStyle.drawer,
                        title: const Text(
                            "Зөрчсөн хууль тогтоомжийн зүйл, заалт:"),
                        subtitle: Text(waste.zuilZaalt ?? ''),
                      ),
                      ListTile(
                        dense: true,
                        style: ListTileStyle.drawer,
                        title: const Text("Гаргасан зөрчлийн байдал:"),
                        subtitle: Text(waste.description),
                      ),
                      ListTile(
                        dense: true,
                        style: ListTileStyle.drawer,
                        title: const Text("Бүртгэсэн хүн:"),
                        subtitle: Text(waste.regUser.name),
                      ),
                      if (waste.reg_at != null)
                        ListTile(
                          dense: true,
                          style: ListTileStyle.drawer,
                          title: const Text("Үүсгэсэн огноо:"),
                          subtitle: Text(waste.reg_at!.toString()),
                        ),
                      if (waste.createdAt != null)
                        ListTile(
                          dense: true,
                          style: ListTileStyle.drawer,
                          title: const Text("Илгээсэн огноо:"),
                          subtitle: Text(waste.createdAt!.toString()),
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
                                Get.dialog(
                                    MyVideoPlayer(url: waste.video!.path));
                              },
                              child: const Text('Бичлэг харах')),
                        ),
                      ImageScreen(galleryItems: waste.imgs),
                      if (waste.comfUser != null)
                        ListTile(
                          dense: true,
                          style: ListTileStyle.drawer,
                          title:
                              const Text("Хуваарилагдсан / Шийдвэрлэсэн хүн:"),
                          subtitle: Text(waste.comfUser!.name),
                        ),
                      if (waste.resolve != null)
                        ListTile(
                          dense: true,
                          style: ListTileStyle.drawer,
                          title: const Text("Шийдвэрийн төрөл:"),
                          subtitle: Text(waste.resolve!.name),
                        ),
                      if (waste.resolveDesc != null)
                        ListTile(
                          dense: true,
                          style: ListTileStyle.drawer,
                          title: const Text("Шийдвэрлэсэн тэмэдэглэл:"),
                          subtitle: Text(waste.resolveDesc ?? ''),
                        ),
                      if (waste.resolveImage != null)
                        ListTile(
                          dense: true,
                          style: ListTileStyle.drawer,
                          title: const Text("Шийдвэрлэсэн зураг:"),
                          subtitle: ImageScreen(galleryItems: [
                            AttachedFile(
                                id: 0,
                                register_id: 0,
                                path: waste.resolveImage!)
                          ]),
                        ),
                      Padding(
                        padding: const EdgeInsets.all(8.0),
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.end,
                          children: [
                            if (widget.waste.statusId != 4 &&
                                (['mha'].contains(AuthController.user!.roles) ||
                                    widget.waste.comfUserId ==
                                        AuthController.user!.id))
                              ElevatedButton(
                                onPressed: () async {
                                  final ret = await Get.to<bool?>(() =>
                                      WasteResolve(
                                          waste: widget.waste,
                                          wasteController:
                                              widget.wasteController
                                                  as WasteController));
                                  if (ret == true) {
                                    Get.back();
                                  }
                                },
                                child: Text('Шийдвэрлэх'),
                              ),
                            if ((['mha'].contains(AuthController.user!.roles) ||
                                    widget.waste.comfUserId ==
                                        AuthController.user!.id) &&
                                widget.waste.statusId != 4) ...[
                              SizedBox(width: 10),
                              ElevatedButton(
                                onPressed: () async {
                                  final ret = await showDialog(
                                      context: context,
                                      builder: (BuildContext context) {
                                        return WasteAllocation(
                                          waste: widget.waste,
                                          wasteController:
                                              widget.wasteController
                                                  as WasteController,
                                        );
                                      });

                                  if (ret == true) {
                                    Get.back();
                                  }
                                },
                                child: Text('Шилжүүлэх'),
                              ),
                            ]
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ));
  }
}
