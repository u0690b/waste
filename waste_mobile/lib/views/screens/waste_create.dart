import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:image_picker/image_picker.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/models/waste_model.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/utils/contants.dart';
import 'package:waste_mobile/views/screens/video_payer_file.dart';
import 'package:waste_mobile/views/widgets/back_button.dart';
import 'package:waste_mobile/views/widgets/company_name.dart';
import 'package:waste_mobile/views/widgets/company_uachiglel_field.dart';
import 'package:waste_mobile/views/widgets/future_alert_dialog.dart';
import 'package:waste_mobile/views/widgets/image_pick_list.dart';
import 'package:waste_mobile/views/widgets/location_map.dart';

class WasteCreate extends StatefulWidget {
  final WasteController wasteController;
  const WasteCreate({Key? key, required this.wasteController})
    : super(key: key);

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
      body: SafeArea(
        child: WasteRegisterForm(
          onSave:
              (value) => futureAlertDialog(
                context: context,
                futureStream: widget.wasteController.addLocalModels(value),
                autoCloseSec: 1,
              ),
        ),
      ),
    );
  }
}

class WasteRegisterForm extends StatefulWidget {
  final WasteModel? model;
  final Future<void> Function(WasteModel value) onSave;
  const WasteRegisterForm({Key? key, this.model, required this.onSave})
    : super(key: key);

  @override
  State<WasteRegisterForm> createState() => WasteRegisterFormState();
}

class WasteRegisterFormState extends State<WasteRegisterForm> {
  final _formKey = GlobalKey<FormState>();
  late String whois;
  TextEditingController ner = TextEditingController();
  TextEditingController register = TextEditingController();
  int? aimagCity;
  int? soumDistrict;
  int? bagHoroo;
  double? latitude;
  double? longitude;
  String? address;
  String? description;
  TextEditingController chiglel = TextEditingController();
  String? zuil_zaalt;
  int? reason;
  List<List<int>> _imageFileList = [];
  List<int>? _videoFile;
  TextEditingController registerController = TextEditingController();
  @override
  void initState() {
    if (widget.model != null) {
      whois = widget.model!.whois ?? 'Иргэн';
      aimagCity = widget.model!.aimag_city_id;
      soumDistrict = widget.model!.soum_district_id;
      bagHoroo = widget.model!.bag_horoo_id;
      latitude = widget.model!.lat;
      longitude = widget.model!.long;
      address = widget.model!.address;
      description = widget.model!.description;
      _imageFileList = widget.model!.imageFileList ?? [];
      _videoFile = widget.model!.videoFile;
      ner.text = widget.model!.name ?? '';
      register.text = widget.model!.register ?? '';
      registerController.text = widget.model!.register ?? '';
      chiglel.text = widget.model!.chiglel ?? '';
      zuil_zaalt = widget.model!.zuil_zaalt;
      reason = widget.model!.reason_id;
      isChecked = register.text == 'Эзэнгүй';
    } else {
      whois = 'Иргэн';
      aimagCity = AuthController.user?.aimag_city_id;
      soumDistrict = AuthController.user?.soum_district_id;
      bagHoroo = AuthController.user?.bag_horoo_id;
    }
    super.initState();
  }

