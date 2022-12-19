import 'dart:async';

import 'package:connectivity_plus/connectivity_plus.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:percent_indicator/circular_percent_indicator.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/common_controller.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/utils/contants.dart';
import 'package:waste_mobile/views/screens/local_waste_list.dart';
import 'package:waste_mobile/views/screens/splash_screen.dart';
import 'package:waste_mobile/views/screens/waste_create.dart';
import 'package:waste_mobile/views/screens/waste_list.dart';
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
  @override
  void initState() {
    super.initState();
    subscription = Connectivity()
        .onConnectivityChanged
        .listen((ConnectivityResult result) {
      setState(() {
        if (result == ConnectivityResult.none) {
          isOnline = false;
        } else {
          isOnline = true;
        }
      });
    });
  }

  @override
  dispose() {
    super.dispose();

    subscription.cancel();
  }

  noConnection() =>
      Get.defaultDialog(title: 'Анхаар', middleText: "Интернэр байхгүй байна");

  @override
  Widget build(BuildContext context) {
    final CommonController commonController = Get.find();
    return Scaffold(
      backgroundColor: LightColors.kLightYellow,
      body: FutureBuilder(
          future: commonController.loadData(),
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const WaitingWidget();
            } else if (snapshot.hasError) {
              return Center(child: Text('Error: ${snapshot.error}'));
            } else {
              return SafeArea(
                child: Stack(
                  children: [
                    Column(
                      children: <Widget>[
                        TopContainer(
                          height: 200,
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
                                      CircularPercentIndicator(
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
                                        onPressed: () => Get.to(() =>
                                            const LocalWasteList(
                                                title: 'Илгээгээгүй')),
                                        child: const TaskColumn(
                                          icon: Icons.alarm,
                                          iconBackgroundColor: LightColors.kRed,
                                          title: 'Илгээгээгүй',
                                          subtitle: 'Бүртгэл',
                                        ),
                                      ),
                                      const SizedBox(
                                        height: 15.0,
                                      ),
                                      TextButton(
                                        onPressed: isOnline
                                            ? () => Get.to(() =>
                                                const WasteList(
                                                    title: 'Илгээсэн'))
                                            : noConnection,
                                        child: const TaskColumn(
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
                                        child: const TaskColumn(
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
                    Positioned(
                      top: 160,
                      right: 20,
                      child: IconButton(
                        iconSize: 60,
                        onPressed: () => Get.to(() => const WasteCreate()),
                        icon: HomeView.plusIcon(),
                      ),
                    ),
                  ],
                ),
              );
            }
          }),
    );
  }
}
