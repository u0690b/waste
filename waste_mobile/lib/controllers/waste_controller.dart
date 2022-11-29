import 'package:flutter/cupertino.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';

class WasteController extends GetxController
    with Api
    implements IPaginationModel<Waste> {
  @override
  bool hasMore = true;
  @override
  ValueNotifier<bool> loading = ValueNotifier<bool>(false);

  Future<Iterable<Waste>?> getQuery() async {
    final res = await fetch<Iterable<Waste>>(
      '/registers',
      'get',
      decoder: (data) {
        print(data);
        // return [];
        return (data as List<dynamic>).map(
          (e) => Waste.fromJson(e),
        );
      },
    );
    return res;
  }

  @override
  List<Waste>? datas;

  @override
  int? page;

  @override
  int total = 0;

  @override
  Future<Iterable<Waste>?> fetchMore() async {
    if (loading.value) return null;
    loading.value = true;
    var q = await getQuery();

    List<Waste> retVal = q?.toList() ?? [];
    hasMore = retVal.isNotEmpty;
    if (retVal.isNotEmpty) {
      datas = [
        ...datas ?? [],
        ...retVal,
      ];
    }
    loading.value = false;
    return null;
  }

  @override
  Future<Iterable<Waste>?> refresh() async {
    if (loading.value) return null;
    loading.value = true;
    var q = await getQuery();

    List<Waste> retVal = q?.toList() ?? [];
    hasMore = retVal.isNotEmpty;
    if (retVal.isNotEmpty) {
      datas = retVal;
    }
    loading.value = false;
    return null;
  }

  @override
  void notifyListeners() {
    super.notifyChildrens();
  }
}
