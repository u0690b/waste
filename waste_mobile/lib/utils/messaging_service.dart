import 'dart:async';

import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:get/get.dart';
import 'package:waste_mobile/views/screens/notification_list.dart';

@pragma('vm:entry-point')
Future<void> firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  // If you're going to use other Firebase services in the background, such as Firestore,
  // make sure you call `initializeApp` before using other Firebase services.
  await Firebase.initializeApp();

  print("Handling a background message: ${message.messageId}");
  MessagingService.messageRx.value = message;
}

class MessagingService {
  static Rx<RemoteMessage> messageRx = Rx<RemoteMessage>(RemoteMessage());
  late NotificationSettings settings;
  StreamSubscription? _onMessageSub;
  StreamSubscription? _onTokenRefreshSub;
  StreamSubscription? _onMessageOpenedAppSub;

  void dispose() {
    _onMessageSub?.cancel();
    _onTokenRefreshSub?.cancel();
    _onMessageOpenedAppSub?.cancel();
  }

  Future<void> setupInteractedMessage(Function(String?) setToken) async {
    // Get any messages which caused the application to open from
    // a terminated state.
    RemoteMessage? initialMessage =
        await FirebaseMessaging.instance.getInitialMessage();
    checkPermissions();
    // If the message also contains a data property with a "type" of "chat",
    // navigate to a chat screen
    if (initialMessage != null) {
      _handleMessage(initialMessage);
    }
    FirebaseMessaging.instance.getToken().then(setToken);
    _onTokenRefreshSub =
        FirebaseMessaging.instance.onTokenRefresh.listen(setToken);
    // Also handle any interaction when the app is in the background via a
    // Stream listener
    _onMessageSub = FirebaseMessaging.onMessage.listen(_recieveMessage);
    _onMessageOpenedAppSub =
        FirebaseMessaging.onMessageOpenedApp.listen(_handleMessage);
  }

  void _recieveMessage(RemoteMessage message) {
    MessagingService.messageRx.value = message;
  }

  void _handleMessage(RemoteMessage message) {
    Get.to(() => NotificationList(refreshable: true));
  }

  Future<void> checkPermissions() async {
    settings = await FirebaseMessaging.instance.getNotificationSettings();
    if (settings.authorizationStatus != AuthorizationStatus.authorized)
      settings = await FirebaseMessaging.instance.requestPermission(
        alert: true,
        announcement: false,
        badge: true,
        carPlay: false,
        criticalAlert: false,
        provisional: false,
        sound: true,
      );
  }
}
