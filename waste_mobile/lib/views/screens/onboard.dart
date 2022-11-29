import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/views/screens/home.dart';
import 'package:waste_mobile/views/screens/login.dart';

class OnBoard extends StatelessWidget {
  const OnBoard({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    AuthController authManager = Get.find();

    return Obx(() {
      return authManager.isLogged.value ? const HomeView() : const LoginView();
    });
  }
}
