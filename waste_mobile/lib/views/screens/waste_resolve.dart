import 'dart:io';

import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/utils/contants.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';
import 'package:waste_mobile/views/widgets/future_alert_dialog.dart';

class WasteResolve extends StatefulWidget {
  final Waste waste;
  final WasteController? wasteController;
  const WasteResolve({Key? key, required this.waste, this.wasteController})
      : super(key: key);

  @override
  State<WasteResolve> createState() => _WasteResolveState();
}

class _WasteResolveState extends State<WasteResolve> {
  String? resolve_desc;
  int? resolve_id;

  XFile? pickedFile;

  final _formKey = GlobalKey<FormState>();
  @override
  void initState() {
    super.initState();
    resolve_desc = widget.waste.resolveDesc ?? "";
    resolve_id = widget.waste.resolveId;
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
        child: Form(
          key: _formKey,
          autovalidateMode: AutovalidateMode.onUserInteraction,
          child: SingleChildScrollView(
            child: Padding(
                padding: const EdgeInsets.all(15.0),
                child: Column(
                  children: [
                    DropdownButtonFormField(
                        validator: (p0) => p0 == null ? 'Заавал бөглөх' : null,
                        value: resolve_id,
                        decoration: InputDecoration(
                          labelText: "Шийдвэрийн төрөл:",
                          contentPadding: const EdgeInsets.symmetric(
                              horizontal: 20.0, vertical: 15.0),
                          border: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(5.0)),
                        ),
                        items: Constants.resolves
                            .map((e) => DropdownMenuItem(
                                  value: e.id,
                                  child: Text(e.name),
                                ))
                            .toList(),
                        onChanged: (int? value) => resolve_id = value),
                    const SizedBox(height: 20),
                    //Шийдвэрлэсэн байдал
                    TextFormField(
                      maxLength: 1000,
                      maxLines: 5,
                      validator: (p0) =>
                          p0 == null || p0.isEmpty ? 'Заавал бөглөх' : null,
                      initialValue: resolve_desc,
                      onChanged: (value) => resolve_desc = value,
                      decoration: InputDecoration(
                        contentPadding: const EdgeInsets.symmetric(
                            horizontal: 20.0, vertical: 15.0),
                        labelText: 'Шийдвэрлэсэн байдал',
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(5.0),
                        ),
                      ),
                    ),
                    if (pickedFile != null) Image.file(File(pickedFile!.path)),
                    Row(
                        mainAxisAlignment: MainAxisAlignment.spaceAround,
                        children: [
                          ElevatedButton(
                            onPressed: () {
                              Get.defaultDialog(
                                  title: "",
                                  middleText: "Зураг сонгох",
                                  actions: [
                                    ElevatedButton(
                                      onPressed: () {
                                        ImagePicker()
                                            .pickImage(
                                                source: ImageSource.camera,
                                                maxWidth: 1500,
                                                maxHeight: 1500,
                                                imageQuality: 80)
                                            .then((value) {
                                          setState(() {
                                            pickedFile = value;
                                          });
                                          Get.back();
                                        });
                                      },
                                      child: Text('Камер'),
                                    ),
                                    ElevatedButton(
                                        onPressed: () {
                                          ImagePicker()
                                              .pickImage(
                                                  source: ImageSource.gallery,
                                                  maxWidth: 1500,
                                                  maxHeight: 1500,
                                                  imageQuality: 80)
                                              .then((value) {
                                            setState(() {
                                              pickedFile = value;
                                            });
                                            Get.back();
                                          });
                                        },
                                        child: Text('Зургийн сан'))
                                  ]);
                            },
                            child: Text('Зураг хавсаргах'),
                          ),
                          ElevatedButton(
                            onPressed: () async {
                              if (_formKey.currentState?.validate() ?? false) {
                                await futureAlertDialog(
                                  context: context,
                                  futureStream:
                                      widget.wasteController!.solveWaste(
                                    id: widget.waste.id,
                                    resolve_desc: resolve_desc!,
                                    resolve_id: resolve_id!,
                                    pickedFile: pickedFile,
                                  ),
                                  autoCloseSec: 1,
                                );

                                Get.back(result: true);
                              }
                            },
                            child: Text('Хадгалах'),
                          )
                        ]),
                  ],
                )),
          ),
        ),
      ),
    );
  }
}
