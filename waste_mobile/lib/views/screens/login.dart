import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/models/model.dart';
import 'package:waste_mobile/views/screens/sign_up.dart';
import 'package:waste_mobile/views/widgets/future_alert_dialog.dart';

class LoginView extends StatefulWidget {
  const LoginView({Key? key}) : super(key: key);

  @override
  State<LoginView> createState() => _LoginViewState();
}

class _LoginViewState extends State<LoginView> {
  final GlobalKey<FormState> formKey = GlobalKey();
  final AuthController _auth = Get.find();
  TextEditingController emailCtr = TextEditingController();
  TextEditingController passwordCtr = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Нэвтрэх')),
      body: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 12.0),
        child: loginForm(),
      ),
    );
  }

  Form loginForm() {
    return Form(
      autovalidateMode: AutovalidateMode.onUserInteraction,
      key: formKey,
      child: Stack(
        children: [
          Column(mainAxisAlignment: MainAxisAlignment.center, children: [
            TextFormField(
              controller: emailCtr,
              validator: (value) {
                return (value == null || value.isEmpty)
                    ? 'Нэвтрэх нэр хоосон'
                    : null;
              },
              decoration: inputDecoration('Нэвтрэх нэр', Icons.person),
            ),
            const SizedBox(
              height: 8,
            ),
            TextFormField(
              validator: (value) {
                return (value == null || value.isEmpty)
                    ? 'Нууц үг хоосон'
                    : null;
              },
              obscureText: true,
              controller: passwordCtr,
              decoration: inputDecoration('Нууц үг', Icons.lock),
            ),
            ElevatedButton(
              onPressed: () async {
                if (formKey.currentState?.validate() ?? false) {
                  futureAlertDialog(
                    autoCloseSec: 0,
                    context: context,
                    futureStream:
                        _auth.loginUser(emailCtr.text, passwordCtr.text),
                    onError: (context, err) {
                      print(err.toString());
                      if (err is ValidationException) {
                        return Text(err.message);
                      }
                      return Text(err.toString());
                    },
                  );
                }
              },
              child: const Text('Нэвтрэх'),
            ),
          ]),
          Positioned(
            bottom: 0,
            left: 0,
            right: 0,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                TextButton(
                  onPressed: () {
                    Get.to(() => SignUp());
                  },
                  child: const Text('Бүртгүүлэх'),
                ),
              ],
            ),
          ),
        ],
      ),
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
