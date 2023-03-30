import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/notification_controller.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/views/screens/waste_details.dart';
import 'package:waste_mobile/views/widgets/future_alert_dialog.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';
import 'package:timeago/timeago.dart' as timeago;

class NotificationList extends StatefulWidget {
  final bool refreshable;
  NotificationList({super.key, this.refreshable = false});

  @override
  State<NotificationList> createState() => _NotificationListState();
}

class _NotificationListState extends State<NotificationList> {
  final NotificationController _controller = Get.find();
  @override
  void initState() {
    if (widget.refreshable) _controller.refresh();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Мэдэгдэл'),
      ),
      body: PaginationBuilder(
        paginationModel: _controller,
        itemBuilder: (BuildContext context, datas) {
          return ListView(
            children: [
              for (var item in datas!)
                Column(
                  children: [
                    ListTile(
                      contentPadding: EdgeInsets.only(
                          top: 10, left: 10, right: 8, bottom: 0),
                      shape: const RoundedRectangleBorder(
                          borderRadius: BorderRadius.only(
                              topLeft: Radius.circular(5),
                              topRight: Radius.circular(5),
                              bottomRight: Radius.circular(5),
                              bottomLeft: Radius.circular(5))),
                      onTap: () {
                        if (item.read_at == null)
                          _controller
                              .makrRead(item.id)
                              .then((value) => setState(() {
                                    item.read_at = DateTime.now();
                                  }));
                        WasteController controller =
                            Get.find(tag: 'Хуваарилагдсан');
                        if (item.rid != null) {
                          futureAlertDialog(
                            context: context,
                            futureStream: controller.getWaste(id: item.rid!),
                            autoCloseSec: 0,
                          ).then((value) {
                            Get.to(() => WasteDetails(
                                waste: value!, wasteController: controller));
                          });
                        }
                      },
                      title: Text(
                        item.title,
                        textAlign: TextAlign.left,
                        maxLines: 4,
                        overflow: TextOverflow.ellipsis,
                        style: TextStyle(
                            fontWeight: item.read_at == null
                                ? FontWeight.w500
                                : FontWeight.w400,
                            fontSize: 14),
                      ),
                      subtitle: Column(
                        mainAxisSize: MainAxisSize.min,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          SizedBox(height: 5),
                          Text(
                            item.content.replaceAll('\\n', '\n'),
                            textAlign: TextAlign.left,
                            maxLines: 4,
                            overflow: TextOverflow.ellipsis,
                            style: TextStyle(
                                fontWeight: item.read_at == null
                                    ? FontWeight.w500
                                    : FontWeight.w300,
                                fontSize: 12),
                          ),
                          SizedBox(height: 5),
                          Row(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Text(
                                item.type,
                                style: TextStyle(
                                    fontWeight: item.read_at == null
                                        ? FontWeight.w500
                                        : FontWeight.w300,
                                    fontSize: 9),
                              ),
                              Text(
                                timeago.format(
                                    item.created_at ?? DateTime.now(),
                                    locale: 'mn'),
                                style: TextStyle(
                                    fontWeight: item.read_at == null
                                        ? FontWeight.w500
                                        : FontWeight.w300,
                                    fontSize: 9),
                              )
                            ],
                          ),
                        ],
                      ),
                    ),
                    Divider(),
                  ],
                ),
            ],
          );
        },
      ),
    );
  }
}
