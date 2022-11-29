import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_connect/http/src/request/request.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/cache_manager.dart';

class Model extends GetConnect {
  @override
  void onInit() {
    httpClient.baseUrl = 'http://localhost:8000/api';

    httpClient.addRequestModifier((request) {
      request.headers['Accept'] = 'application/json';
      return request as Request<Object>;
    });
  }
}

mixin Api {
  final api = GetConnect()
    ..baseUrl = 'http://localhost:8000/api'
    ..httpClient.addRequestModifier(<T>(Request<T?> request) {
      request.headers['Accept'] = 'application/json';
      return request;
    });

  Future<T?> fetch<T>(
    String path,
    String method, {
    dynamic body,
    Map<String, String>? headers,
    Map<String, dynamic>? query,
    Decoder<T>? decoder,
    Progress? uploadProgress,
  }) async {
    final res = await api.request(
      path,
      method,
      body: body,
      headers: {...(headers ?? {}), ..._hasToken()},
      query: query,
      uploadProgress: uploadProgress,
    );
    String text = 'Сервэртэй холбогдоход алдаа гарлаа!';
    if (res.isOk) {
      // final user = User.fromJson(res.body);
      if (decoder != null) {
        return decoder(res.body);
      }
      return res.body;
    }
    if (res.unauthorized) {
      if (res.body is Map<String, dynamic> && res.body.containsKey('message')) {
        text = res.body['message'];
      }

      Get.defaultDialog(
          middleText: text,
          textConfirm: 'OK',
          confirmTextColor: Colors.white,
          onConfirm: () {
            Get.back();
            Get.find<AuthController>().logOut();
          });
    } else {
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
      return null;
    }
    return null;
  }

  Map<String, String> _hasToken() {
    final token = GetStorage().read<String>(CacheManagerKey.TOKEN.toString());
    if (token == null) {
      return {};
    }
    return {'Authorization': "Bearer $token"};
  }
}
