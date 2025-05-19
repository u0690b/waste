import 'dart:developer';

import 'package:flutter/material.dart';

Future<T?> futureAlertDialog<T>({
  required BuildContext context,
  required Future<T> futureStream,
  Widget Function(BuildContext context, dynamic err)? onError,
  Widget Function(BuildContext context)? onWaiting,
  Widget Function(T? ret)? onHandle,
  String successMessage = '',
  int autoCloseSec = -1,
}) async {
  Future<T?> showDemoDialog(
      {required BuildContext context, Widget? child}) async {
    return await showDialog<T>(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) => child!,
    );
  }

  Widget _defaultOnWaiting(context) {
    return Center(
      child: CircularProgressIndicator(
        valueColor:
            AlwaysStoppedAnimation<Color>(Theme.of(context).primaryColor),
      ),
    );
  }

  Widget _defaultOnError(BuildContext context, error) {
    return Column(
      children: <Widget>[
        Icon(Icons.sentiment_very_dissatisfied,
            size: 22, color: Theme.of(context).primaryColor),
        Text(":-( Алдаа гарлаа дахин оролдоно уу?",
            style: Theme.of(context).textTheme.headlineMedium),
        if (error is FormatException)
          SelectableText(error.message)
        else
          SelectableText(error.message),
      ],
    );
  }

  Widget alertBuilder(
      {required BuildContext context,
      String title = 'Loading',
      Widget? child,
      bool showCancel = true,
      T? ret}) {
    if (onHandle != null) onHandle(ret);
    if (autoCloseSec != -1) {
      if ('Амжилттай' == title) {
        showCancel = false;
        Future.delayed(Duration(seconds: autoCloseSec), () {
          Navigator.of(context).pop(ret);
        });
      }
    }
    return AlertDialog(
      backgroundColor: Colors.white,
      title: Text(title),
      content: SingleChildScrollView(
        child: child,
      ),
      actions: [
        showCancel
            ? TextButton(
                child: Text("Хаах"),
                onPressed: () {
                  Navigator.pop(context, ret);
                })
            : Container(),
      ],
    );
  }

  return await showDemoDialog(
    context: context,
    child: FutureBuilder<T>(
      future: futureStream,
      builder: (BuildContext context, snapshot) {
        if (snapshot.connectionState == ConnectionState.done) {
          if (snapshot.hasError) {
            log(snapshot.error.toString());
            return alertBuilder(
              title: "Анхаар",
              context: context,
              showCancel: true,
              child: (onError != null)
                  ? onError(context, snapshot.error)
                  : _defaultOnError(context, snapshot.error),
            );
          }

          return alertBuilder(
            title: "Амжилттай",
            context: context,
            showCancel: true,
            child: successMessage.isEmpty
                ? SizedBox(
                    height: 80,
                    child: Center(
                      child: Icon(
                        Icons.check_circle,
                        size: 40,
                      ),
                    ),
                  )
                : Column(children: <Widget>[
                    Icon(
                      Icons.check_circle,
                      size: 40,
                    ),
                    const SizedBox(height: 20),
                    Text(successMessage),
                  ]),
            ret: snapshot.data,
          );
        } else {
          return alertBuilder(
            title: 'Түр хүлээнэ үү',
            context: context,
            showCancel: false,
            child: (onWaiting != null)
                ? onWaiting(context)
                : _defaultOnWaiting(context),
          );
        }
      },
    ),
  );
}
