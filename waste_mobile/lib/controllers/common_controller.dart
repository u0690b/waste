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

    Constants.places = await _getQuery('/places');
    Constants.reasons = await _getQuery('/reasons');
    Constants.status = await _getQuery('/statuses');
    Constants.aimagCities = await _getQuery('/aimag_cities');
    Constants.soumDistricts = await _getQuery('/soum_districts');
    Constants.bagHoroos = await _getQuery('/bag_horoos');
    loading.value = false;
    return datas;
  }

  String? getUpdateDate(String q) {
    return GetStorage().read('${q}_lastDate');
  }
}
