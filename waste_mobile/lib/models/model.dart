// ignore_for_file: non_constant_identifier_names

import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get/get_connect/http/src/request/request.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/cache_manager.dart';
import 'package:waste_mobile/utils/contants.dart';

class NameModel {
  final int id;
  final String name;
  final int? aimag_city_id;
  final int? soum_district_id;
  final DateTime? updated_at;
  final DateTime? created_at;
  NameModel({
    required this.id,
    required this.name,
    this.soum_district_id,
    this.aimag_city_id,
    this.updated_at,
    this.created_at,
  });

  NameModel? get aimag_city => aimag_city_id == null
      ? soum_district?.aimag_city
      : Constants.aimagCities.firstWhere(
          (element) => element.id == aimag_city_id,
          orElse: () => NameModel(name: '', id: -1));

  NameModel? get soum_district => soum_district_id == null
      ? null
      : Constants.soumDistricts.firstWhere(
          (element) => element.id == soum_district_id,
          orElse: () => NameModel(name: '', id: -1));

  Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        'soum_district_id': soum_district_id,
        'aimag_city_id': aimag_city_id,
        'updated_at': updated_at?.toIso8601String(),
        'created_at': created_at?.toIso8601String(),
      };

  factory NameModel.fromJson(Map<String, dynamic> snap) => NameModel(
        id: snap['id'],
        name: snap['name'],
        aimag_city_id: snap['aimag_city_id'],
        soum_district_id: snap['soum_district_id'],
        updated_at: snap['updated_at'] == null
            ? null
            : DateTime.tryParse(snap['updated_at']),
        created_at: snap['created_at'] == null
            ? null
            : DateTime.tryParse(snap['created_at']),
      );
}

mixin Api {
  final api = GetConnect()
    ..baseUrl = 'http://10.0.2.2:8000/api'
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
    void Function(String msg)? onError,
    void Function()? connectionError,
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
    } else if (res.status.connectionError && connectionError != null) {
      connectionError();
    } else {
      if (res.body is Map<String, dynamic> && res.body.containsKey('message')) {
        text = res.body['message'];
      }
      if (onError != null) {
        onError(text);
      } else {
        Get.defaultDialog(
            middleText: text,
            textConfirm: 'OK',
            confirmTextColor: Colors.white,
            onConfirm: Get.back);
      }
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
