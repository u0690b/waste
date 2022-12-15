import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';

class ImagePickerList extends StatelessWidget {
  final List<List<int>> item;
  final void Function(List<int> file) onAdd;
  final void Function(int index) onDrop;
  final TextButton videoButton;
  final Function()? onPlay;
  const ImagePickerList({
    super.key,
    required this.item,
    required this.onAdd,
    required this.onDrop,
    required this.videoButton,
    this.onPlay,
  });

  @override
  Widget build(BuildContext context) {
    return GridView.count(
        shrinkWrap: true,
        physics: const NeverScrollableScrollPhysics(),
        primary: false,
        padding: const EdgeInsets.all(20),
        crossAxisSpacing: 10,
        mainAxisSpacing: 10,
        crossAxisCount: 2,
        children: [
          if (onPlay != null)
            GestureDetector(
              onTap: onPlay,
              child: const Text('Бичлэг үзэх'),
            ),
          for (var i = 0; i < item.length; i++)
            GestureDetector(
              onLongPress: () {
                Get.defaultDialog(
                    title: "Зураг устгах",
                    middleText: 'Сонгогдсон зургийг устгах уу',
                    textConfirm: 'Тийм',
                    textCancel: 'Хаах',
                    onConfirm: () {
                      onDrop(i);
                      Get.back();
                    },
                    onCancel: () => {});
              },
              child: Image.memory(Uint8List.fromList(item[i])),
            ),
          if (item.length % 2 == 1) const SizedBox(),
          TextButton(
            style: TextButton.styleFrom(
                foregroundColor: Colors.white,
                backgroundColor: Colors.blueAccent),
            child: const Text('Зураг нэмэх'),
            onPressed: () async {
              showDialog(
                context: context,
                builder: (context) {
                  return Column(
                    mainAxisAlignment: MainAxisAlignment.end,
                    mainAxisSize: MainAxisSize.max,
                    crossAxisAlignment: CrossAxisAlignment.stretch,
                    children: [
                      Container(
                        color: LightColors.kDarkBlue,
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.stretch,
                          children: [
                            TextButton(
                                onPressed: () async {
                                  final image = await ImagePicker().pickImage(
                                    source: ImageSource.camera,
                                    maxWidth: 1500,
                                    maxHeight: 1500,
                                    imageQuality: 90,
                                  );

                                  if (image != null) {
                                    onAdd(await image.readAsBytes());
                                  }
                                  Get.back();
                                },
                                child: const Text('Замер нээх')),
                            const Divider(),
                            TextButton(
                                onPressed: () async {
                                  final List<XFile> pickedFileList =
                                      await ImagePicker().pickMultiImage(
                                    maxWidth: 1500,
                                    maxHeight: 1500,
                                    imageQuality: 90,
                                  );
                                  for (var i = 0;
                                      i < pickedFileList.length;
                                      i++) {
                                    var list =
                                        await pickedFileList[i].readAsBytes();
                                    onAdd(list);
                                  }
                                  Get.back();
                                },
                                child: const Text('Галерей нээх')),
                            const Divider(),
                            TextButton(
                                onPressed: Get.back, child: const Text('Хаах'))
                          ],
                        ),
                      ),
                    ],
                  );
                },
              );
            },
          ),
          videoButton,
        ]);
  }
}
