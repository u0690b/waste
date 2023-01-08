import 'package:flutter/foundation.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/models/Notification.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';

class NotificationController extends GetxController
    with Api
    implements IPaginationModel<Notification> {
  ValueNotifier<bool> loading = ValueNotifier<bool>(false);
  @override
  String? nextCursor;

  @override
  final RxList<Notification> datas = <Notification>[].obs;

  Rx<int> count = Rx<int>(0);

  Future<List<Notification>?> _getQuery() async {
    String ss = "";
    Map<String, dynamic> headers = {};

    final res = await fetch<List<Notification>>(
      '/notifications',
      'get',
      body: {'next_cursor': nextCursor, ...headers},
      decoder: (data) {
        if (data is Map) {
          nextCursor = data['next_cursor'];
          count.value = data['count'] ?? 0;
          return (data['data'] as List<dynamic>)
              .map((e) => Notification.fromJson(e))
              .toList();
        }
        // return [];
        return (data as List<dynamic>)
            .map((e) => Notification.fromJson(e))
            .toList();
      },
    );
    return res;
  }

  @override
  Future<List<Notification>?> fetchMore() async {
    if (loading.value) return null;
    loading.value = true;
    try {
      var q = await _getQuery();

      List<Notification> retVal = q?.toList() ?? [];

      if (retVal.isNotEmpty) {
        datas.addAll(retVal);
      }
    } catch (_) {
      rethrow;
    } finally {
      loading.value = false;
    }
    return datas;
  }

  @override
  Future<List<Notification>?> refresh() async {
    if (loading.value) return null;
    loading.value = true;
    nextCursor = null;
    var q = await _getQuery();

    List<Notification> retVal = q?.toList() ?? [];

    datas.value = retVal;

    loading.value = false;
    return null;
  }

  Future makrRead(int id) async {
    return await fetch('/notifications/$id', 'put');
  }
}
