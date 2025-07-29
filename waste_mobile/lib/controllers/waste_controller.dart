import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:image_picker/image_picker.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/models/user.dart';
import 'package:waste_mobile/models/waste.dart';
import 'package:waste_mobile/models/waste_model.dart';
import 'package:waste_mobile/views/widgets/pagination_builder.dart';

class WasteController extends GetxController
    with Api
    implements IPaginationModel<Waste> {
  @override
  ValueNotifier<bool> loading = ValueNotifier<bool>(false);
  @override
  String? nextCursor;
  final RxInt total = 0.obs;
  @override
  final RxList<Waste> datas = <Waste>[].obs;
  String? title;
  WasteController([this.title]);

  Future<Iterable<Waste>?> _getQuery() async {
    String ss = "";
    Map<String, dynamic> headers = {};
    if (title == 'Бүртгэсэн')
      ss = 'status_id=2';
    else if (title == 'Хуваарилагдсан') {
      ss = 'status_id=3';
      if (AuthController.user!.isMH && !AuthController.user!.isMHA)
        headers['comf_user_id'] = AuthController.user!.id;
    } else if (title == 'Шийдвэрлэгдсэн') {
      ss = 'status_id=3';
      if (AuthController.user!.isMH && !AuthController.user!.isMHA)
        headers['comf_user_id'] = AuthController.user!.id;
    } else
      ss = 'status_id[]=2&status_id[]=3';
    final res = await fetch<Iterable<Waste>>(
      '/registers?$ss',
      'get',
      body: {..._getAimagCityFilter(), 'next_cursor': nextCursor, ...headers},
      decoder: (data) {
        if (data is Map) {
          nextCursor = data['next_cursor'];
          total.value = data['total'] ?? 0;
          return (data['data'] as List<dynamic>).map((e) => Waste.fromJson(e));
        }
        // return [];
        return (data as List<dynamic>).map((e) => Waste.fromJson(e));
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

    datas.value = retVal;

    loading.value = false;
    return null;
  }

  Future<void> addLocalModels(WasteModel value) async {
    loading.value = true;
    await initWasteModel();
    final localModels =
        GetStorage('WasteModel').read<List>('LocalWasteModel') ?? [];
    localModels.insert(0, value.toJson());
    total.value = localModels.length;
    await GetStorage('WasteModel').write('LocalWasteModel', localModels);
    loading.value = false;
  }

  Future<bool> initWasteModel() {
    return GetStorage.init('WasteModel');
  }

  List<WasteModel> getLocalModels() {
    final ret =
        GetStorage('WasteModel')
            .read<List>('LocalWasteModel')
            ?.map((e) => WasteModel.fromJson(e))
            .toList() ??
        [];
    total.value = ret.length;
    return ret;
  }

  Future<void> deleteLocalModels(int index) async {
    loading.value = true;
    await initWasteModel();
    final localModels =
        GetStorage('WasteModel').read<List>('LocalWasteModel') ?? [];
    localModels.removeAt(index);
    await GetStorage('WasteModel').write('LocalWasteModel', localModels);
    total.value = localModels.length;
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

  Future<bool> postWaste(WasteModel model) async {
    bool ret = false;
    if (loading.value) return ret;
    loading.value = true;
    try {
      String? _hasError;
      final res = await fetchMutiPart(
        '/registers',
        'POST',
        body: model.toJson(false),
        images: model.imageFileList ?? [],
        video: model.videoFile,
        onError: (msg) async {
          _hasError = msg;
          await Get.defaultDialog(
            middleText: msg,
            textConfirm: 'OK',
            confirmTextColor: Colors.white,
            onConfirm: () => Get.back(),
          );
          throw Exception(msg);
        },
      );
      if (_hasError != null) throw Exception(_hasError);
      ret = true;
    } catch (e) {
      rethrow;
    } finally {
      loading.value = false;
    }
    return ret;
  }

  Future<bool> solveWaste({
    required int id,
    required String resolve_desc,
    required int resolve_id,
    XFile? pickedFile,
  }) async {
    bool ret = false;
    if (loading.value) return ret;
    loading.value = true;
    try {
      String? _hasError;
      final res = await fetchMutiPart(
        '/registers/$id/resolve',
        'POST',
        body: {
          'id': id,
          'resolve_id': resolve_id,
          'resolve_desc': resolve_desc,
        },
        images: [],
        image: pickedFile,
        onError: (msg) async {
          _hasError = msg;
          await Get.defaultDialog(
            middleText: msg,
            textConfirm: 'OK',
            confirmTextColor: Colors.white,
            onConfirm: () => Get.back(),
          );
          throw Exception(msg);
        },
      );
      if (_hasError != null) throw Exception(_hasError);
      ret = true;
      loading.value = false;
      await refresh();
    } catch (e) {
      rethrow;
    } finally {
      loading.value = false;
    }
    return ret;
  }

  Future<bool> allocationWaste({
    required int id,
    required int comf_user_id,
    String? note,
  }) async {
    bool ret = false;
    if (loading.value) return ret;
    loading.value = true;
    try {
      String? _hasError;
      final res = await fetch(
        '/registers/$id/allocation',
        'PUT',
        body: {'id': id, 'comf_user_id': comf_user_id, 'note': note},
        onError: (msg) async {
          _hasError = msg;
          await Get.defaultDialog(
            middleText: msg,
            textConfirm: 'OK',
            confirmTextColor: Colors.white,
            onConfirm: () => Get.back(),
          );
          throw Exception(msg);
        },
      );
      if (_hasError != null) throw Exception(_hasError);
      ret = true;
      loading.value = false;
      await refresh();
    } catch (e) {
      rethrow;
    } finally {
      loading.value = false;
    }
    return ret;
  }

  Future<List<User>> getUsers([int? id]) async {
    List<User> users = [];

    try {
      String? _hasError;
      final res = await fetch(
        '/users',
        'GET',
        body: id == null ? {} : {"waste_id": id},
        onError: (msg) async {
          _hasError = msg;
          await Get.defaultDialog(
            middleText: msg,
            textConfirm: 'OK',
            confirmTextColor: Colors.white,
            onConfirm: () => Get.back(),
          );
          throw Exception(msg);
        },
      );
      if (_hasError != null) throw Exception(_hasError);
      for (var el in res) {
        users.add(User.fromJson(el));
      }
    } catch (e) {
      rethrow;
    } finally {}
    return users;
  }

  Future<Waste> getWaste({required int id}) async {
    final res = await fetch('/registers/$id', 'GET');
    return Waste.fromJson(res);
  }

  Map<String, dynamic> _getAimagCityFilter() {
    Map<String, dynamic> ret = {};
    final user = AuthController.user!;
    if (['mha', 'mhb', 'da'].contains(user.roles)) {
      ret['aimag_city_id'] = user.aimag_city_id;
      ret['soum_district_id'] = user.soum_district_id;
    }
    if (['hd', 'onb'].contains(user.roles)) {
      ret['bag_horoo_id'] = user.bag_horoo_id;
    }
    return ret;
  }
}
