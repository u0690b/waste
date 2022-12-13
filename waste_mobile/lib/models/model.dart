// ignore_for_file: non_constant_identifier_names

import 'dart:convert';
import 'dart:io';

import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:get/get.dart';
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
    var headersList = {
      'User-Agent': 'waste_mobile',
      'Accept': 'application/json',
      HttpHeaders.contentTypeHeader: 'application/json',
      ..._hasToken()
    };
    var url = Uri.parse('http://10.0.2.2:8000/api$path');

    var req = http.Request(method, url);
    req.headers.addAll(headersList);

    req.body = body == null ? '' : jsonEncode(body);
    var res = await req.send();
    final resBytes = await res.stream.toBytes();
    final resBody = utf8.decode(resBytes.toList(), allowMalformed: true);
    String text = 'Сервэртэй холбогдоход алдаа гарлаа!';
    if (res.statusCode >= 200 && res.statusCode < 300) {
      final body = jsonDecode(resBody);

      if (decoder != null) {
        return decoder(body);
      }
      return body;
    }
    if (res.statusCode == 401) {
      final body = jsonDecode(resBody);
      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
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
      print(res.reasonPhrase);
      final body = jsonDecode(resBody);
      text = res.reasonPhrase ?? text;
      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
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

    // connectionError();

    return null;
  }

  Future<T?> fetchMutiPart<T>(
    String path,
    String method, {
    required dynamic body,
    Map<String, String>? headers,
    Map<String, dynamic>? query,
    Decoder<T>? decoder,
    required List<List<int>> images,
    List<int>? video,
    Progress? uploadProgress,
    void Function(String msg)? onError,
    void Function()? connectionError,
  }) async {
    var headersList = {
      'User-Agent': 'waste_mobile',
      'Accept': 'application/json',
      HttpHeaders.contentTypeHeader: 'application/json',
      ..._hasToken()
    };
    var url = Uri.parse('http://10.0.2.2:8000/api$path');

    var req = http.MultipartRequest(method, url);
    req.headers.addAll(headersList);
    if (body is! Map) {
      body = jsonDecode(body);
    }
    body.forEach((key, val) {
      if (val != null) {
        if (val is List) {
          for (int i = 0; i < val.length; i++) {
            req.fields['$key[$i]'] = val[i].toString();
          }
        } else {
          req.fields[key] = val.toString();
        }
      }
    });
    for (var element in images) {
      req.files.add(http.MultipartFile.fromBytes('images', element));
    }
    if (video != null) {
      req.files.add(http.MultipartFile.fromBytes('images', video));
    }
    var res = await req.send();
    final resBytes = await res.stream.toBytes();
    final resBody = utf8.decode(resBytes.toList(), allowMalformed: true);
    String text = 'Сервэртэй холбогдоход алдаа гарлаа!';
    if (res.statusCode >= 200 && res.statusCode < 300) {
      final body = jsonDecode(resBody);

      if (decoder != null) {
        return decoder(body);
      }
      return body;
    }
    if (res.statusCode == 401) {
      final body = jsonDecode(resBody);
      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
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
      print(res.reasonPhrase);
      final body = jsonDecode(resBody);
      text = res.reasonPhrase ?? text;
      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
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

    // connectionError();

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
