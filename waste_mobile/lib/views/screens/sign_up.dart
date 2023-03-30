import 'dart:async';

import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/common_controller.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/utils/contants.dart';
import 'package:waste_mobile/views/screens/splash_screen.dart';
import 'package:waste_mobile/views/widgets/future_alert_dialog.dart';

class SignUp extends StatefulWidget {
  const SignUp({Key? key}) : super(key: key);

  @override
  State<SignUp> createState() => _SignUpState();
}

class _SignUpState extends State<SignUp> {
  final GlobalKey<FormState> formKey = GlobalKey();
  final AuthController _auth = Get.find();
  final CommonController commonController = Get.find();
  TextEditingController nameCtr = TextEditingController();
  TextEditingController phoneCtr = TextEditingController();
  TextEditingController passwordCtr = TextEditingController();
  late Future<List<NameModel>?> ss;
  @override
  void initState() {
    super.initState();
    ss = commonController.loadData();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Бүртгүүлэх')),
      body: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 12.0),
        child: FutureBuilder(
            future: ss,
            builder: (context, snapshot) {
              if (snapshot.connectionState == ConnectionState.waiting) {
                return const WaitingWidget();
              } else {
                if (snapshot.hasError) {
                  Timer(Duration(seconds: 0), () {
                    Get.defaultDialog(
                        title: 'Алдаа', middleText: 'Error: ${snapshot.error}');
                  });
                }
                return SingleChildScrollView(child: loginForm());
              }
            }),
      ),
    );
  }

  int? soumDistrict;
  int? bagHoroo;
  Form loginForm() {
    return Form(
      autovalidateMode: AutovalidateMode.onUserInteraction,
      key: formKey,
      child: Column(mainAxisAlignment: MainAxisAlignment.start, children: [
        const SizedBox(height: 30),
        TextFormField(
          controller: nameCtr,
          validator: (value) {
            return (value == null || value.isEmpty) ? 'Овог Нэр' : null;
          },
          decoration: inputDecoration('Овог Нэр', Icons.person),
        ),
        const SizedBox(height: 8),
        TextFormField(
          controller: phoneCtr,
          validator: (value) {
            return (value == null || value.isEmpty)
                ? 'Утасны дугаар'
                : !new RegExp(r'\b\d{4}\d{4}\b').hasMatch(value)
                    ? 'жишээ: 99118811'
                    : null;
          },
          decoration: inputDecoration('Утасны дугаар', Icons.phone),
        ),
        const SizedBox(height: 8),
        DropdownButtonFormField(
          validator: (p0) => p0 == null ? 'Заавал бөглөх' : null,
          decoration: inputDecoration("Сум,Дүүрэг", Icons.location_on),
          items: Constants.soumDistricts
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
        const SizedBox(height: 8),
        // Баг,Хороо:
        DropdownButtonFormField(
          validator: (p0) => p0 == null ? 'Заавал бөглөх' : null,
          decoration: inputDecoration('Баг,Хороо', Icons.location_on),
          enableFeedback: soumDistrict != null,
          items: Constants.bagHoroos
              .where(
                  (element) => element.soum_district_id == (soumDistrict ?? -1))
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

        const SizedBox(height: 8),
        TextFormField(
          validator: (value) {
            return (value == null || value.isEmpty) ? 'Нууц үг хоосон' : null;
          },
          obscureText: true,
          controller: passwordCtr,
          decoration: inputDecoration('Нууц үг', Icons.lock),
        ),
        const SizedBox(height: 8),
        ElevatedButton(
          onPressed: () async {
            if (formKey.currentState?.validate() ?? false) {
              final ret = await futureAlertDialog(
                autoCloseSec: -1,
                context: context,
                successMessage:
                    'Таны бүртгүүлэх хүсэл хүлээн авлаа. \nТа админд мэдэгдэж эрх сэргээтэл хүлээнэ үү',
                futureStream: _auth.signUp(
                    name: nameCtr.text,
                    phone: phoneCtr.text,
                    password: passwordCtr.text,
                    soum_district_id: soumDistrict!,
                    bag_horoo_id: bagHoroo!),
                onError: (context, err) {
                  print(err.toString());
                  if (err is ValidationException) {
                    return Text(err.message);
                  }
                  return Text(err.toString());
                },
              );
              if (ret != null) {
                Get.back();
              }
            }
          },
          child: const Text('Бүртгүүлэх'),
        ),
      ]),
    );
  }
}

InputDecoration inputDecoration(String labelText, IconData iconData,
    {String? prefix, String? helperText}) {
  return InputDecoration(
    contentPadding: const EdgeInsets.symmetric(vertical: 12, horizontal: 12),
    helperText: helperText,
    labelText: labelText,
    labelStyle: const TextStyle(color: Colors.grey),
    fillColor: Colors.grey.shade200,
    filled: true,
    prefixText: prefix,
    prefixIcon: Icon(
      iconData,
      size: 20,
    ),
    prefixIconConstraints: const BoxConstraints(minWidth: 60),
    enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(30),
        borderSide: const BorderSide(color: Colors.black)),
    focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(30),
        borderSide: const BorderSide(color: Colors.black)),
    errorBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(30),
        borderSide: const BorderSide(color: Colors.black)),
    border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(30),
        borderSide: const BorderSide(color: Colors.black)),
  );
}
