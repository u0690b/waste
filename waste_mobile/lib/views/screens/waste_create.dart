import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';
import 'package:latlong2/latlong.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/utils/contants.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';
import 'package:waste_mobile/views/widgets/image_pick_list.dart';
import 'package:waste_mobile/views/widgets/location_map.dart';

class WasteCreate extends StatefulWidget {
  const WasteCreate({Key? key}) : super(key: key);

  @override
  State<WasteCreate> createState() => _WasteCreateState();
}

class _WasteCreateState extends State<WasteCreate> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          leading: Padding(
            padding: const EdgeInsets.all(8.0),
            child: MyBackButton(),
          ),
          backgroundColor: LightColors.kDarkYellow,
          foregroundColor: LightColors.kDarkBlue,
          title: const Text(
            'Бүртгэх',
            style: TextStyle(fontSize: 25.0, fontWeight: FontWeight.w700),
          ),
        ),
        body: const SafeArea(
          child: SingleChildScrollView(
            child: _RegisterForm(),
          ),
        ));
  }
}

class _RegisterForm extends StatefulWidget {
  const _RegisterForm({
    Key? key,
  }) : super(key: key);

  @override
  State<_RegisterForm> createState() => _RegisterFormState();
}

class _RegisterFormState extends State<_RegisterForm> {
  final _formKey = GlobalKey<FormState>();
  int? aimagCity;
  int? soumDistrict;
  int? bagHoroo;
  double? latitude;
  double? longitude;
  TextEditingController addressCtr = TextEditingController();
  TextEditingController descriptionCtr = TextEditingController();
  final List<Uint8List> _imageFileList = [];
  Uint8List? _videoFile;
  @override
  Widget build(BuildContext context) {
    var textButton = TextButton(
      style: TextButton.styleFrom(
          foregroundColor: Colors.white,
          backgroundColor:
              _videoFile == null ? Colors.orangeAccent : Colors.redAccent),
      onPressed: () {
        if (_videoFile != null) {
          setState(() {
            _videoFile = null;
          });
        } else {
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
                              final video = await ImagePicker().pickVideo(
                                source: ImageSource.camera,
                                maxDuration: const Duration(minutes: 3),
                              );
                              _videoFile = await video?.readAsBytes();
                              setState(() {});
                              Get.back();
                            },
                            child: const Text('Замер нээх')),
                        const Divider(),
                        TextButton(
                            onPressed: () async {
                              final video = await ImagePicker().pickVideo(
                                source: ImageSource.gallery,
                                maxDuration: const Duration(minutes: 3),
                              );
                              _videoFile = await video?.readAsBytes();
                              setState(() {});
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
        }
      },
      child: Text(
          textAlign: TextAlign.center,
          _videoFile == null
              ? 'Дүрс бичлэг хавсаргах'
              : 'Сонгосон дүрс бичлэг устгах'),
    );
    return Form(
      key: _formKey,
      autovalidateMode: AutovalidateMode.onUserInteraction,
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          LocationMap(
            longitude: longitude,
            latitude: latitude,
            onChangeLocation: (LatLng? latlng) {
              longitude = latlng?.longitude;
              latitude = latlng?.latitude;
            },
          ),
          Padding(
            padding: const EdgeInsets.all(20.0),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: <Widget>[
                DropdownButtonFormField(
                    validator: (p0) => p0 == null ? 'Заавал бөглөх' : null,
                    value: aimagCity,
                    decoration: InputDecoration(
                      labelText: "Аймаг,Нийслэл:",
                      contentPadding: const EdgeInsets.symmetric(
                          horizontal: 20.0, vertical: 15.0),
                      border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(5.0)),
                    ),
                    items: Constants.aimagCities
                        .map((e) => DropdownMenuItem(
                              value: e.id,
                              child: Text(e.name),
                            ))
                        .toList(),
                    onChanged: (int? value) {
                      setState(() {
                        aimagCity = value;
                        soumDistrict = null;
                        bagHoroo = null;
                      });
                    }),
                const SizedBox(height: 20),
                DropdownButtonFormField(
                  validator: (p0) => p0 == null ? 'Заавал бөглөх' : null,
                  decoration: InputDecoration(
                    labelText: "Сум,Дүүрэг",
                    contentPadding: const EdgeInsets.symmetric(
                        horizontal: 20.0, vertical: 15.0),
                    border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(5.0)),
                  ),
                  enableFeedback: aimagCity != null,
                  items: Constants.soumDistricts
                      .where((element) =>
                          element.aimag_city_id == (aimagCity ?? -1))
                      .map((e) => DropdownMenuItem(
                            value: e.id,
                            child: Text(e.name),
                          ))
                      .toList(),
                  value: soumDistrict,
                  onChanged: (int? value) {
                    setState(() {
                      soumDistrict = value;
                      bagHoroo = null;
                    });
                  },
                ),
                const SizedBox(height: 20),
                DropdownButtonFormField(
                  validator: (p0) => p0 == null ? 'Заавал бөглөх' : null,
                  decoration: InputDecoration(
                    labelText: "Баг,Хороо:",
                    contentPadding: const EdgeInsets.symmetric(
                        horizontal: 20.0, vertical: 15.0),
                    border: OutlineInputBorder(
                        borderRadius: BorderRadius.circular(5.0)),
                  ),
                  enableFeedback: soumDistrict != null,
                  items: Constants.bagHoroos
                      .where((element) =>
                          element.soum_district_id == (soumDistrict ?? -1))
                      .map((e) => DropdownMenuItem(
                            value: e.id,
                            child: Text(e.name),
                          ))
                      .toList(),
                  value: bagHoroo,
                  onChanged: (int? value) {
                    setState(() {
                      bagHoroo = value;
                    });
                  },
                ),
                const SizedBox(height: 20),
                TextFormField(
                  maxLength: 100,
                  controller: addressCtr,
                  validator: (value) {
                    return (value == null || value.isEmpty)
                        ? 'Хаяг тоот хоосон байна'
                        : null;
                  },
                  decoration: InputDecoration(
                    contentPadding: const EdgeInsets.symmetric(
                        horizontal: 20.0, vertical: 15.0),
                    labelText: 'Хаяг тоот:',
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(5.0),
                    ),
                  ),
                ),
                const SizedBox(height: 20),
                TextFormField(
                  maxLength: 500,
                  validator: (value) {
                    return (value == null || value.isEmpty)
                        ? 'Тайлбар хоосон байна'
                        : null;
                  },
                  decoration: InputDecoration(
                    contentPadding: const EdgeInsets.symmetric(
                        horizontal: 20.0, vertical: 15.0),
                    labelText: 'Тайлбар:',
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(5.0),
                    ),
                  ),
                  minLines: 3,
                  maxLines: 10,
                ),
                const SizedBox(height: 20),
                ImagePickerList(
                  item: _imageFileList,
                  onAdd: (Uint8List file) {
                    setState(() {
                      _imageFileList.add(file);
                    });
                  },
                  onDrop: (int index) {
                    setState(() {
                      _imageFileList.removeAt(index);
                    });
                  },
                  videoButton: textButton,
                ),
                const SizedBox(height: 20),
              ],
            ),
          ),
          SizedBox(
            height: 80,
            child: Padding(
              padding: const EdgeInsets.all(8.0),
              child: ElevatedButton(
                onPressed: () {
                  if (_formKey.currentState?.validate() ?? false) {
                    print('valodate');
                  }
                },
                child: const Text(
                  'Хадгалах',
                  style: TextStyle(
                      color: Colors.white,
                      fontWeight: FontWeight.w700,
                      fontSize: 18),
                ),
              ),
            ),
          ),
          const SizedBox(height: 20),
        ],
      ),
    );
  }
}
