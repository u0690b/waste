import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';

class HomeView extends StatefulWidget {
  const HomeView({Key? key}) : super(key: key);

  @override
  State<HomeView> createState() => _HomeViewState();
}

class _HomeViewState extends State<HomeView> {
  final AuthController _authManager = Get.find();
  final WasteController _wasteController = Get.put(WasteController());

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
              icon: const Icon(Icons.logout_rounded))
        ],
      ),
      body: PaginationBuilder<Waste>(
        paginationModel: _wasteController,
        itemBuilder: (BuildContext context, List<dynamic>? datas) {
          return ListView.builder(
            itemCount: _wasteController.datas?.length ?? 0,
            itemBuilder: (context, index) {
              var item = _wasteController.datas![index];
              return ListTile(
                contentPadding: const EdgeInsets.symmetric(horizontal: 8),
                onTap: () async {},
                dense: false,
                leading: CircleAvatar(
                    backgroundImage: NetworkImage(item.description),
                    radius: 20),
              );
            },
          );
        },
      ),
    );
  }
}
