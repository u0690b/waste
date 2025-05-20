import 'dart:async';

import 'package:firebase_analytics/firebase_analytics.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:timeago/timeago.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/common_controller.dart';
import 'package:waste_mobile/controllers/notification_controller.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/firebase_options.dart';

import 'package:waste_mobile/utils/messaging_service.dart';
import 'package:waste_mobile/views/screens/splash_screen.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:google_maps_flutter_android/google_maps_flutter_android.dart';
import 'package:google_maps_flutter_platform_interface/google_maps_flutter_platform_interface.dart';

Completer<AndroidMapRenderer?>? _initializedRendererCompleter;

/// Initializes map renderer to the `latest` renderer type for Android platform.
///
/// The renderer must be requested before creating GoogleMap instances,
/// as the renderer can be initialized only once per application context.
Future<AndroidMapRenderer?> initializeMapRenderer() async {
  if (_initializedRendererCompleter != null) {
    return _initializedRendererCompleter!.future;
  }

  final Completer<AndroidMapRenderer?> completer =
      Completer<AndroidMapRenderer?>();
  _initializedRendererCompleter = completer;

  WidgetsFlutterBinding.ensureInitialized();

  final GoogleMapsFlutterPlatform mapsImplementation =
      GoogleMapsFlutterPlatform.instance;
  if (mapsImplementation is GoogleMapsFlutterAndroid) {
    unawaited(
      mapsImplementation
          .initializeWithRenderer(AndroidMapRenderer.latest)
          .then(
            (AndroidMapRenderer initializedRenderer) =>
                completer.complete(initializedRenderer),
          ),
    );
  } else {
    completer.complete(null);
  }

  return completer.future;
}

Future<void> main() async {
  WidgetsFlutterBinding.ensureInitialized();
  setLocaleMessages('mn', MnMessages());
  setDefaultLocale('mn');
  await GetStorage.init();
  await Firebase.initializeApp(options: DefaultFirebaseOptions.currentPlatform);
  if (!kIsWeb) {
    FirebaseMessaging.onBackgroundMessage(firebaseMessagingBackgroundHandler);
  }
  FirebaseAnalytics analytics = FirebaseAnalytics.instance;
  final GoogleMapsFlutterPlatform mapsImplementation =
      GoogleMapsFlutterPlatform.instance;
  if (mapsImplementation is GoogleMapsFlutterAndroid) {
    mapsImplementation.useAndroidViewSurface = true;
    initializeMapRenderer();
  }
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
    Get.lazyPut(
      () => WasteController('Илгээгээгүй'),
      tag: 'Илгээгээгүй',
      fenix: true,
    );
    Get.lazyPut(
      () => WasteController('Бүртгэсэн'),
      tag: 'Бүртгэсэн',
      fenix: true,
    );
    Get.lazyPut(
      () => WasteController('Хуваарилагдсан'),
      tag: 'Хуваарилагдсан',
      fenix: true,
    );

    Get.lazyPut(
      () => WasteController('Шийдвэрлэгдсэн'),
      tag: 'Шийдвэрлэгдсэн',
      fenix: true,
    );

    Get.lazyPut(() => NotificationController(), fenix: true);
  }

  @override
  Widget build(BuildContext context) {
    return GetMaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Flutter Demo',
      theme: ThemeData(
        elevatedButtonTheme: ElevatedButtonThemeData(
          style: ElevatedButton.styleFrom(
            backgroundColor: Colors.blue,
            foregroundColor: Colors.white,
          ),
        ),
        primarySwatch: Colors.blue,
      ),
      home: SplashScreen(),
    );
  }
}
