import 'package:flutter/material.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/waste_model.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/views/screens/waste_create.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';
import 'package:waste_mobile/views/widgets/future_alert_dialog.dart';

class WasteEdit extends StatefulWidget {
  final WasteModel model;
  final WasteController wasteController;
  const WasteEdit(
      {Key? key, required this.model, required this.wasteController})
      : super(key: key);

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
          child: WasteRegisterForm(
            model: widget.model,
            onSave: (WasteModel value) async {
              await futureAlertDialog(
                context: context,
                futureStream: widget.wasteController
                    .editLocalModels(value..index = widget.model.index),
                autoCloseSec: 1,
              );

              setState(() {});
              return Future.value();
            },
          ),
        ));
  }
}
