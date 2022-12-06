import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/waste_model.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/views/screens/waste_create.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';

class WasteEdit extends StatefulWidget {
  final WasteModel model;
  const WasteEdit({Key? key, required this.model}) : super(key: key);

  @override
  State<WasteEdit> createState() => _WasteEditState();
}

class _WasteEditState extends State<WasteEdit> {
  @override
  Widget build(BuildContext context) {
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
            child: WasteRegisterForm(
              model: widget.model,
              onSave: (WasteModel value) async {
                await Get.find<WasteController>()
                    .editLocalModels(value..index = widget.model.index);
                setState(() {});
                return Future.value();
              },
            ),
          ),
        ));
  }
}
