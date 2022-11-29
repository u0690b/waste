// ignore_for_file: non_constant_identifier_names

class Waste {
  final int id;
  final double long;
  final double lat;
  final String description;
  final String? resolve_desc;
  final int reason_id;
  final int status_id;
  final int aimag_city_id;
  final int soum_district_id;
  final int bag_horoo_id;
  final String? address;
  final int user_id;
  final DateTime? created_at;
  final DateTime? updated_at;

  Waste({
    required this.id,
    required this.long,
    required this.lat,
    required this.description,
    required this.resolve_desc,
    required this.reason_id,
    required this.status_id,
    required this.aimag_city_id,
    required this.soum_district_id,
    required this.bag_horoo_id,
    this.address,
    required this.user_id,
    this.created_at,
    this.updated_at,
  });

  Map<String, dynamic> toJson() => {
        'id': id,
        'long': long,
        'lat': lat,
        'description': description,
        'resolve_desc': resolve_desc,
        'reason_id': reason_id,
        'status_id': status_id,
        'aimag_city_id': aimag_city_id,
        'soum_district_id': soum_district_id,
        'bag_horoo_id': bag_horoo_id,
        'address': address,
        'user_id': user_id,
        'created_at': created_at,
        'updated_at': updated_at,
      };

  static Waste fromJson(Map<String, dynamic> snap) {
    return Waste(
      id: snap['id'],
      long: double.tryParse(snap['long'].toString()) ?? 0,
      lat: double.tryParse(snap['lat'].toString()) ?? 0,
      description: snap['description'],
      resolve_desc: snap['resolve_desc'],
      reason_id: snap['reason_id'],
      status_id: snap['status_id'],
      aimag_city_id: snap['aimag_city_id'],
      soum_district_id: snap['soum_district_id'],
      bag_horoo_id: snap['bag_horoo_id'],
      address: snap['address'],
      user_id: snap['user_id'],
      created_at: DateTime.tryParse(snap['created_at']),
      updated_at: DateTime.tryParse(snap['updated_at']),
    );
  }
}
