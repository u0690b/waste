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

class MyApp extends StatefulWidget {
  const MyApp({super.key});

  @override
  State<MyApp> createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  // This widget is the root of your application.
  @override
  void initState() {
    super.initState();

    Get.lazyPut(() => CommonController(), fenix: true);
    Get.lazyPut(() => AuthController(), fenix: true);
    Get.lazyPut(() => WasteController('Илгээгээгүй'),
        tag: 'Илгээгээгүй', fenix: true);
    Get.lazyPut(() => WasteController('Ирсэн'), tag: 'Ирсэн', fenix: true);
    Get.lazyPut(() => WasteController('Хуваарилагдсан'),
        tag: 'Хуваарилагдсан', fenix: true);
    Get.lazyPut(() => WasteController('Илгээсэн'),
        tag: 'Илгээсэн', fenix: true);
    Get.lazyPut(() => WasteController('Шийдвэрлэгдсэн'),
        tag: 'Шийдвэрлэгдсэн', fenix: true);

    Get.lazyPut(() => NotificationController(), fenix: true);
  }

  @override
  Widget build(BuildContext context) {
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
