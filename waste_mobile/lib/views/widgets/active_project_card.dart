import 'package:flutter/material.dart';
import 'package:percent_indicator/percent_indicator.dart';

class ActiveProjectsCard extends StatelessWidget {
  final Color? cardColor;
  final double loadingPercent;
  final String title;
  final String subtitle;
  final void Function()? onTap;
  const ActiveProjectsCard({
    super.key,
    this.cardColor,
    required this.loadingPercent,
    required this.title,
    required this.subtitle,
    this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return Expanded(
      flex: 1,
      child: GestureDetector(
        onTap: onTap,
        child: Container(
          margin: const EdgeInsets.symmetric(vertical: 10.0),
          padding: const EdgeInsets.all(15.0),
          height: 220,
          decoration: BoxDecoration(
            color: cardColor,
            borderRadius: BorderRadius.circular(40.0),
          ),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: <Widget>[
              Padding(
                padding: const EdgeInsets.all(10.0),
                child: CircularPercentIndicator(
                  animation: true,
                  radius: 50.0,
                  percent: loadingPercent,
                  lineWidth: 5.0,
                  circularStrokeCap: CircularStrokeCap.round,
                  backgroundColor: Colors.white10,
                  progressColor: Colors.white,
                  center: Text(
                    '${(loadingPercent * 100).round()}%',
                    style: const TextStyle(
                        fontWeight: FontWeight.w700, color: Colors.white),
                  ),
                ),
              ),
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: <Widget>[
                  Text(
                    title,
                    style: const TextStyle(
                      fontSize: 14.0,
                      color: Colors.white,
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                  Text(
                    subtitle,
                    style: const TextStyle(
                      fontSize: 12.0,
                      color: Colors.white54,
                      fontWeight: FontWeight.w400,
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
