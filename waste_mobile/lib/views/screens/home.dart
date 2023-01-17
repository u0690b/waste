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
import 'package:waste_mobile/views/widgets/active_project_card.dart';
import 'package:waste_mobile/views/widgets/task_column.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';

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
  late StreamSubscription<ConnectivityResult> subscription;
  late StreamSubscription notificationSub;
  final CommonController commonController = Get.find();
  final AuthController authController = Get.find();
  final NotificationController notificationController = Get.find();
  final WasteController wasteController_ilgeegeegui =
      Get.find(tag: 'Илгээгээгүй');
  final WasteController wasteController2 = Get.find(tag: 'Ирсэн');
  final WasteController wasteController3 = Get.find(tag: 'Хуваарилагдсан');
  final WasteController wasteController4 = Get.find(tag: 'Илгээсэн');
  final WasteController wasteController5 = Get.find(tag: 'Шийдвэрлэгдсэн');

  late MessagingService service;
  Text subheading(String title) {
    return Text(
      title,
      style: const TextStyle(
          color: LightColors.kDarkBlue,
          fontSize: 20.0,
          fontWeight: FontWeight.w700,
          letterSpacing: 1.2),
    );
  }

  bool isOnline = false;

  StreamSubscription<ConnectivityResult> listenToConnectivitySubscription() =>
      Connectivity().onConnectivityChanged.listen((ConnectivityResult result) {
        setState(() {
          if (result == ConnectivityResult.none) {
            isOnline = false;
          } else {
            isOnline = true;
          }
        });
      });

  @override
  void initState() {
    subscription = listenToConnectivitySubscription();
    if (AuthController.user!.isMHA) wasteController2.refresh();
    if (AuthController.user!.isMH)
      wasteController3.refresh();
    else
      wasteController4.refresh();
    wasteController5.refresh();
    wasteController_ilgeegeegui
        .initWasteModel()
        .then((value) => wasteController_ilgeegeegui.getLocalModels());
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
                      title: 'Алдаа', middleText: 'Error: ${snapshot.error}');
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
                                      horizontal: 0, vertical: 0.0),
                                  child: Row(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.center,
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
                                          backgroundColor:
                                              LightColors.kDarkYellow,
                                          center: const CircleAvatar(
                                            backgroundColor: LightColors.kBlue,
                                            radius: 40.0,
                                            child: Icon(Icons.account_circle,
                                                size: 70),
                                          ),
                                        ),
                                      ),
                                      const SizedBox(width: 10),
                                      Expanded(
                                        child: Column(
                                          crossAxisAlignment:
                                              CrossAxisAlignment.end,
                                          mainAxisAlignment:
                                              MainAxisAlignment.end,
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
                                            Text(
                                              AuthController.user?.address ??
                                                  '',
                                              softWrap: true,
                                              maxLines: 2,
                                              textAlign: TextAlign.end,
                                              style: const TextStyle(
                                                fontSize: 16.0,
                                                color: Colors.black45,
                                                fontWeight: FontWeight.w400,
                                              ),
                                            ),
                                          ],
                                        ),
                                      )
                                    ],
                                  ),
                                )
                              ]),
                        ),
                        Expanded(
                          child: SingleChildScrollView(
                            child: Column(
                              children: <Widget>[
                                Container(
                                  color: Colors.transparent,
                                  padding: const EdgeInsets.symmetric(
                                      horizontal: 20.0, vertical: 10.0),
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
                                        onPressed: () => Get.to(
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
                                      const SizedBox(
                                        height: 15.0,
                                      ),
                                      if (AuthController.user!.isMHA) ...[
                                        TextButton(
                                          onPressed: isOnline
                                              ? () => Get.to(() =>
                                                  WasteList(title: 'Ирсэн'))
                                              : noConnection,
                                          child: TaskColumn(
                                            icon: Icons.blur_circular,
                                            wasteController: wasteController2,
                                            iconBackgroundColor:
                                                LightColors.kDarkYellow,
                                            title: 'Ирсэн',
                                            subtitle: 'Бүртгэл',
                                          ),
                                        ),
                                        const SizedBox(
                                          height: 15.0,
                                        ),
                                      ],
                                      if (AuthController.user!.isMH)
                                        TextButton(
                                          onPressed: isOnline
                                              ? () => Get.to(() => WasteList(
                                                  title: 'Хуваарилагдсан'))
                                              : noConnection,
                                          child: TaskColumn(
                                            icon: Icons.blur_circular,
                                            wasteController: wasteController3,
                                            iconBackgroundColor:
                                                LightColors.kDarkYellow,
                                            title: 'Хуваарилагдсан',
                                            subtitle: 'Бүртгэл',
                                          ),
                                        )
                                      else
                                        TextButton(
                                          onPressed: isOnline
                                              ? () => Get.to(() =>
                                                  WasteList(title: 'Илгээсэн'))
                                              : noConnection,
                                          child: TaskColumn(
                                            wasteController: wasteController4,
                                            icon: Icons.blur_circular,
                                            iconBackgroundColor:
                                                LightColors.kDarkYellow,
                                            title: 'Илгээсэн',
                                            subtitle: 'Бүртгэл',
                                          ),
                                        ),
                                      const SizedBox(height: 15.0),
                                      TextButton(
                                        onPressed: isOnline
                                            ? () => Get.to(() =>
                                                const WasteList(
                                                    title: 'Шийдвэрлэгдсэн'))
                                            : noConnection,
                                        child: TaskColumn(
                                          wasteController: wasteController5,
                                          icon: Icons.check_circle_outline,
                                          iconBackgroundColor:
                                              LightColors.kBlue,
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
                                      horizontal: 20.0, vertical: 10.0),
                                  child: Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.start,
                                    children: <Widget>[
                                      subheading('Зөрчил шийдвэрлэсэн байдал'),
                                      const SizedBox(height: 5.0),
                                      Row(
                                        children: <Widget>[
                                          ActiveProjectsCard(
                                            cardColor: LightColors.kGreen,
                                            loadingPercent: Constants.za,
                                            title:
                                                'Улаанбаатар хотын Захирагчийн ажлын алба',
                                            subtitle:
                                                'Нийт бүртгэгдсэн ${Constants.totalAa}',
                                          ),
                                          const SizedBox(width: 20.0),
                                          ActiveProjectsCard(
                                            onTap: () {},
                                            cardColor: LightColors.kRed,
                                            loadingPercent: Constants.mh,
                                            title: 'Мэргэжлийн хяналт',
                                            subtitle:
                                                'Нийт бүртгэгдсэн ${Constants.totalMh}',
                                          ),
                                        ],
                                      ),
                                    ],
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
                          onPressed: () => Get.to(
                            () => WasteCreate(
                              wasteController: wasteController_ilgeegeegui,
                            ),
                          ),
                          icon: HomeView.plusIcon(),
                        ),
                      ),
                    Positioned(top: 0, right: 20, child: NotificationBadge())
                  ],
                ),
              );
            }
          }),
    );
  }
}
