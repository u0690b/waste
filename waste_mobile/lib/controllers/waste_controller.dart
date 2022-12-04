import 'package:flutter/cupertino.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';

class WasteController with Api implements IPaginationModel<Waste> {
  @override
  ValueNotifier<bool> loading = ValueNotifier<bool>(false);
  @override
  String? nextCursor;

  @override
  final RxList<Waste> datas = <Waste>[].obs;

  Future<Iterable<Waste>?> _getQuery() async {
    final res = await fetch<Iterable<Waste>>(
      '/registers',
      'get',
      decoder: (data) {
        if (data is Map) {
          nextCursor = data['next_cursor'];
          return (data['data'] as List<dynamic>).map(
            (e) => Waste.fromJson(e),
          );
        }
        // return [];
        return (data as List<dynamic>).map(
          (e) => Waste.fromJson(e),
        );
      },
    );
    return res;
  }

  @override
  Future<List<Waste>?> fetchMore() async {
    if (loading.value) return null;
    loading.value = true;
    var q = await _getQuery();

    List<Waste> retVal = q?.toList() ?? [];

    if (retVal.isNotEmpty) {
      datas.addAll(retVal);
    }

    loading.value = false;
    return datas;
  }

  @override
  Future<List<Waste>?> refresh() async {
    if (loading.value) return null;
    loading.value = true;
    var q = await _getQuery();

    List<Waste> retVal = q?.toList() ?? [];

    if (retVal.isNotEmpty) {
      datas.value = retVal;
    }
    loading.value = false;
    return null;
  }
}
