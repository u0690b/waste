import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/models/waste_model.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';

class CompleteWasteController extends WasteController
    implements IPaginationModel<Waste> {
  @override
  Future<Iterable<Waste>?> _getQuery() async {
    final res = await fetch<Iterable<Waste>>(
      '/registers',
      'get',
      body: {'status_id': 3, 'next_cursor': nextCursor},
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
    try {
      var q = await _getQuery();

      List<Waste> retVal = q?.toList() ?? [];

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
      body: {'status_id': 2, 'next_cursor': nextCursor},
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
    try {
      var q = await _getQuery();

      List<Waste> retVal = q?.toList() ?? [];

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
  Future<List<Waste>?> refresh() async {
    if (loading.value) return null;
    loading.value = true;
    nextCursor = null;
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

  Future<void> deleteLocalModels(int index) async {
    loading.value = true;
    await initWasteModel();
    final localModels =
        GetStorage('WasteModel').read<List>('LocalWasteModel') ?? [];
    localModels.removeAt(index);
    await GetStorage('WasteModel').write('LocalWasteModel', localModels);
    loading.value = false;
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

  Future<void> postWaste(WasteModel model) async {
    if (loading.value) return;
    loading.value = true;
    try {
      final res = await fetchMutiPart(
        '/registers',
        'POST',
        body: model.toJson(false),
        images: model.imageFileList ?? [],
        video: model.videoFile,
        onError: (msg) async {
          await Get.defaultDialog(
              middleText: msg,
              textConfirm: 'OK',
              confirmTextColor: Colors.white,
              onConfirm: () => Get.back());
          throw Exception(msg);
        },
      );
    } catch (e) {
      rethrow;
    } finally {
      loading.value = false;
    }
  }
}