  bool isChecked = false;
  @override
  Widget build(BuildContext context) {
    var textButton = TextButton(
      style: TextButton.styleFrom(
        foregroundColor: Colors.white,
        backgroundColor:
            _videoFile == null ? Colors.orangeAccent : Colors.redAccent,
      ),
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
                            );

                            _videoFile = (await video?.readAsBytes())?.toList();
                            setState(() {});
                            Get.back();
                          },
                          child: const Text('Камер нээх'),
                        ),
                        const Divider(),
                        TextButton(
                          onPressed: () async {
                            final video = await ImagePicker().pickVideo(
                              source: ImageSource.gallery,
                              maxDuration: const Duration(minutes: 3),
                            );
                            _videoFile = (await video?.readAsBytes())?.toList();
                            setState(() {});
                            Get.back();
                          },
                          child: const Text('Зургийн сан нээх'),
                        ),
                        const Divider(),
                        TextButton(
                          onPressed: Get.back,
                          child: const Text('Хаах'),
                        ),
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
            : 'Сонгосон дүрс бичлэг устгах',
      ),
    );
    Key industryKey = Key('industryKey');
    return Form(
      key: _formKey,
      autovalidateMode: AutovalidateMode.onUserInteraction,
      child: Column(
        children: [
          Expanded(
            child: SingleChildScrollView(
              child: Column(
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
                        Row(
                          children: [
                            Text(
                              'Иргэн',
                              style: TextStyle(
                                fontWeight:
                                    whois == 'Иргэн'
                                        ? FontWeight.bold
                                        : FontWeight.normal,
                              ),
                            ),
                            Switch(
                              value: whois != 'Иргэн',
                              onChanged: (val) {
                                setState(() {
                                  whois = val ? 'Хуулийн этгээд' : 'Иргэн';
                                });
                              },
                            ),
                            Text(
                              'Хуулийн этгээд',
                              style: TextStyle(
                                fontWeight:
                                    whois == 'Хуулийн этгээд'
                                        ? FontWeight.bold
                                        : FontWeight.normal,
                              ),
                            ),
                            Expanded(child: SizedBox()),
                            // Checkbox(
                            //   onChanged: (value) {
                            //     setState(() {
                            //       isChecked = value!;
                            //       if (isChecked) {
                            //         register.text = 'Эзэнгүй';
                            //         registerController.text = 'Эзэнгүй';
                            //         ner.text = 'Эзэнгүй';
                            //       } else {
                            //         register.text = '';
                            //         registerController.text = '';
                            //         ner.text = '';
                            //       }
                            //     });
                            //   },
                            //   value: isChecked,
                            // ),
                            // Text(
                            //   'Эзэнгүй',
                            //   style: TextStyle(fontWeight: FontWeight.normal),
                            // ),
                          ],
                        ),
                        if (!isChecked) ...[
                          //Албан байгууллага, Иргэний овог нэр:
                          if (whois != 'Хуулийн этгээд')
                            TextFormField(
                              maxLength: 100,
                              controller: ner,
                              validator: (value) {
                                return (value == null || value.isEmpty)
                                    ? 'Нэр хоосон байна'
                                    : null;
                              },
                              decoration: InputDecoration(
                                contentPadding: const EdgeInsets.symmetric(
                                  horizontal: 20.0,
                                  vertical: 15.0,
                                ),
                                labelText:
                                    whois == 'Хуулийн этгээд'
                                        ? 'Албан байгууллага нэр'
                                        : 'Иргэний овог нэр:',
                                border: OutlineInputBorder(
                                  borderRadius: BorderRadius.circular(5.0),
                                ),
                              ),
                            )
                          else
                            CompanyNameFormField(
                              changeCompanyName: (val) => ner.text = val,
                              changeRegister:
                                  (val, industy) => setState(() {
                                    register.text = val;
                                    registerController.text = val;
                                    chiglel.text = industy;
                                    industryKey = Key(industy);
                                  }),
                              initText: ner.text,
                            ),
                          const SizedBox(height: 20),
                          // Албан байгууллага, Иргэний  регистр:
                          TextFormField(
                            controller: registerController,
                            maxLength: 15,
                            onChanged: (value) => register.text = value,
                            decoration: InputDecoration(
                              contentPadding: const EdgeInsets.symmetric(
                                horizontal: 20.0,
                                vertical: 15.0,
                              ),
                              labelText:
                                  whois == 'Хуулийн этгээд'
                                      ? 'Албан байгууллага регистр'
                                      : 'Иргэний овог регистр:',
                              border: OutlineInputBorder(
                                borderRadius: BorderRadius.circular(5.0),
                              ),
                            ),
                          ),
                          const SizedBox(height: 20),
                          // Үйл Ажиллагааны чиглэл
                          CompanyUAChiglelFormField(
                            initText: chiglel.text,
                            textEditingController: chiglel,
                          ),
                        ],
                        const SizedBox(height: 20),
                        // Аймаг,Нийслэл:
                        DropdownButtonFormField(
                          isExpanded: true,
                          validator:
                              (p0) => p0 == null ? 'Заавал бөглөх' : null,
                          decoration: InputDecoration(
                            labelText: "Аймаг,Нийслэл:",
                            contentPadding: const EdgeInsets.symmetric(
                              horizontal: 20.0,
                              vertical: 15.0,
                            ),
                            border: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(5.0),
                            ),
                          ),
                          enableFeedback: aimagCity == null,
                          items:
                              Constants.aimagCities
                                  .map(
                                    (e) => DropdownMenuItem(
                                      value: e.id,
                                      child: Text(
                                        e.name,
                                        overflow: TextOverflow.ellipsis,
                                      ),
                                    ),
                                  )
                                  .toList(),
                          value: aimagCity,
                          onChanged: (int? value) {
                            setState(() {
                              aimagCity = value;
                              soumDistrict = null;
                              bagHoroo = null;
                            });
                          },
                        ),
                        const SizedBox(height: 20),

                        //  Сум,Дүүрэг
                        DropdownButtonFormField(
                          validator:
                              (p0) =>
                                  p0 == null &&
                                          aimagCity != null &&
                                          aimagCity! <= 22
                                      ? 'Заавал бөглөх'
                                      : null,
                          decoration: InputDecoration(
                            labelText: "Сум,Дүүрэг",
                            contentPadding: const EdgeInsets.symmetric(
                              horizontal: 20.0,
                              vertical: 15.0,
                            ),
                            border: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(5.0),
                            ),
                          ),
                          enableFeedback: aimagCity == null,
                          items:
                              Constants.soumDistricts
                                  .where(
                                    (el) =>
                                        el.aimag_city_id == (aimagCity ?? -1),
                                  )
                                  .map(
                                    (e) => DropdownMenuItem(
                                      value: e.id,
                                      child: Text(e.name),
                                    ),
                                  )
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
                        // Баг,Хороо:
                        DropdownButtonFormField(
                          isExpanded: true,
                          validator:
                              (p0) =>
                                  p0 == null &&
                                          aimagCity != null &&
                                          aimagCity! <= 22
                                      ? 'Заавал бөглөх'
                                      : null,
                          decoration: InputDecoration(
                            labelText: "Баг,Хороо:",
                            contentPadding: const EdgeInsets.symmetric(
                              horizontal: 20.0,
                              vertical: 15.0,
                            ),
                            border: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(5.0),
                            ),
                          ),
                          enableFeedback: soumDistrict != null,
                          items:
                              Constants.bagHoroos
                                  .where(
                                    (element) =>
                                        element.soum_district_id ==
                                        (soumDistrict ?? -1),
                                  )
                                  .map(
                                    (e) => DropdownMenuItem(
                                      value: e.id,
                                      child: Text(
                                        e.name,
                                        overflow: TextOverflow.ellipsis,
                                      ),
                                    ),
                                  )
                                  .toList(),
                          value: bagHoroo,
                          onChanged: (int? value) {
                            setState(() {
                              bagHoroo = value;
                            });
                          },
                        ),
                        const SizedBox(height: 20),
                        // Хаяг тоот, утас
                        TextFormField(
                          maxLength: 100,
                          initialValue: address,
                          validator: (value) {
                            return (value == null || value.isEmpty)
                                ? 'Хаяг тоот, утас хоосон байна'
                                : null;
                          },
                          onChanged: (value) => address = value,
                          decoration: InputDecoration(
                            contentPadding: const EdgeInsets.symmetric(
                              horizontal: 20.0,
                              vertical: 15.0,
                            ),
                            labelText: 'Хаяг тоот, утас:',
                            border: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(5.0),
                            ),
                          ),
                        ),
                        const SizedBox(height: 20),
                        // Гаргасан зөрчлийн байдал:
                        TextFormField(
                          maxLength: 1000,
                          validator: (value) {
                            return (value == null || value.isEmpty)
                                ? 'Гаргасан зөрчлийн байдал'
                                : null;
                          },
                          initialValue: description,
                          onChanged: (value) => description = value,
                          decoration: InputDecoration(
                            contentPadding: const EdgeInsets.symmetric(
                              horizontal: 20.0,
                              vertical: 15.0,
                            ),
                            labelText: 'Гаргасан зөрчлийн байдал:',
                            border: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(5.0),
                            ),
                          ),
                          minLines: 3,
                          maxLines: 10,
                        ),
                        const SizedBox(height: 20),
                        // Зөрчлийн төрөл:
                        DropdownButtonFormField(
                          validator:
                              (p0) => p0 == null ? 'Заавал бөглөх' : null,
                          value: reason,
                          decoration: InputDecoration(
                            labelText: "Зөрчлийн төрөл:",
                            contentPadding: const EdgeInsets.symmetric(
                              horizontal: 20.0,
                              vertical: 15.0,
                            ),
                            border: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(5.0),
                            ),
                          ),
                          selectedItemBuilder: (context) {
                            return Constants.reasons
                                .map(
                                  (e) => Container(
                                    width: Get.width - 105,
                                    child: Text(
                                      e.name,
                                      overflow: TextOverflow.ellipsis,
                                    ),
                                  ),
                                )
                                .toList();
                          },
                          items:
                              Constants.reasons
                                  .map(
                                    (e) => DropdownMenuItem(
                                      value: e.id,
                                      child: Column(
                                        crossAxisAlignment:
                                            CrossAxisAlignment.start,
                                        mainAxisSize: MainAxisSize.min,
                                        children: [
                                          Text(
                                            e.descrip ?? '',
                                            style: TextStyle(fontSize: 8),
                                          ),
                                          Text(
                                            "    " + e.name,
                                            style: TextStyle(fontSize: 12),
                                          ),
                                        ],
                                      ),
                                    ),
                                  )
                                  .toList(),
                          onChanged: (int? value) {
                            setState(() {
                              reason = value;
                            });
                          },
                        ),
                        const SizedBox(height: 20),
                        // Зөрчсөн хууль тогтоомжийн зүйл, заалт
                        TextFormField(
                          maxLength: 500,
                          initialValue: zuil_zaalt,
                          onChanged: (value) => zuil_zaalt = value,
                          decoration: InputDecoration(
                            contentPadding: const EdgeInsets.symmetric(
                              horizontal: 20.0,
                              vertical: 15.0,
                            ),
                            labelText:
                                'Зөрчсөн хууль тогтоомжийн зүйл, заалт тайлбар:',
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
                          onAdd: (List<int> file) {
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
                          onPlay:
                              _videoFile == null
                                  ? null
                                  : () {
                                    Get.dialog(
                                      MyVideoPlayerFile(file: _videoFile!),
                                    );
                                  },
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
                        onPressed: () async {
                          if (_formKey.currentState?.validate() ?? false) {
                            if (latitude == null || longitude == null) {
                              await Get.defaultDialog(
                                middleText:
                                    'Газрын зураг дээрх байршил сонгоогүй байна',
                              );
                              return;
                            }
                            if (_imageFileList.length == 0) {
                              await Get.defaultDialog(
                                middleText: 'Зураг хоосон байна',
                              );
                              return;
                            }
                            final w = WasteModel(
                              user_id: AuthController.user!.id,
                              aimag_city_id: aimagCity,
                              bag_horoo_id: bagHoroo,
                              soum_district_id: soumDistrict,
                              address: address,
                              description: description,
                              imageFileList: _imageFileList,
                              videoFile: _videoFile,
                              register: register.text,
                              whois: whois,
                              name: ner.text,
                              chiglel: chiglel.text,
                              zuil_zaalt: zuil_zaalt,
                              reason_id: reason,
                              lat: latitude,
                              long: longitude,
                            );

                            await widget.onSave(w);
                            Get.back(result: '');
                          }
                        },
                        child: const Text(
                          'Хадгалах',
                          style: TextStyle(
                            color: Colors.white,
                            fontWeight: FontWeight.w700,
                            fontSize: 18,
                          ),
                        ),
                      ),
                    ),
                  ),
                  const SizedBox(height: 20),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
