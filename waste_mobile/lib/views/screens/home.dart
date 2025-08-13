import 'dart:async';

import 'package:connectivity_plus/connectivity_plus.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:percent_indicator/circular_percent_indicator.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/common_controller.dart';
import 'package:waste_mobile/controllers/notification_controller.dart';
import 'package:waste_mobile/controllers/waste_controller.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/utils/contants.dart';
import 'package:waste_mobile/utils/messaging_service.dart';
import 'package:waste_mobile/views/screens/local_waste_list.dart';
import 'package:waste_mobile/views/screens/splash_screen.dart';
import 'package:waste_mobile/views/screens/waste_create.dart';
import 'package:waste_mobile/views/screens/waste_list.dart';
import 'package:waste_mobile/views/widgets/NotificationBadge.dart';
import 'package:waste_mobile/views/widgets/task_column.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';
import 'package:pie_chart/pie_chart.dart';

class HomeViewWrapper extends StatelessWidget {
  const HomeViewWrapper({super.key});

  @override
  Widget build(BuildContext context) {
    return const HomeView();
  }
}

class HomeView extends StatefulWidget {
  const HomeView({super.key});

  static CircleAvatar plusIcon() {
    return const CircleAvatar(
      radius: 25.0,
      backgroundColor: LightColors.kGreen,
      child: Icon(
        Icons.app_registration_rounded,
        size: 20.0,
        color: Colors.white,
      ),
    );
  }

  @override
  State<HomeView> createState() => _HomeViewState();
}

class _HomeViewState extends State<HomeView> {
  late StreamSubscription<List<ConnectivityResult>> subscription;
  late StreamSubscription notificationSub;
  final CommonController commonController = Get.find();
  final Connectivity _connectivity = Connectivity();
  final AuthController authController = Get.find();
  final NotificationController notificationController = Get.find();
  final WasteController wasteController_ilgeegeegui = Get.find(
    tag: 'Илгээгээгүй',
  );
  final WasteController wasteController2 = Get.find(tag: 'Бүртгэсэн');
  final WasteController wasteController3 = Get.find(tag: 'Хуваарилагдсан');
  final WasteController wasteController5 = Get.find(tag: 'Шийдвэрлэгдсэн');

  late MessagingService service;
  Text subheading(String title) {
    return Text(
      title,
      style: const TextStyle(
        color: LightColors.kDarkBlue,
        fontSize: 20.0,
        fontWeight: FontWeight.w700,
        letterSpacing: 1.2,
      ),
    );
  }

  bool isOnline = false;

  StreamSubscription<List<ConnectivityResult>>
  listenToConnectivitySubscription() =>
      _connectivity.onConnectivityChanged.listen(_updateConnectionStatus);
  Future<void> _updateConnectionStatus(List<ConnectivityResult> result) async {
    setState(() {
      if (result.contains(ConnectivityResult.none)) {
        isOnline = false;
      } else {
        isOnline = true;
      }
    });
    // ignore: avoid_print
    print('Connectivity changed: $isOnline');
  }

  // Platform messages are asynchronous, so we initialize in an async method.
  Future<void> initConnectivity() async {
    late List<ConnectivityResult> result;
    // Platform messages may fail, so we use a try/catch PlatformException.
    try {
      result = await _connectivity.checkConnectivity();
    } catch (e) {
      print('Couldn\'t check connectivity status' + e.toString());
      return;
    }

    // If the widget was removed from the tree while the asynchronous platform
    // message was in flight, we want to discard the reply rather than calling
    // setState to update our non-existent appearance.
    if (!mounted) {
      return Future.value(null);
    }

    return _updateConnectionStatus(result);
  }

