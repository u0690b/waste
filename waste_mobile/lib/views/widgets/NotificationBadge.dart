import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/notification_controller.dart';
import 'package:waste_mobile/views/screens/notification_list.dart';

class NotificationBadge extends StatelessWidget {
  NotificationBadge({super.key});

  final NotificationController controller = Get.find();
  @override
  Widget build(BuildContext context) {
    return IconButton(
        onPressed: () {
          Get.to(() => NotificationList());
        },
        icon: Stack(
          children: [
            Center(
              child: Icon(
                Icons.notifications,
                color: Colors.white,
              ),
            ),
            Positioned(
              bottom: 1,
              right: 1,
              child: StreamBuilder<int>(
                  stream: controller.count.stream,
                  initialData: controller.count.value,
                  builder: (context, snapshot) {
                    if (snapshot.data == null || snapshot.data == 0)
                      return SizedBox();
                    return CircleAvatar(
                      maxRadius: 7,
                      child: Text(
                        snapshot.data?.toString() ?? '',
                        style: TextStyle(fontSize: 8),
                      ),
                    );
                  }),
            )
          ],
        ));
  }
}
