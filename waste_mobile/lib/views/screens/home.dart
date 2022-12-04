import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:percent_indicator/circular_percent_indicator.dart';
import 'package:waste_mobile/controllers/auth_controller.dart';
import 'package:waste_mobile/controllers/common_controller.dart';
import 'package:waste_mobile/theme/colors/light_colors.dart';
import 'package:waste_mobile/views/screens/splash_screen.dart';
import 'package:waste_mobile/views/screens/waste_create.dart';
import 'package:waste_mobile/views/screens/waste_list.dart';
import 'package:waste_mobile/views/widgets/active_project_card.dart';
import 'package:waste_mobile/views/widgets/task_column.dart';
import 'package:waste_mobile/views/widgets/top_container.dart';

class HomeView extends StatelessWidget {
  HomeView({super.key});

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

  final CommonController _commonController = Get.put(CommonController());

  @override
  Widget build(BuildContext context) {
    double width = MediaQuery.of(context).size.width;

    return Scaffold(
      backgroundColor: LightColors.kLightYellow,
      body: FutureBuilder(
          future: _commonController.loadData(),
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const WaitingWidget();
            } else if (snapshot.hasError) {
              return Center(child: Text('Error: ${snapshot.error}'));
            } else {
              return SafeArea(
                child: Column(
                  children: <Widget>[
                    TopContainer(
                      height: 200,
                      width: width,
                      child: Column(
                          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                          children: <Widget>[
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: const <Widget>[
                                Icon(Icons.menu,
                                    color: LightColors.kDarkBlue, size: 30.0),
                                Icon(Icons.search,
                                    color: LightColors.kDarkBlue, size: 25.0),
                              ],
                            ),
                            Padding(
                              padding: const EdgeInsets.symmetric(
                                  horizontal: 0, vertical: 0.0),
                              child: Row(
                                crossAxisAlignment: CrossAxisAlignment.center,
                                mainAxisAlignment:
                                    MainAxisAlignment.spaceEvenly,
                                children: <Widget>[
                                  CircularPercentIndicator(
                                    radius: 50.0,
                                    lineWidth: 5.0,
                                    animation: true,
                                    percent: 0.75,
                                    circularStrokeCap: CircularStrokeCap.round,
                                    progressColor: LightColors.kRed,
                                    backgroundColor: LightColors.kDarkYellow,
                                    center: const CircleAvatar(
                                      backgroundColor: LightColors.kBlue,
                                      radius: 40.0,
                                      child:
                                          Icon(Icons.account_circle, size: 70),
                                    ),
                                  ),
                                  Column(
                                    crossAxisAlignment:
                                        CrossAxisAlignment.center,
                                    children: <Widget>[
                                      Text(
                                        AuthController.user?.name ?? '',
                                        textAlign: TextAlign.start,
                                        style: const TextStyle(
                                          fontSize: 22.0,
                                          color: LightColors.kDarkBlue,
                                          fontWeight: FontWeight.w800,
                                        ),
                                      ),
                                      Text(
                                        AuthController.user?.address ?? '',
                                        textAlign: TextAlign.start,
                                        style: const TextStyle(
                                          fontSize: 16.0,
                                          color: Colors.black45,
                                          fontWeight: FontWeight.w400,
                                        ),
                                      ),
                                    ],
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
                                      GestureDetector(
                                        onTap: () =>
                                            Get.to(() => const WasteCreate()),
                                        child: plusIcon(),
                                      ),
                                    ],
                                  ),
                                  const SizedBox(height: 15.0),
                                  GestureDetector(
                                    onTap: () => Get.to(() =>
                                        const WasteList(title: 'Илгээгээгүй')),
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
                                  GestureDetector(
                                    onTap: () => Get.to(() =>
                                        const WasteList(title: 'Илгээсэн')),
                                    child: const TaskColumn(
                                      icon: Icons.blur_circular,
                                      iconBackgroundColor:
                                          LightColors.kDarkYellow,
                                      title: 'Илгээсэн',
                                      subtitle: 'Бүртгэл',
                                    ),
                                  ),
                                  const SizedBox(height: 15.0),
                                  GestureDetector(
                                    onTap: () => Get.to(() => const WasteList(
                                        title: 'Шийдвэрлэгдсэн')),
                                    child: const TaskColumn(
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
                                  horizontal: 20.0, vertical: 10.0),
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: <Widget>[
                                  subheading('Хог хаягдлын бүртгэл'),
                                  const SizedBox(height: 5.0),
                                  Row(
                                    children: <Widget>[
                                      ActiveProjectsCard(
                                        onTap: () => Get.to(() =>
                                            const WasteList(
                                                title: 'Захирагчийн алба')),
                                        cardColor: LightColors.kGreen,
                                        loadingPercent: 0.4,
                                        title: 'Захирагчийн алба',
                                        subtitle: 'Нийт бүртгэгдсэн 11',
                                      ),
                                      const SizedBox(width: 20.0),
                                      ActiveProjectsCard(
                                        onTap: () => Get.to(() =>
                                            const WasteList(
                                                title: 'Мэргэжлийн хаяналт')),
                                        cardColor: LightColors.kRed,
                                        loadingPercent: 0.6,
                                        title: 'Мэргэжлийн хаяналт',
                                        subtitle: '20 hours progress',
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
              );
            }
          }),
    );
  }
}
