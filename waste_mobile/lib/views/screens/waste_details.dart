import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/waste_details_controller.dart';
import 'package:waste_mobile/views/widgets/progress_indicator.dart';

class WasteDetails extends StatefulWidget {
  final int id;
  const WasteDetails({Key? key, required this.id}) : super(key: key);

  @override
  State<WasteDetails> createState() => _WasteDetailsState();
}

class _WasteDetailsState extends State<WasteDetails> {
  final WasteDetailsController _wasteController =
      Get.put(WasteDetailsController());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Хог хаягдал'),
      ),
      body: FutureBuilder(
        future: _wasteController.getQuery(widget.id),
        builder: (context, snapshot) {
          if (snapshot.hasError) {
            snapshot.printError();
            return Center(child: Text(snapshot.error.toString()));
          } else if (snapshot.hasData) {
            final waste = snapshot.data!;
            return Column(
              children: [
                Text(waste.description),
                Text(waste.address ?? ''),
              ],
            );
          }

          return const WaitProgressIndicator();
        },
      ),
    );
  }
}