  @override
  void initState() {
    initConnectivity();
    subscription = listenToConnectivitySubscription();
    if (AuthController.user!.isMHA) wasteController2.refresh();

    wasteController3.refresh();

    wasteController5.refresh();
    wasteController_ilgeegeegui.initWasteModel().then(
      (value) => wasteController_ilgeegeegui.getLocalModels(),
    );
    service = MessagingService();
    service.setupInteractedMessage((token) {
      print('FCM Token: $token');
      if (token != null) authController.savePushToken(token);
    });
    notificationController.refresh();
    notificationSub = MessagingService.messageRx.listen((p0) {
      print('fuck');
      notificationController.refresh();
      Get.snackbar(
        p0.notification?.title ?? '',
        p0.notification?.body ?? '',
        snackPosition: SnackPosition.BOTTOM,
      );
    });
    super.initState();
  }

  @override
  dispose() {
    service.dispose();
    subscription.cancel();
    notificationSub.cancel();
    super.dispose();
  }

  noConnection() =>
      Get.defaultDialog(title: 'Анхаар', middleText: "Интернэр байхгүй байна");

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: LightColors.kLightYellow,
      body: FutureBuilder(
        future: commonController.loadData(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const WaitingWidget();
          } else {
            if (snapshot.hasError) {
              Timer(Duration(seconds: 0), () {
                Get.defaultDialog(
                  title: 'Алдаа',
                  middleText: 'Error: ${snapshot.error}',
                );
              });
            }
            return SafeArea(
              child: Stack(
                children: [
                  Column(
                    children: <Widget>[
                      TopContainer(
                        height: 150,
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                          children: <Widget>[
                            Padding(
                              padding: const EdgeInsets.symmetric(
                                horizontal: 0,
                                vertical: 0.0,
                              ),
                              child: Row(
                                crossAxisAlignment: CrossAxisAlignment.center,
                                mainAxisAlignment:
                                    MainAxisAlignment.spaceEvenly,
                                children: <Widget>[
                                  GestureDetector(
                                    onLongPress: () {
                                      Get.defaultDialog(
                                        title: "",
                                        middleText: 'Програмаас гарах уу?',
                                        textConfirm: 'Тийм',
                                        textCancel: 'Үгүй',
                                        onConfirm: () {
                                          authController.logOut();
                                          Get.back();
                                        },
                                        onCancel: () => Get.back(),
                                      );
                                    },
                                    child: CircularPercentIndicator(
                                      radius: 50.0,
                                      lineWidth: 5.0,
                                      animation: true,
                                      percent: 0.75,
                                      circularStrokeCap:
                                          CircularStrokeCap.round,
                                      progressColor: LightColors.kRed,
                                      backgroundColor: LightColors.kDarkYellow,
                                      center: const CircleAvatar(
                                        backgroundColor: LightColors.kBlue,
                                        radius: 40.0,
                                        child: Icon(
                                          Icons.account_circle,
                                          size: 70,
                                        ),
                                      ),
                                    ),
                                  ),
                                  const SizedBox(width: 10),
                                  Expanded(
                                    child: Column(
                                      crossAxisAlignment:
                                          CrossAxisAlignment.end,
                                      mainAxisAlignment: MainAxisAlignment.end,
                                      children: <Widget>[
                                        Text(
                                          softWrap: true,
                                          maxLines: 2,
                                          AuthController.user?.name ?? '',
                                          textAlign: TextAlign.start,
                                          style: const TextStyle(
                                            fontSize: 22.0,
                                            color: LightColors.kDarkBlue,
                                            fontWeight: FontWeight.w800,
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ],
                        ),
                      ),
                      Expanded(
                        child: SingleChildScrollView(
                          child: Column(
                            children: <Widget>[
                              Container(
                                color: Colors.transparent,
                                padding: const EdgeInsets.symmetric(
                                  horizontal: 20.0,
                                  vertical: 10.0,
                                ),
                                child: Column(
                                  children: <Widget>[
                                    Row(
                                      crossAxisAlignment:
                                          CrossAxisAlignment.center,
                                      mainAxisAlignment:
                                          MainAxisAlignment.spaceBetween,
                                      children: <Widget>[
                                        subheading('Миний Бүртгэл'),
                                      ],
                                    ),
                                    const SizedBox(height: 15.0),
                                    TextButton(
                                      onPressed:
                                          () => Get.to(
                                            () => const LocalWasteList(
                                              title: 'Илгээгээгүй',
                                            ),
                                          ),
                                      child: TaskColumn(
                                        icon: Icons.alarm,
                                        wasteController:
                                            wasteController_ilgeegeegui,
                                        iconBackgroundColor: LightColors.kRed,
                                        title: 'Илгээгээгүй',
                                        subtitle: 'Бүртгэл',
                                      ),
                                    ),
                                    const SizedBox(height: 15.0),
                                    TextButton(
                                      onPressed:
                                          isOnline
                                              ? () => Get.to(
                                                () => WasteList(
                                                  title: 'Бүртгэсэн',
                                                ),
                                              )
                                              : noConnection,
                                      child: TaskColumn(
                                        icon: Icons.blur_circular,
                                        wasteController: wasteController2,
                                        iconBackgroundColor:
                                            LightColors.kDarkYellow,
                                        title: 'Бүртгэсэн',
                                        subtitle: 'Бүртгэл',
                                      ),
                                    ),
                                    const SizedBox(height: 15.0),
                                    TextButton(
                                      onPressed:
                                          isOnline
                                              ? () => Get.to(
                                                () => WasteList(
                                                  title: 'Хуваарилагдсан',
                                                ),
                                              )
                                              : noConnection,
                                      child: TaskColumn(
                                        icon: Icons.blur_circular,
                                        wasteController: wasteController3,
                                        iconBackgroundColor:
                                            LightColors.kDarkYellow,
                                        title: 'Хуваарилагдсан',
                                        subtitle: 'Бүртгэл',
                                      ),
                                    ),
                                    const SizedBox(height: 15.0),
                                    TextButton(
                                      onPressed:
                                          isOnline
                                              ? () => Get.to(
                                                () => const WasteList(
                                                  title: 'Шийдвэрлэгдсэн',
                                                ),
                                              )
                                              : noConnection,
                                      child: TaskColumn(
                                        wasteController: wasteController5,
                                        icon: Icons.check_circle_outline,
                                        iconBackgroundColor: LightColors.kBlue,
                                        title: 'Шийдвэрлэгдсэн',
                                        subtitle: 'Бүртгэл',
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              Container(
                                color: Colors.transparent,
                                padding: const EdgeInsets.symmetric(
                                  horizontal: 20.0,
                                  vertical: 10.0,
                                ),
                                constraints: BoxConstraints(
                                  maxHeight:
                                      500 +
                                      (16 * Constants.statistic.keys.length)
                                          .toDouble(),
                                  maxWidth: Get.width - 60,
                                ),
                                child: PieChart(
                                  centerText: "Зөрчлийн төрлөөр",
                                  chartRadius: Get.width / 1.5,
                                  legendOptions: LegendOptions(
                                    showLegendsInRow: false,
                                    legendPosition: LegendPosition.bottom,
                                    showLegends: true,
                                    legendTextStyle: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      overflow: TextOverflow.clip,
                                    ),
                                  ),
                                  dataMap: Constants.statistic.map(
                                    (key, value) =>
                                        MapEntry(key, value.toDouble()),
                                  ),
                                  chartType: ChartType.ring,
                                  baseChartColor: Colors.grey[50]!.withOpacity(
                                    0.15,
                                  ),
                                  chartValuesOptions: ChartValuesOptions(
                                    showChartValuesInPercentage: true,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ),
                    ],
                  ),
                  if (!['mhb', 'mha'].contains(AuthController.user!.roles))
                    Positioned(
                      top: 160,
                      right: 20,
                      child: IconButton(
                        iconSize: 60,
                        onPressed:
                            () => Get.to(
                              () => WasteCreate(
                                wasteController: wasteController_ilgeegeegui,
                              ),
                            ),
                        icon: HomeView.plusIcon(),
                      ),
                    ),
                  Positioned(top: 0, right: 20, child: NotificationBadge()),
                ],
              ),
            );
          }
        },
      ),
    );
  }
}
