// ignore_for_file: non_constant_identifier_names

class Notification {
  int id;
  String type;
  String title;
  String content;
  int? rid;
  DateTime? read_at;
  DateTime? created_at;

  Notification({
    required this.id,
    required this.type,
    required this.title,
    required this.content,
    this.rid,
    this.read_at,
    this.created_at,
  });

  Map<String, dynamic> toJson() => {
        'id': id,
        'type': type,
        'title': title,
        'content': content,
        'rid': rid,
        'read_at': read_at?.toIso8601String(),
        'created_at': created_at?.toIso8601String(),
      };

  factory Notification.fromJson(Map<String, dynamic> snap) => Notification(
        id: snap['id'],
        type: snap['type'],
        title: snap['title'],
        content: snap['content'],
        rid: snap['rid'],
        read_at:
            snap['read_at'] == null ? null : DateTime.tryParse(snap['read_at']),
        created_at: snap['created_at'] == null
            ? null
            : DateTime.tryParse(snap['created_at']),
      );
}
