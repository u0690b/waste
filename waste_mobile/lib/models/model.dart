// ignore_for_file: non_constant_identifier_names

import 'dart:convert';
import 'dart:io';

import 'package:flutter/services.dart';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:image_picker/image_picker.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/cache_manager.dart';
import 'package:waste_mobile/utils/contants.dart';

class NameModel {
  final int id;
  final String name;
  final String? descrip;
  final int? aimag_city_id;
  final int? soum_district_id;
  final DateTime? updated_at;
  final DateTime? created_at;

  NameModel({
    required this.id,
    required this.name,
    this.descrip,
    this.soum_district_id,
    this.aimag_city_id,
    this.updated_at,
    this.created_at,
  });

  NameModel? get aimag_city =>
      aimag_city_id == null
          ? soum_district?.aimag_city
          : Constants.aimagCities.firstWhere(
            (element) => element.id == aimag_city_id,
            orElse: () => NameModel(name: '', id: -1),
          );

  NameModel? get soum_district =>
      soum_district_id == null
          ? null
          : Constants.soumDistricts.firstWhere(
            (element) => element.id == soum_district_id,
            orElse: () => NameModel(name: '', id: -1),
          );

  Map<String, dynamic> toJson() => {
    "id": id,
    "name": name,
    'descrip': descrip,
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
    descrip: snap['sub_group'],
    updated_at:
        snap['updated_at'] == null
            ? null
            : DateTime.tryParse(snap['updated_at']),
    created_at:
        snap['created_at'] == null
            ? null
            : DateTime.tryParse(snap['created_at']),
  );
}

class ValidationException implements Exception {
  String message;
  Map<String, dynamic> errors;
  ValidationException(this.message, this.errors) : super();
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
      ..._hasToken(),
    };
    var url = Uri.parse('${Constants.host}/api$path');
    if (method.toLowerCase() == 'get') {
      if (body is Map) {
        Map<String, String> body1 = Map<String, String>.from(
          url.queryParameters,
        );
        body.forEach((key, value) {
          if (value != null) {
            body1[key] = value.toString();
          }
        });
        url = url.replace(queryParameters: body1);
      }
      body = null;
    }
    var req = http.Request(method, url);
    req.headers.addAll(headersList);
    if (body != null) {
      req.body = jsonEncode(body);
    }

    var res = await req.send();
    final resBytes = await res.stream.toBytes();

    final resBody = String.fromCharCodes(resBytes);
    String text = 'Сервэртэй холбогдоход алдаа гарлаа!';
    if (res.statusCode >= 200 && res.statusCode < 300) {
      final body = jsonDecode(resBody);

      if (decoder != null) {
        return decoder(body);
      }
      return body;
    } else if (res.statusCode == 401) {
      final body = jsonDecode(resBody);

      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
      }

      await Get.defaultDialog(
        middleText: text,
        textConfirm: 'OK',
        confirmTextColor: Colors.white,
        onConfirm: () {
          Get.back(closeOverlays: true);
          Get.find<AuthController>().logOut();
        },
      );
    } else if (res.statusCode == 422) {
      final body = jsonDecode(resBody);
      text = res.reasonPhrase ?? text;
      if (body is Map<String, dynamic> && body.containsKey('message')) {
        text = body['message'];
      }
      throw ValidationException(text, body['errors']);
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
        throw PlatformException(code: res.statusCode.toString(), message: text);
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
    XFile? image,
    List<int>? video,
    Progress? uploadProgress,
    void Function(String msg)? onError,
    void Function()? connectionError,
  }) async {
    var headersList = {
      'User-Agent': 'waste_mobile',
      'Accept': 'application/json',
      HttpHeaders.contentTypeHeader: 'application/json',
      ..._hasToken(),
    };
    var url = Uri.parse('${Constants.host}/api$path');

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
    for (int i = 0; i < images.length; i++) {
      req.files.add(
        http.MultipartFile.fromBytes(
          'images[$i]',
          images[i],
          filename: "images$i.jpg",
        ),
      );
    }
    if (video != null) {
      req.files.add(
        http.MultipartFile.fromBytes('video', video, filename: 'video.mpeg'),
      );
    }
    if (image != null) {
      req.files.add(await http.MultipartFile.fromPath('image', image.path));
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
        },
      );
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
          onConfirm: Get.back,
        );
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
    return {'Authorization': "Bearer $token", 'X-Auth-Token': "Bearer $token"};
  }
}
