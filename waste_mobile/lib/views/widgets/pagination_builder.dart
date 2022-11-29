import 'package:flutter/material.dart';

class PaginationBuilder<T> extends StatelessWidget {
  final bool refreshAble;
  final IPaginationModel<T> paginationModel;
  final Function(BuildContext context, List<T>? datas) itemBuilder;
  final Widget? child;
  final Widget? noResult;
  const PaginationBuilder({
    Key? key,
    required this.paginationModel,
    required this.itemBuilder,
    this.child,
    this.refreshAble = true,
    this.noResult,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Stack(children: [
      InfinityNotificationRefresh(
        notifyCondition: () =>
            !paginationModel.loading.value && paginationModel.hasMore,
        moreCallback: () => paginationModel.fetchMore(),
        refreshCallback: refreshAble ? paginationModel.refresh : null,
        child: AnimatedBuilder(
          animation: paginationModel,
          builder: (context, child) {
            return paginationModel.total == 0
                ? noResult ?? const Text('Мэдээлэл байхгүй байна')
                : itemBuilder(context, paginationModel.datas);
          },
        ),
      ),
      ValueListenableBuilder<bool>(
        valueListenable: paginationModel.loading,
        builder: (BuildContext context, value, Widget? child) {
          return value
              ? const Positioned(
                  bottom: 10,
                  right: 0,
                  left: 0,
                  child: Center(child: CircularProgressIndicator()))
              : const SizedBox();
        },
      ),
    ]);
  }
}

class InfinityNotificationRefresh extends StatelessWidget {
  final Widget child;
  final Future Function() moreCallback;
  final bool Function() notifyCondition;
  final Future Function()? refreshCallback;
  final bool isRefreshAble;
  const InfinityNotificationRefresh({
    Key? key,
    required this.child,
    required this.moreCallback,
    required this.notifyCondition,
    this.refreshCallback,
    this.isRefreshAble = true,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return NotificationListener<ScrollNotification>(
      onNotification: (ScrollNotification scrollInfo) {
        if (notifyCondition() &&
            scrollInfo.metrics.pixels == scrollInfo.metrics.maxScrollExtent) {
          moreCallback();
        }
        return true;
      },
      child: refreshCallback != null
          ? RefreshIndicator(
              onRefresh: () => refreshCallback!(),
              child: child,
            )
          : child,
    );
  }
}

abstract class IPaginationModel<T> extends ChangeNotifier {
  int? page;
  bool hasMore = false;
  int total = 0;
  List<T>? datas;
  ValueNotifier<bool> loading = ValueNotifier<bool>(false);
  Future fetchMore() async {}
  Future refresh() async {}
}
