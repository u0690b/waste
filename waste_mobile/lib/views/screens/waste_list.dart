import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/views/screens/waste_create.dart';
import 'package:waste_mobile/views/screens/waste_details.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';

class WasteList extends StatelessWidget {
  final String title;
  const WasteList({super.key, required this.title});

  @override
  Widget build(BuildContext context) {
    final WasteController wasteController = Get.find();
    wasteController.refresh();
    return Scaffold(
      appBar: AppBar(
        title: Text(title),
        actions: [
          IconButton(
            onPressed: () => Get.to(const WasteCreate()),
            icon: const Icon(Icons.create_new_folder_rounded),
          )
        ],
      ),
      body: PaginationBuilder<Waste>(
        paginationModel: wasteController,
        itemBuilder: (BuildContext context, List<Waste>? datas) {
          return ListView.separated(
            padding: const EdgeInsets.all(8),
            itemCount: datas!.length,
            itemBuilder: (context, index) {
              var item = datas[index];
              return ListTile(
                tileColor: LightColors.kPalePink,
                textColor: Colors.black,
                iconColor: Colors.blue,
                shape: const RoundedRectangleBorder(
                    borderRadius: BorderRadius.only(
                        topLeft: Radius.circular(5),
                        topRight: Radius.circular(5),
                        bottomRight: Radius.circular(5),
                        bottomLeft: Radius.circular(5))),
                leading: const Icon(Icons.map),
                contentPadding: const EdgeInsets.symmetric(horizontal: 8),
                onTap: () => Get.to(WasteDetails(id: item.id)),
                dense: false,
                title: Text(item.fullAddress()),
                subtitle: Text(item.description),
              );
            },
            separatorBuilder: (BuildContext context, int index) {
              return const SizedBox(height: 10);
            },
          );
        },
      ),
    );
  }
}
