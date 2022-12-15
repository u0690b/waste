// ignore_for_file: non_constant_identifier_names

import 'package:waste_mobile/models/attached_file.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/utils/contants.dart';

class Waste {
  late int id;
  late String name;
  String? register;
  late String chiglel;
  late int aimagCityId;
  late int soumDistrictId;
  late int bagHorooId;
  late String address;
  late String description;
  late int reasonId;
  String? zuilZaalt;
  String? resolveDesc;
  late num long;
  late num lat;
  late int regUserId;
  int? comfUserId;
  late int statusId;
  DateTime? createdAt;
  DateTime? updatedAt;
  late NameModel regUser;
  late List<AttachedFile> imgs;
  late AttachedFile? video;
  NameModel get reason =>
      Constants.reasons.firstWhere((element) => element.id == reasonId,
          orElse: () => NameModel(name: '', id: -1));
  NameModel get status =>
      Constants.status.firstWhere((element) => element.id == statusId,
          orElse: () => NameModel(name: '', id: -1));
  NameModel get aimag_city =>
      Constants.aimagCities.firstWhere((element) => element.id == aimagCityId,
          orElse: () => NameModel(name: '', id: -1));
  NameModel get soum_district => Constants.soumDistricts.firstWhere(
      (element) => element.id == soumDistrictId,
      orElse: () => NameModel(name: '', id: -1));
  NameModel get bag_horoo =>
      Constants.bagHoroos.firstWhere((element) => element.id == bagHorooId,
          orElse: () => NameModel(name: '', id: -1));

  String fullAddress() {
    return "${aimag_city.name} ${soum_district.name} ${bag_horoo.name} $address";
  }

  Waste({
    required this.id,
    required this.name,
    this.register,
    required this.chiglel,
    required this.aimagCityId,
    required this.soumDistrictId,
    required this.bagHorooId,
    required this.address,
    required this.description,
    required this.reasonId,
    this.zuilZaalt,
    this.resolveDesc,
    required this.long,
    required this.lat,
    required this.regUserId,
    this.comfUserId,
    required this.statusId,
    this.createdAt,
    this.updatedAt,
    required this.imgs,
    this.video,
    required this.regUser,
  });

  Map<String, dynamic> toJson() => {
        'id': id,
        'name': name,
        'register': register,
        'chiglel': chiglel,
        'aimag_city_id': aimagCityId,
        'soum_district_id': soumDistrictId,
        'bag_horoo_id': bagHorooId,
        'address': address,
        'description': description,
        'reason_id': reasonId,
        'zuil_zaalt': zuilZaalt,
        'resolve_desc': resolveDesc,
        'long': long,
        'lat': lat,
        'reg_user_id': regUserId,
        'comf_user_id': comfUserId,
        'status_id': statusId,
        'created_at': createdAt,
        'updated_at': updatedAt,
      };

  Waste.fromJson(Map<String, dynamic> snap) {
    id = snap['id'];
    name = snap['name'];
    register = snap['register'];
    chiglel = snap['chiglel'];
    aimagCityId = snap['aimag_city_id'];
    soumDistrictId = snap['soum_district_id'];
    bagHorooId = snap['bag_horoo_id'];
    address = snap['address'];
    description = snap['description'];
    reasonId = snap['reason_id'];
    zuilZaalt = snap['zuil_zaalt'];
    resolveDesc = snap['resolve_desc'];
    long = snap['long'] as num;
    lat = snap['lat'] as num;
    regUserId = snap['reg_user_id'];
    regUser = NameModel.fromJson(snap['reg_user']);
    comfUserId = snap['comf_user_id'];
    statusId = snap['status_id'];
    createdAt = DateTime.tryParse(snap['created_at']);
    updatedAt = DateTime.tryParse(snap['updated_at']);
    imgs = snap['attached_images'] != null
        ? (snap['attached_images'] as List)
            .map((e) => AttachedFile.fromJson(e))
            .toList()
        : [];
    video = snap['attached_video'] != null
        ? AttachedFile.fromJson(snap['attached_video'])
        : null;
  }
}
