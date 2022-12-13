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

  Future<List<NameModel>?> loadData() async {
    if (loading.value) return null;
    loading.value = true;

    final res = await fetch(
      '/commons',
      'GET',
      body: {
        'places_date': GetStorage().read('places_date'),
        'reasons_date': GetStorage().read('reasons_date'),
        'statuses_date': GetStorage().read('statuses_date'),
        'aimag_cities_date': GetStorage().read('aimag_cities_date'),
        'soum_districts_date': GetStorage().read('soum_districts_date'),
        'bag_horoos_date': GetStorage().read('bag_horoos_date'),
      },
      onError: (msg) {
        log(msg, level: 1);
      },
    );
    List<NameModel>? decode(dynamic data) {
      return (data as List).map((v) => NameModel.fromJson(v)).toList();
    }

    Constants.places = decode(res['places']);
    Constants.reasons = decode(res['reasons']);
    Constants.status = decode(res['statuses']);
    Constants.aimagCities = decode(res['aimag_cities']);
    Constants.soumDistricts = decode(res['soum_districts']);
    Constants.bagHoroos = decode(res['bag_horoos']);

    loading.value = false;
    return datas;
  }
}
