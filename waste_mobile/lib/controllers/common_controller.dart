import 'dart:developer';

import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/utils/contants.dart';

class CommonController with Api {
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
    Constants.za = double.tryParse(res['statistic'][0]['za'] ?? '0') ?? 0;
    Constants.mh = double.tryParse(res['statistic'][0]['mh'] ?? '0') ?? 0;
    Constants.totalAa = res['statistic'][0]['total_za'] ?? 0;
    Constants.totalMh = res['statistic'][0]['total_mh'] ?? 0;
    return datas;
  }
}
