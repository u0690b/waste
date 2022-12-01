import 'package:flutter/material.dart';

class WaitProgressIndicator extends StatelessWidget {
  const WaitProgressIndicator({super.key});

  @override
  Widget build(BuildContext context) {
    return const Center(
      child: CircularProgressIndicator(),
    );
  }
}
