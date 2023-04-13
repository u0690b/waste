import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/views/screens/onboard.dart';

class SplashScreen extends StatelessWidget {
  final AuthController _authmanager = Get.find();

  SplashScreen({super.key});

  Future<void> initializeSettings() async {
    _authmanager.checkLoginStatus();

    //Simulate other services for 3 seconds
    // await Future.delayed(const Duration(seconds: 3));
  }

  @override
  Widget build(BuildContext context) {
    return FutureBuilder(
      future: initializeSettings(),
      builder: (context, snapshot) {
        if (snapshot.connectionState != ConnectionState.done) {
          return waitingView();
        } else {
          return const OnBoard();
        }
      },
    );
  }

  Scaffold errorView(AsyncSnapshot<Object?> snapshot) {
    return Scaffold(body: Center(child: Text('Error: ${snapshot.error}')));
  }

  Widget waitingView() {
    return const WaitingWidget();
  }
}

class WaitingWidget extends StatelessWidget {
  const WaitingWidget({
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: Center(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.center,
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            width: Get.width,
            height: 300,
            margin: const EdgeInsets.symmetric(horizontal: 40),
            decoration: const BoxDecoration(
              image: DecorationImage(
                image: AssetImage('assets/splash.png'),
                fit: BoxFit.contain,
              ),
            ),
          ),
          const Padding(
            padding: EdgeInsets.all(16.0),
            child: CircularProgressIndicator(),
          ),
          const Text('Loading...'),
        ],
      ),
    ));
  }
}
