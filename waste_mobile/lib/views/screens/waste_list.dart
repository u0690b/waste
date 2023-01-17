import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/views/screens/waste_details.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';

class WasteList extends StatelessWidget {
  final String title;
  const WasteList({super.key, required this.title});

  @override
  Widget build(BuildContext context) {
    final IPaginationModel<Waste> wasteController =
        Get.find<WasteController>(tag: title);
    // wasteController.refresh();
    return Scaffold(
      appBar: AppBar(
        title: Text(title),
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
                  // tileColor: LightColors.kPalePink,
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
                  onTap: () => Get.to(() => WasteDetails(
                        waste: item,
                        wasteController: wasteController,
                      )),
                  dense: false,
                  title: Text(item.name),
                  subtitle: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(item.fullAddress()),
                      Text(
                        item.description,
                        textAlign: TextAlign.left,
                        maxLines: 4,
                        overflow: TextOverflow.ellipsis,
                      ),
                    ],
                  ));
            },
            separatorBuilder: (BuildContext context, int index) {
              return const Divider(height: 10);
            },
          );
        },
      ),
    );
  }
}
