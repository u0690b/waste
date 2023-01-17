import 'package:flutter/material.dart';
import 'package:flutter_slidable/flutter_slidable.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/views/screens/splash_screen.dart';
import 'package:waste_mobile/views/screens/waste_create.dart';
import 'package:waste_mobile/views/screens/waste_edit.dart';
import 'package:waste_mobile/views/widgets/future_alert_dialog.dart';

class LocalWasteList extends StatefulWidget {
  final String title;
  const LocalWasteList({super.key, required this.title});

  @override
  State<LocalWasteList> createState() => _LocalWasteListState();
}

class _LocalWasteListState extends State<LocalWasteList> {
  @override
  Widget build(BuildContext context) {
    final WasteController wasteController = Get.find(tag: widget.title);

    return Scaffold(
      appBar: AppBar(
        title: Text(widget.title),
        actions: [
          IconButton(
            onPressed: () =>
                Get.to(() => WasteCreate(wasteController: wasteController)),
            icon: const Icon(Icons.create_new_folder_rounded),
          )
        ],
      ),
      body: FutureBuilder(
          future: wasteController.initWasteModel(),
          builder: (context, snapshot) {
            if (snapshot.connectionState != ConnectionState.done) {
              return const WaitingWidget();
            }

            return ValueListenableBuilder(
                valueListenable: wasteController.loading,
                builder: (context, val, child) {
                  final datas = wasteController.getLocalModels();
                  return val
                      ? const WaitingWidget()
                      : ListView.separated(
                          padding: const EdgeInsets.all(8),
                          itemCount: datas.length,
                          itemBuilder: (context, index) {
                            var item = datas[index];
                            item.index = index;
                            return Slidable(
                              key: ValueKey(index),
                              startActionPane: ActionPane(
                                // A motion is a widget used to control how the pane animates.
                                motion: const ScrollMotion(),

                                // All actions are defined in the children parameter.
                                children: [
                                  // A SlidableAction can have an icon and/or a label.
                                  SlidableAction(
                                    onPressed: (BuildContext context) {
                                      print('delete $index');
                                      wasteController.deleteLocalModels(index);
                                    },
                                    backgroundColor: const Color(0xFFFE4A49),
                                    foregroundColor: Colors.white,
                                    icon: Icons.delete,
                                    label: 'Устгах',
                                  ),
                                ],
                              ),
                              endActionPane: ActionPane(
                                motion: const ScrollMotion(),
                                children: [
                                  SlidableAction(
                                    onPressed: (BuildContext context) {
                                      print('send $index');
                                      futureAlertDialog(
                                          context: context,
                                          futureStream: wasteController
                                              .postWaste(item)
                                              .then((value) => wasteController
                                                  .deleteLocalModels(index)),
                                          autoCloseSec: 1);
                                    },
                                    backgroundColor: const Color(0xFF0392CF),
                                    foregroundColor: Colors.white,
                                    icon: Icons.cloud_upload,
                                    label: 'Илгээх',
                                  ),
                                ],
                              ),
                              child: ListTile(
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
                                  contentPadding:
                                      const EdgeInsets.symmetric(horizontal: 8),
                                  onTap: () => Get.to(() => WasteEdit(
                                      model: item,
                                      wasteController: wasteController)),
                                  dense: false,
                                  title: Text(item.name ?? ''),
                                  subtitle: Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: [
                                      Text(item.fullAddress()),
                                      Text(
                                        item.description ?? '',
                                        maxLines: 4,
                                        overflow: TextOverflow.ellipsis,
                                      ),
                                    ],
                                  )),
                            );
                          },
                          separatorBuilder: (BuildContext context, int index) {
                            return const Divider(height: 10);
                          },
                        );
                });
          }),
    );
  }
}
