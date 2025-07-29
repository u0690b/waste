import 'dart:convert';

import 'package:flutter/foundation.dart';
import 'package:get_storage/get_storage.dart';
import 'package:waste_mobile/models/model.dart';

class Constants {
  static String host =
      kReleaseMode ? 'https://waste.mecc.gov.mn' : 'http://localhost:8000';
  static NameModel Function(NameModel, NameModel) combine =
      (element, value) =>
          element.updated_at != null &&
                  value.updated_at != null &&
                  element.updated_at!.compareTo(value.updated_at!) > 0
              ? element
              : value;

  static List<NameModel>? _places;
  static List<NameModel> get places {
    return _places ??=
        GetStorage()
            .read<List<dynamic>>('places')
            ?.map((e) => NameModel.fromJson(e))
            .toList() ??
        [];
  }

  static set places(List<NameModel>? value) {
    if (value == null || value.isEmpty) {
      return;
    }
    _places = value;
    GetStorage().write('places', value.map((e) => e.toJson()).toList());

    GetStorage().write(
      'places_date',
      value.reduce(combine).updated_at?.toIso8601String(),
    );
  }

  static List<NameModel>? _reasons;
  static List<NameModel> get reasons {
    return _reasons ??=
        GetStorage()
            .read<List<dynamic>>('reasons')
            ?.map((e) => NameModel.fromJson(e))
            .toList() ??
        [];
  }

  static set reasons(List<NameModel>? value) {
    if (value == null || value.isEmpty) {
      return;
    }
    _reasons = value;
    GetStorage().write('reasons', value.map((e) => e.toJson()).toList());
    GetStorage().write(
      'reasons_date',
      value.reduce(combine).updated_at?.toIso8601String(),
    );
  }

  static List<NameModel>? _status;
  static List<NameModel> get status {
    return _status ??=
        GetStorage()
            .read<List<dynamic>>('status')
            ?.map((e) => NameModel.fromJson(e))
            .toList() ??
        [];
  }

  static set status(List<NameModel>? value) {
    if (value == null || value.isEmpty) {
      return;
    }
    _status = value;
    GetStorage().write('status', value.map((e) => e.toJson()).toList());
    GetStorage().write(
      'statuses_date',
      value.reduce(combine).updated_at?.toIso8601String(),
    );
  }

  static List<NameModel>? _aimagCities;
  static List<NameModel> get aimagCities {
    return _aimagCities ??=
        GetStorage()
            .read<List<dynamic>>('aimagCities')
            ?.map((e) => NameModel.fromJson(e))
            .toList() ??
        [];
  }

  static set aimagCities(List<NameModel>? value) {
    if (value == null || value.isEmpty) {
      return;
    }
    _aimagCities = value;
    GetStorage().write('aimagCities', value.map((e) => e.toJson()).toList());
    GetStorage().write(
      'aimag_cities_date',
      value.reduce(combine).updated_at?.toIso8601String(),
    );
  }

  static List<NameModel>? _soumDistricts;
  static List<NameModel> get soumDistricts {
    return _soumDistricts ??=
        GetStorage()
            .read<List<dynamic>>('soumDistricts')
            ?.map((e) => NameModel.fromJson(e))
            .toList() ??
        [];
  }

  static set soumDistricts(List<NameModel>? value) {
    if (value == null || value.isEmpty) {
      return;
    }
    _soumDistricts = value;
    GetStorage().write('soumDistricts', value.map((e) => e.toJson()).toList());
    GetStorage().write(
      'soum_districts_date',
      value.reduce(combine).updated_at?.toIso8601String(),
    );
  }

  static List<NameModel>? _bagHoroos;
  static List<NameModel> get bagHoroos {
    return _bagHoroos ??=
        GetStorage()
            .read<List<dynamic>>('bagHoroos')
            ?.map((e) => NameModel.fromJson(e))
            .toList() ??
        [];
  }

  static set bagHoroos(List<NameModel>? value) {
    if (value == null || value.isEmpty) {
      return;
    }
    _bagHoroos = value;
    GetStorage().write('bagHoroos', value.map((e) => e.toJson()).toList());
    GetStorage().write(
      'bag_horoos_date',
      value.reduce(combine).updated_at?.toIso8601String(),
    );
  }

  static double? _mh;
  static double get mh {
    return _mh ??= GetStorage().read<double>('mh') ?? 0;
  }

  static set mh(double? value) {
    if (value == null) {
      return;
    }
    _mh = value;
    GetStorage().write('mh', value);
  }

  static Map<String, int>? _statistic;
  static Map<String, int> get statistic {
    return _statistic ??= jsonDecode(
      GetStorage().read<String>('statistic') ?? '{}',
    );
  }

  static set statistic(Map<String, int>? value) {
    if (value == null) {
      return;
    }
    _statistic = value;

    GetStorage().write('statistic', jsonEncode(value));
  }

  static List<NameModel>? _resolves;
  static List<NameModel> get resolves {
    return _resolves ??=
        GetStorage()
            .read<List<dynamic>>('resolves')
            ?.map((e) => NameModel.fromJson(e))
            .toList() ??
        [];
  }

  static set resolves(List<NameModel>? value) {
    if (value == null || value.isEmpty) {
      return;
    }
    _resolves = value;
    GetStorage().write('resolves', value.map((e) => e.toJson()).toList());
    GetStorage().write(
      'resolves_date',
      value.reduce(combine).updated_at?.toIso8601String(),
    );
  }
}
