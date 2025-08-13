// ignore_for_file: non_constant_identifier_names

import 'package:waste_mobile/models/model.dart';

class User {
  final int id;
  final String name;
  final String username;
  final int aimag_city_id;
  final NameModel? aimag_city;
  final int? soum_district_id;
  final NameModel? soum_district;
  final int? bag_horoo_id;
  final NameModel? bag_horoo;
  final String roles;

  final DateTime? created_at;
  final DateTime? updated_at;
  final String token;

  User({
    required this.id,
    required this.name,
    required this.username,
    required this.aimag_city_id,
    this.aimag_city,
    this.soum_district_id,
    this.soum_district,
    this.bag_horoo_id,
    this.bag_horoo,
    required this.roles,
    this.created_at,
    this.updated_at,
    required this.token,
  });
  String get address {
    return "${aimag_city?.name ?? ''} ${soum_district?.name ?? ''} ${bag_horoo?.name ?? ''} ";
  }

  bool get isMH => ['mhb', 'mha'].contains(roles);
  bool get isMHA => ['mha'].contains(roles);

  Map<String, dynamic> toJson() => {
    "id": id,
    "name": name,
    "username": username,
    "aimag_city_id": aimag_city_id,
    "aimag_city": aimag_city?.toJson(),
    "soum_district_id": soum_district_id,
    "soum_district": soum_district?.toJson(),
    "bag_horoo_id": bag_horoo_id,
    "bag_horoo": bag_horoo?.toJson(),
    "roles": roles,

    "created_at": created_at?.toIso8601String(),
    "updated_at": updated_at?.toIso8601String(),
    "token": token,
  };
  static List<String> positions = [
    "Захирагчийн ажлын алба",
    "МХ байцаагч",
    "Дүүргийн ЗДТГ",
    "Хорооны засаг дарга",
    "Олон нийтийн байцаагч",
    "Хэсгийн ахлагч",
    "Байгаль орчин, аялал жуулчлалын яам",
    "Барилга, хот байгуулалтын яам",
    "Эрүүл мэндийн яам",
  ];
  static User fromJson(Map<String, dynamic> snap) {
    return User(
      id: snap['id'],
      name: snap['name'].toString(),
      username: snap['username'].toString(),
      aimag_city_id: snap['aimag_city_id'],
      aimag_city:
          snap['aimag_city'] == null
              ? null
              : NameModel.fromJson(snap['aimag_city']),
      soum_district_id: snap['soum_district_id'],
      soum_district:
          snap['soum_district'] == null
              ? null
              : NameModel.fromJson(snap['soum_district']),
      bag_horoo_id: snap['bag_horoo_id'],
      bag_horoo:
          snap['bag_horoo'] == null
              ? null
              : NameModel.fromJson(snap['bag_horoo']),
      roles: snap['roles'].toString(),

      created_at:
          snap['created_at'] == null
              ? null
              : DateTime.tryParse(snap['created_at']),
      updated_at:
          snap['updated_at'] == null
              ? null
              : DateTime.tryParse(snap['updated_at']),
      token: snap['token'] ?? '',
    );
  }
}
