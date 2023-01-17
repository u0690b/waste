import 'dart:developer';
import 'dart:io';

import 'package:flutter/material.dart';
import 'package:flutter_typeahead/flutter_typeahead.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;
import 'package:waste_mobile/controllers/cache_manager.dart';
import 'dart:convert';

import 'package:waste_mobile/utils/contants.dart';

class CompanyUAChiglelFormField extends StatefulWidget {
  final void Function(String val)? onChange;
  final String initText;
  final TextEditingController? textEditingController;
  const CompanyUAChiglelFormField(
      {super.key,
      this.onChange,
      required this.initText,
      this.textEditingController});

  @override
  State<CompanyUAChiglelFormField> createState() =>
      _CompanyUAChiglelFormField();
}

class _CompanyUAChiglelFormField extends State<CompanyUAChiglelFormField> {
  late TextEditingController _typeAheadController;

  @override
  void initState() {
    super.initState();
    _typeAheadController = widget.textEditingController != null
        ? widget.textEditingController!
        : TextEditingController(text: widget.initText);
  }

  Map<String, String> _hasToken() {
    final token = GetStorage().read<String>(CacheManagerKey.TOKEN.toString());
    if (token == null) {
      return {};
    }
    return {'Authorization': "Bearer $token"};
  }

  Future<List<Map<String, String>>> _getOptions(String searchTerm) async {
    final response = await http.get(
        Uri.parse(
          '${Constants.host}/api/industries?search=$searchTerm',
        ),
        headers: {
          'User-Agent': 'waste_mobile',
          'Accept': 'application/json',
          HttpHeaders.contentTypeHeader: 'application/json',
          ..._hasToken()
        });
    final ret = json.decode(response.body) as List;
    print(ret);
    return ret.map((v) {
      return {'id': v['id'].toString(), 'name': v['name'].toString()};
    }).toList();
  }

  @override
  Widget build(BuildContext context) {
    return TypeAheadFormField(
      textFieldConfiguration: TextFieldConfiguration(
        controller: this._typeAheadController,
        decoration: InputDecoration(
          contentPadding:
              const EdgeInsets.symmetric(horizontal: 20.0, vertical: 15.0),
          labelText: 'Үйл Ажиллагааны чиглэл:',
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(5.0),
          ),
        ),
      ),
      suggestionsCallback: (pattern) {
        if (widget.onChange != null) widget.onChange!(pattern);
        return _getOptions(pattern);
      },
      itemBuilder: (context, suggestion) {
        return ListTile(
          title: Text(suggestion['name'] ?? ''),
        );
      },
      transitionBuilder: (context, suggestionsBox, controller) {
        return suggestionsBox;
      },
      onSuggestionSelected: (suggestion) {
        this._typeAheadController.text = suggestion['name'] ?? '';
        if (suggestion['name'] != null && widget.onChange != null)
          widget.onChange!(suggestion['name']!);
      },
      onSaved: (value) {
        this._typeAheadController.text = value ?? '';
        log(value ?? '');
      },
    );
  }
}
