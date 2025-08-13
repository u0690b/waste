import 'dart:developer';
import 'dart:io';

import 'package:flutter/material.dart';
import 'package:flutter_typeahead/flutter_typeahead.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;
import 'package:waste_mobile/controllers/cache_manager.dart';
import 'dart:convert';

import 'package:waste_mobile/utils/contants.dart';

class CompanyNameFormField extends StatefulWidget {
  final void Function(String val) changeCompanyName;
  final void Function(String val, String industry) changeRegister;
  final String initText;
  const CompanyNameFormField({
    super.key,
    required this.changeCompanyName,
    required this.changeRegister,
    required this.initText,
  });

  @override
  State<CompanyNameFormField> createState() => _CompanyNameFormField();
}

class _CompanyNameFormField extends State<CompanyNameFormField> {
  final TextEditingController _typeAheadController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _typeAheadController.text = widget.initText;
  }

  Map<String, String> _hasToken() {
    final token = GetStorage().read<String>(CacheManagerKey.TOKEN.toString());
    if (token == null) {
      return {};
    }
    return {'Authorization': "Bearer $token", 'X-Auth-Token': "Bearer $token"};
  }

  Future<List<Map<String, String>>> _getOptions(String searchTerm) async {
    final response = await http.get(
      Uri.parse('${Constants.host}/api/entities?search=$searchTerm'),
      headers: {
        'User-Agent': 'waste_mobile',
        'Accept': 'application/json',
        HttpHeaders.contentTypeHeader: 'application/json',
        ..._hasToken(),
      },
    );
    final ret = json.decode(response.body) as List;
    print(ret);
    return ret.map((v) {
      return {
        'id': v['id']?.toString() ?? '',
        'name': v['name']?.toString() ?? '',
        'industry': v['industry']?.toString() ?? '',
      };
    }).toList();
  }

  @override
  Widget build(BuildContext context) {
    return TypeAheadFormField(
      textFieldConfiguration: TextFieldConfiguration(
        controller: this._typeAheadController,
        decoration: InputDecoration(
          contentPadding: const EdgeInsets.symmetric(
            horizontal: 20.0,
            vertical: 15.0,
          ),
          labelText: 'Албан байгууллага нэр',
          border: OutlineInputBorder(borderRadius: BorderRadius.circular(5.0)),
        ),
      ),
      suggestionsCallback: (pattern) {
        widget.changeCompanyName(pattern);
        if (pattern.isEmpty || pattern.length < 3) {
          return Future.value([]);
        }
        return _getOptions(pattern);
      },
      itemBuilder: (context, suggestion) {
        return ListTile(title: Text(suggestion['name'] ?? ''));
      },
      transitionBuilder: (context, suggestionsBox, controller) {
        return suggestionsBox;
      },
      onSuggestionSelected: (suggestion) {
        this._typeAheadController.text = suggestion['name'] ?? '';
        if (suggestion['name'] != null)
          widget.changeCompanyName(suggestion['name']!);
        if (suggestion['id'] != null)
          widget.changeRegister(
            suggestion['id']!,
            suggestion['industry'] ?? '',
          );
      },
      validator: (value) {
        if (value != null && value.isEmpty) {
          return 'Please select a Нэр';
        }
        return null;
      },
      onSaved: (value) {
        this._typeAheadController.text = value ?? '';
        log(value ?? '');
      },
    );
  }
}
