import 'package:flutter/material.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';

class TaskColumn extends StatelessWidget {
  final IconData? icon;
  final Color? iconBackgroundColor;
  final String title;
  final String subtitle;
  final WasteController wasteController;

  const TaskColumn({
    super.key,
    this.icon,
    this.iconBackgroundColor,
    required this.title,
    required this.subtitle,
    required this.wasteController,
  });
  @override
  Widget build(BuildContext context) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.center,
      children: <Widget>[
        CircleAvatar(
          radius: 20.0,
          backgroundColor: iconBackgroundColor,
          child: StreamBuilder(
            stream: wasteController.total.stream,
            initialData: wasteController.total.value,
            builder: (context, snapshot) {
              return Text(snapshot.data?.toString() ?? '0',
                  style: TextStyle(color: Colors.white));
            },
          ),
        ),
        const SizedBox(width: 10.0),
        Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: <Widget>[
            Text(
              title,
              style: const TextStyle(
                fontSize: 16.0,
                fontWeight: FontWeight.w700,
              ),
            ),
            Text(
              subtitle,
              style: const TextStyle(
                  fontSize: 14.0,
                  fontWeight: FontWeight.w500,
                  color: Colors.black45),
            ),
          ],
        )
      ],
    );
  }
}
