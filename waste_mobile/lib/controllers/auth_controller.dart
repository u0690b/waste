import 'dart:developer';

import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_connect/http/src/status/http_status.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/controllers/cache_manager.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/models/user.dart';
import 'package:waste_mobile/utils/contants.dart';

class AuthController extends GetxController with CacheManager, Api {
  final isLogged = false.obs;
  static User? user;
  void logOut() {
    isLogged.value = false;

    removeToken();
    final box = GetStorage();
    box.remove('UserModel');
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
      getUser(token);
    }
  }

  Future<void> loginUser(String email, String password) async {
    final res = await fetch(
      '/login',
      'POST',
      body: {'username': email, 'password': password},
      headers: {"Accept": "application/json"},
    );

    final user = User.fromJson(res);
    login(user);
  }

  Future<void> getUser(token) async {
    final res = await GetConnect().get(
      '${Constants.host}/api/user',
      headers: {
        "Accept": "application/json",
        'content-type': 'application/json',
        ..._hasToken(),
      },
    );

    if (res.statusCode == HttpStatus.ok) {
      res.body['token'] = token;
      final user = User.fromJson(res.body);
      login(user);
    } else {
      String text = 'User not found!';
      if (res.body is Map<String, dynamic> && res.body.containsKey('message')) {
        text = res.body['message'];
      }
      if (res.statusCode == HttpStatus.unauthorized) removeToken();
      Get.defaultDialog(
          middleText: text,
          textConfirm: 'OK',
          confirmTextColor: Colors.white,
          onConfirm: () {
            Get.back();
          });
    }
  }

  Map<String, String> _hasToken() {
    final token = GetStorage().read<String>(CacheManagerKey.TOKEN.toString());
    if (token == null) {
      return {};
    }
    return {'Authorization': "Bearer $token"};
  }

  Future<void> savePushToken(String pushToken) async {
    final res = await GetConnect().put(
      '${Constants.host}/api/save_token',
      {'push_token': pushToken},
      headers: {
        "Accept": "application/json",
        'content-type': 'application/json',
        ..._hasToken(),
      },
    );

    if (res.statusCode == HttpStatus.ok) {
    } else {
      log(res.bodyString ?? 'Яамар нэгэн алдаа');
    }
  }
}
