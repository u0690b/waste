// ignore_for_file: non_constant_identifier_names

import 'package:waste_mobile/models/attached_file.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/utils/contants.dart';

class Waste {
  late int id;
  late String whois;
  late String name;
  String? register;
  String? chiglel;
  late int aimagCityId;
  late int soumDistrictId;
  late int bagHorooId;
  late String address;
  late String description;
  late int reasonId;
  String? zuilZaalt;
  String? resolveDesc;
  int? resolveId;
  String? resolveImage;
  late num long;
  late num lat;
  late int regUserId;
  int? comfUserId;
  late int statusId;
  DateTime? createdAt;
  DateTime? updatedAt;
  late NameModel regUser;
  late NameModel? comfUser;

  late List<AttachedFile> imgs;
  late AttachedFile? video;
  DateTime? reg_at;

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
  NameModel? get resolve {
    final s =
        Constants.resolves.indexWhere((element) => element.id == resolveId);
    return s == -1 ? null : Constants.resolves[s];
  }

  String fullAddress() {
    return "${aimag_city.name} ${soum_district.name} ${bag_horoo.name} $address";
  }

  Waste({
    required this.id,
    required this.whois,
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
    this.reg_at,
    this.resolveId,
    this.resolveDesc,
    this.resolveImage,
    this.comfUser,
  });

  Map<String, dynamic> toJson() => {
        'id': id,
        'whois': whois,
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
        'resolve_id': this.resolveId,
        'resolve_image': this.resolveImage,
        'long': long,
        'lat': lat,
        'reg_user_id': regUserId,
        'comf_user_id': comfUserId,
        'comf_user': comfUser,
        'status_id': statusId,
        'created_at': createdAt?.toIso8601String(),
        'updated_at': updatedAt?.toIso8601String(),
        'reg_at': reg_at?.toIso8601String(),
      };

  Waste.fromJson(Map<String, dynamic> snap) {
    id = snap['id'];
    whois = snap['whois'];
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

    long = snap['long'] as num;
    lat = snap['lat'] as num;
    regUserId = snap['reg_user_id'];
    regUser = NameModel.fromJson(snap['reg_user']);
    comfUserId = snap['comf_user_id'];
    comfUser = snap['comf_user'] != null
        ? NameModel.fromJson(snap['comf_user'])
        : null;
    statusId = snap['status_id'];
    resolveId = snap['resolve_id'];
    resolveDesc = snap['resolve_desc'];
    resolveImage = snap['resolve_image'];
    createdAt = snap['created_at'] == null
        ? null
        : DateTime.tryParse(snap['created_at']);
    updatedAt = snap['created_at'] == null
        ? null
        : DateTime.tryParse(snap['updated_at']);
    reg_at =
        snap['created_at'] == null ? null : DateTime.tryParse(snap['reg_at']);

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
