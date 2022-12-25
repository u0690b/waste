import 'package:firebase_messaging/firebase_messaging.dart';

class MessagingService {
  late NotificationSettings settings;

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
    FirebaseMessaging.instance.onTokenRefresh.listen(setToken);
    // Also handle any interaction when the app is in the background via a
    // Stream listener
    FirebaseMessaging.onMessageOpenedApp.listen(_handleMessage);
  }

  void _handleMessage(RemoteMessage message) {
    print(message.data);
    if (message.data['type'] == 'chat') {
      //TO DO haha
    }
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
