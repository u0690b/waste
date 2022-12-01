import 'package:flutter/material.dart';
import 'package:get/get.dart';

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
            !paginationModel.loading.value &&
            paginationModel.nextCursor != null,
        moreCallback: paginationModel.fetchMore,
        refreshCallback: refreshAble ? paginationModel.refresh : null,
        child: ObxValue(
          (snap) {
            return paginationModel.datas.isEmpty
                ? noResult ?? const Text('Мэдээлэл байхгүй байна')
                : itemBuilder(context, snap);
          },
          paginationModel.datas,
        ),
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

abstract class IPaginationModel<T> {
  String? nextCursor;
  final RxList<T> datas = <T>[].obs;
  ValueNotifier<bool> loading = ValueNotifier<bool>(false);
  Future<List<T>?> fetchMore() async {
    return null;
  }

  Future<List<T>?> refresh() async {
    return null;
  }
}
