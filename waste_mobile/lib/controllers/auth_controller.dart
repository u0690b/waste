import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_connect/http/src/status/http_status.dart';
import 'package:waste_mobile/controllers/cache_manager.dart';
import 'package:waste_mobile/models/user.dart';

class AuthController extends GetxController with CacheManager {
  final isLogged = false.obs;

  void logOut() {
    isLogged.value = false;
    removeToken();
  }

  void login(User user) async {
    isLogged.value = true;
    //Token is cached
    await saveToken(user.token);
  }

  void checkLoginStatus() {
    final token = getToken();
    if (token != null) {
      isLogged.value = true;
    }
  }

  Future<void> loginUser(String email, String password) async {
    final res = await GetConnect().post(
      'http://localhost:8000/api/login',
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
