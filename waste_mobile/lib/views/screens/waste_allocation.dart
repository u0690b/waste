import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/models/user.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/views/widgets/future_alert_dialog.dart';

class WasteAllocation extends StatefulWidget {
  final Waste waste;
  final WasteController? wasteController;
  const WasteAllocation({Key? key, required this.waste, this.wasteController})
      : super(key: key);

  @override
  State<WasteAllocation> createState() => _WasteAllocationState();
}

class _WasteAllocationState extends State<WasteAllocation> with Api {
  int? userId;

  XFile? pickedFile;

  final _formKey = GlobalKey<FormState>();
  late Future<List<User>> userFuture;
  @override
  void initState() {
    super.initState();
    userId = widget.waste.comfUserId;
    userFuture = widget.wasteController!.getUsers();
  }

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: FutureBuilder(
          future: userFuture,
          builder: (context, snapshot) {
            if (snapshot.hasError) return Text(snapshot.error.toString());

            if (snapshot.connectionState != ConnectionState.done ||
                !snapshot.hasData)
              return Row(
                mainAxisAlignment: MainAxisAlignment.center,
                mainAxisSize: MainAxisSize.min,
                children: [
                  Center(child: CircularProgressIndicator()),
                ],
              );
            print(snapshot.data!.map((e) => e.id));
            return Form(
              key: _formKey,
              autovalidateMode: AutovalidateMode.onUserInteraction,
              child: Padding(
                  padding: const EdgeInsets.all(15.0),
                  child: Column(
                    mainAxisSize: MainAxisSize.min,
                    children: [
                      DropdownButtonFormField(
                          validator: (p0) =>
                              p0 == null ? 'Заавал бөглөх' : null,
                          value: userId == null
                              ? null
                              : snapshot.data!.contains(
                                      (element) => element.id == userId)
                                  ? userId
                                  : null,
                          decoration: InputDecoration(
                            labelText: "Хуваарьлах хүн:",
                            contentPadding: const EdgeInsets.symmetric(
                                horizontal: 20.0, vertical: 15.0),
                            border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(5.0)),
                          ),
                          items: snapshot.data!
                              .map((e) => DropdownMenuItem(
                                    value: e.id,
                                    child: Text(e.name),
                                  ))
                              .toList(),
                          onChanged: (int? value) => userId = value),
                      const SizedBox(height: 20),
                      ElevatedButton(
                        onPressed: () async {
                          if (_formKey.currentState?.validate() ?? false) {
                            await futureAlertDialog(
                              context: context,
                              futureStream: widget.wasteController!
                                  .allocationWaste(
                                      id: widget.waste.id,
                                      comf_user_id: userId!),
                              autoCloseSec: 1,
                            );

                            Get.back(result: true);
                          }
                        },
                        child: Text('Хуваарьлах'),
                      )
                    ],
                  )),
            );
          }),
    );
  }
}
