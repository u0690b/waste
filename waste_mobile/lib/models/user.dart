// ignore_for_file: non_constant_identifier_names

class User {
  final int id;
  final String name;
  final String username;
  final int aimag_city_id;
  final int soum_district_id;
  final int bag_horoo_id;
  final String roles;
  final DateTime? created_at;
  final DateTime? updated_at;
  final String token;

  User({
    required this.id,
    required this.name,
    required this.username,
    required this.aimag_city_id,
    required this.soum_district_id,
    required this.bag_horoo_id,
    required this.roles,
    this.created_at,
    this.updated_at,
    required this.token,
  });

  Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        "username": username,
        "aimag_city_id": aimag_city_id,
        "soum_district_id": soum_district_id,
        "bag_horoo_id": bag_horoo_id,
        "roles": roles,
        "created_at": created_at,
        "updated_at": updated_at,
        "token": token,
      };

  static User fromJson(Map<String, dynamic> snap) {
    return User(
      id: snap['id'],
      name: snap['name'],
      username: snap['username'],
      aimag_city_id: snap['aimag_city_id'],
      soum_district_id: snap['soum_district_id'],
      bag_horoo_id: snap['bag_horoo_id'],
      roles: snap['roles'],
      created_at: DateTime.tryParse(snap['created_at']),
      updated_at: DateTime.tryParse(snap['updated_at']),
      token: snap['token'],
    );
  }
}
