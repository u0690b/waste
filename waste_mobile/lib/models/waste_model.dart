// ignore_for_file: non_constant_identifier_names

import 'package:flutter/foundation.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/utils/contants.dart';

class WasteModel {
  int? index;
  double? long;
  double? lat;
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
  String? ner;
  List<Uint8List>? imageFileList = [];
  Uint8List? videoFile;

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
    this.ner,
  });

  Map<String, dynamic> toJson() => {
        'long': long,
        'lat': lat,
        'register': register,
        'ner': ner,
        'description': description,
        'resolve_desc': resolve_desc,
        'reason_id': reason_id,
        'status_id': status_id,
        'aimag_city_id': aimag_city_id,
        'soum_district_id': soum_district_id,
        'bag_horoo_id': bag_horoo_id,
        'address': address,
        'user_id': user_id,
        'images': imageFileList?.map((e) => e.toList()).toList() ?? [],
        'video': videoFile?.toList() ?? [],
        'created_at': created_at,
        'updated_at': updated_at,
      };

  static WasteModel fromJson(Map<String, dynamic> snap) {
    return WasteModel(
      long: double.tryParse(snap['long'].toString()) ?? 0,
      lat: double.tryParse(snap['lat'].toString()) ?? 0,
      register: snap['register'],
      ner: snap['ner'],
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
          ? (snap['images'] as List).map((e) {
              var hah = (e as List<dynamic>).map((v) => v as int).toList();
              return Uint8List.fromList(hah);
            }).toList()
          : [],
      videoFile: snap['video'] != null && (snap['video'] as List).isNotEmpty
          ? Uint8List.fromList(
              (snap['video'] as List).map((e) => e as int).toList())
          : null,
      created_at: DateTime.tryParse(snap['created_at'] ?? ''),
      updated_at: DateTime.tryParse(snap['updated_at'] ?? ''),
    );
  }
}
