import 'package:flutter/cupertino.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/models/waste_model.dart';
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

  Future<void> addLocalModels(WasteModel value) async {
    loading.value = true;
    await initWasteModel();
    final localModels =
        GetStorage('WasteModel').read<List>('LocalWasteModel') ?? [];
    localModels.insert(0, value.toJson());
    await GetStorage('WasteModel').write('LocalWasteModel', localModels);
    loading.value = false;
  }

  Future<bool> initWasteModel() {
    return GetStorage.init('WasteModel');
  }

  List<WasteModel> getLocalModels() {
    final ret = GetStorage('WasteModel')
            .read<List>('LocalWasteModel')
            ?.map((e) => WasteModel.fromJson(e))
            .toList() ??
        [];
    return ret;
  }

  Future<void> editLocalModels(WasteModel value) async {
    loading.value = true;
    await initWasteModel();
    final localModels =
        GetStorage('WasteModel').read<List>('LocalWasteModel') ?? [];
    localModels[value.index!] = value.toJson();
    await GetStorage('WasteModel').write('LocalWasteModel', localModels);
    loading.value = false;
  }
}
