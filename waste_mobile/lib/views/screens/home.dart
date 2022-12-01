import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/views/screens/waste_create.dart';
import 'package:waste_mobile/views/screens/waste_details.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';

class HomeView extends StatefulWidget {
  const HomeView({Key? key}) : super(key: key);

  static CircleAvatar calendarIcon() {
    return const CircleAvatar(
      radius: 25.0,
      backgroundColor: LightColors.kGreen,
      child: Icon(
        Icons.calendar_today,
        size: 20.0,
        color: Colors.white,
      ),
    );
  }

  @override
  State<HomeView> createState() => _HomeViewState();
}

class _HomeViewState extends State<HomeView> {
  final AuthController _authManager = Get.find();
  final WasteController _wasteController =
      Get.put(WasteController()..refresh());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Home'),
        actions: [
          IconButton(
            onPressed: () {
              _authManager.logOut();
            },
            icon: const Icon(Icons.logout_rounded),
          ),
          IconButton(
            onPressed: () => Get.to(const WasteCreate()),
            icon: const Icon(Icons.create_new_folder_rounded),
          )
        ],
      ),
      body: PaginationBuilder<Waste>(
        paginationModel: _wasteController,
        itemBuilder: (BuildContext context, List<Waste>? datas) {
          return ListView.builder(
            itemCount: datas!.length,
            itemBuilder: (context, index) {
              var item = datas[index];
              return ListTile(
                contentPadding: const EdgeInsets.symmetric(horizontal: 8),
                onTap: () => Get.to(WasteDetails(id: item.id)),
                dense: false,
                subtitle: Text(item.description),
              );
            },
          );
        },
      ),
    );
  }
}
