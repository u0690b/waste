// ignore_for_file: non_constant_identifier_names

class AttachedFile {
  late int id;
  late int register_id;
  late String path;
  late String? type;

  AttachedFile({
    required this.id,
    required this.register_id,
    required this.path,
    this.type,
  });

  Map<String, dynamic> toJson() => {
        'id': id,
        'register_id': register_id,
        'path': path,
        'type': type,
      };

  AttachedFile.fromJson(Map<String, dynamic> snap) {
    id = snap[id];
    register_id = snap[register_id];
    path = snap[path];
    type = snap[type];
  }
}
