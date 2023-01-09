import 'package:firebase_analytics/firebase_analytics.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:timeago/timeago.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/common_controller.dart';
import 'package:waste_mobile/controllers/notification_controller.dart';

import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/utils/messaging_service.dart';
import 'package:waste_mobile/views/screens/splash_screen.dart';
import 'package:firebase_core/firebase_core.dart';
import 'firebase_options.dart';

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  setLocaleMessages('mn', MnMessages());
  setDefaultLocale('mn');
  await GetStorage.init();
  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);
  FirebaseMessaging.onBackgroundMessage(firebaseMessagingBackgroundHandler);
  FirebaseAnalytics analytics = FirebaseAnalytics.instance;
  // await GetStorage().erase();
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    Get.put(CommonController());
    Get.put(AuthController());
    Get.lazyPut(() => WasteController());
    Get.lazyPut(() => NotificationController());
    return GetMaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Flutter Demo',
      theme: ThemeData(
        // This is the theme of your application.
        //
        // Try running your application with "flutter run". You'll see the
        // application has a blue toolbar. Then, without quitting the app, try
        // changing the primarySwatch below to Colors.green and then invoke
        // "hot reload" (press "r" in the console where you ran "flutter run",
        // or simply save your changes to "hot reload" in a Flutter IDE).
        // Notice that the counter didn't reset back to zero; the application
        // is not restarted.
        primarySwatch: Colors.blue,
      ),
      home: SplashScreen(),
    );
  }
}
