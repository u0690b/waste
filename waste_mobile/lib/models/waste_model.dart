// ignore_for_file: non_constant_identifier_names

import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/utils/contants.dart';

class WasteModel {
  int? index;
  double? long;
  double? lat;
  String? chiglel;
  String? zuil_zaalt;
  String? description;
  String? resolve_desc;
  int? reason_id;
  int? status_id;
  int? aimag_city_id;
  int? soum_district_id;
  int? bag_horoo_id;
  String? address;
  int? user_id;
  String? register;
  String? name;
  List<List<int>>? imageFileList = [];
  List<int>? videoFile;

  DateTime? created_at;
  DateTime? updated_at;

  NameModel get reason =>
      Constants.reasons.firstWhere((element) => element.id == reason_id,
          orElse: () => NameModel(name: '', id: -1));
  NameModel get status =>
      Constants.status.firstWhere((element) => element.id == status_id,
          orElse: () => NameModel(name: '', id: -1));
  NameModel get aimag_city =>
      Constants.aimagCities.firstWhere((element) => element.id == aimag_city_id,
          orElse: () => NameModel(name: '', id: -1));
  NameModel get soum_district => Constants.soumDistricts.firstWhere(
      (element) => element.id == soum_district_id,
      orElse: () => NameModel(name: '', id: -1));
  NameModel get bag_horoo =>
      Constants.bagHoroos.firstWhere((element) => element.id == bag_horoo_id,
          orElse: () => NameModel(name: '', id: -1));

  String fullAddress() {
    return "${aimag_city.name} ${soum_district.name} ${bag_horoo.name}";
  }

  WasteModel({
    this.long,
    this.lat,
    this.chiglel,
    this.zuil_zaalt,
    this.description,
    this.resolve_desc,
    this.reason_id,
    this.status_id,
    this.aimag_city_id,
    this.soum_district_id,
    this.bag_horoo_id,
    this.address,
    required this.user_id,
    this.created_at,
    this.updated_at,
    this.imageFileList,
    this.videoFile,
    this.register,
    this.name,
  });

  Map<String, dynamic> toJson([isLocal = true]) => {
        'long': long,
        'lat': lat,
        'register': register,
        'name': name,
        'chiglel': chiglel,
        'zuil_zaalt': zuil_zaalt,
        'description': description,
        'resolve_desc': resolve_desc,
        'reason_id': reason_id,
        'status_id': status_id,
        'aimag_city_id': aimag_city_id,
        'soum_district_id': soum_district_id,
        'bag_horoo_id': bag_horoo_id,
        'address': address,
        'user_id': user_id,
        if (isLocal) 'images': imageFileList ?? [],
        if (isLocal) 'video': videoFile,
        'created_at': created_at,
        'updated_at': updated_at,
      };

  static WasteModel fromJson(Map<String, dynamic> snap) {
    return WasteModel(
      long: double.tryParse(snap['long'].toString()) ?? 0,
      lat: double.tryParse(snap['lat'].toString()) ?? 0,
      register: snap['register'],
      name: snap['name'],
      chiglel: snap['chiglel'],
      zuil_zaalt: snap['zuil_zaalt'],
      description: snap['description'],
      resolve_desc: snap['resolve_desc'],
      reason_id: snap['reason_id'],
      status_id: snap['status_id'],
      aimag_city_id: snap['aimag_city_id'],
      soum_district_id: snap['soum_district_id'],
      bag_horoo_id: snap['bag_horoo_id'],
      address: snap['address'],
      user_id: snap['user_id'],
      imageFileList: snap['images'] != null
          ? (snap['images'] as List)
              .map((e) => (e as List).map((v) => v as int).toList())
              .toList()
          : [],
      videoFile: snap['video'] != null
          ? (snap['video'] as List).map((e) => e as int).toList()
          : null,
      created_at: DateTime.tryParse(snap['created_at'] ?? ''),
      updated_at: DateTime.tryParse(snap['updated_at'] ?? ''),
    );
  }
}
