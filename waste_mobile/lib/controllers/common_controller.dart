import 'dart:developer';

import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/utils/contants.dart';

class CommonController extends GetxController with Api {
  String? nextCursor;

  final RxList<NameModel> datas = <NameModel>[].obs;

  Future<List<NameModel>?> loadData() async {
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
        'resolves_date': GetStorage().read('resolves_date'),
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
    Constants.resolves = decode(res['resolves']);
    Constants.statistic = (res['statistic'] as Map<String, dynamic>).map(
      (key, value) => MapEntry(key, int.tryParse(value.toString()) ?? 0),
    );

    return datas;
  }
}
