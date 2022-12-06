import 'dart:developer';

import 'package:flutter/foundation.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/utils/contants.dart';

class CommonController with Api {
  ValueNotifier<bool> loading = ValueNotifier<bool>(false);

  String? nextCursor;

  final RxList<NameModel> datas = <NameModel>[].obs;

  Future<List<NameModel>?> _getQuery(String path) async {
    final res = await fetch<List<NameModel>>(
      path,
      'get',
      decoder: (data) {
        if (kDebugMode) {
          print(data);
        }
        return (data as List).map((v) => NameModel.fromJson(v)).toList();
      },
      query: {'date': getUpdateDate(path)},
      onError: (msg) {
        log(msg);
      },
    );
    return res;
  }

  Future<List<NameModel>?> loadData() async {
    if (loading.value) return null;
    loading.value = true;
    await Future.wait([
      _getQuery('/places').then((value) => Constants.places = value),
      _getQuery('/reasons').then((value) => Constants.reasons = value),
      _getQuery('/statuses').then((value) => Constants.status = value),
      _getQuery('/aimag_cities').then((value) => Constants.aimagCities = value),
      _getQuery('/soum_districts')
          .then((value) => Constants.soumDistricts = value),
      _getQuery('/bag_horoos').then((value) => Constants.bagHoroos = value),
    ]);

    loading.value = false;
    return datas;
  }

  String? getUpdateDate(String q) {
    return GetStorage().read('${q}_lastDate');
  }
}
