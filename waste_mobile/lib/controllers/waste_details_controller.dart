import 'package:flutter/cupertino.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/models/waste.dart';

class WasteDetailsController extends GetxController with Api {
  ValueNotifier<bool> loading = ValueNotifier<bool>(false);

  Future<Waste?> getQuery(int id) async {
    if (loading.value) return null;
    loading.value = true;
    final res = await fetch<Waste>(
      '/registers/$id',
      'get',
      decoder: (e) {
        return Waste.fromJson(e);
      },
    );
    loading.value = false;
    return res;
  }
}
