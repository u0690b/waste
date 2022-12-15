import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_connect/http/src/status/http_status.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/controllers/cache_manager.dart';
import 'package:waste_mobile/models/user.dart';
import 'package:waste_mobile/utils/contants.dart';

class AuthController extends GetxController with CacheManager {
  final isLogged = false.obs;
  static User? user;
  void logOut() {
    isLogged.value = false;
    removeToken();
  }

  void login(User user) async {
    isLogged.value = true;
    //Token is cached
    AuthController.user = user;
    final box = GetStorage();
    await box.write('UserModel', user.toJson());
    await saveToken(user.token);
  }

  void checkLoginStatus() {
    final token = getToken();
    final box = GetStorage().read('UserModel');
    User? user = box != null ? User.fromJson(box) : null;
    if (token != null && user != null) {
      AuthController.user = user;
      isLogged.value = true;
    }
  }

  Future<void> loginUser(String email, String password) async {
    final res = await GetConnect().post(
      '${Constants.host}/api/login',
      {'username': email, 'password': password},
      headers: {"Accept": "application/json"},
    );

    if (res.statusCode == HttpStatus.ok) {
      final user = User.fromJson(res.body);
      login(user);
    } else {
      String text = 'User not found!';
      if (res.body is Map<String, dynamic> && res.body.containsKey('message')) {
        text = res.body['message'];
      }
      Get.defaultDialog(
          middleText: text,
          textConfirm: 'OK',
          confirmTextColor: Colors.white,
          onConfirm: () {
            Get.back();
          });
    }
  }
}
