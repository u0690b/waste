import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class CompanyNameFormField extends StatefulWidget {
  const CompanyNameFormField({super.key});

  @override
  State<CompanyNameFormField> createState() => _CompanyNameFormField();
}

class _CompanyNameFormField extends State<CompanyNameFormField> {
  final _formKey = GlobalKey<FormState>();
  String? _selectedValue;
  String _searchTerm = '';
  List<dynamic> _options = [];
  bool _isLoading = false;

  Future<void> _getOptions(String searchTerm) async {
    setState(() {
      _isLoading = true;
    });

    final response = await http.get(Uri.parse(
      'https://myapi.com/options?search=$searchTerm',
    ));
    final options = json.decode(response.body);

    setState(() {
      _options = options;
      _isLoading = false;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: <Widget>[
                Text(_selectedValue ?? 'No value selected'),
                FormField<String>(validator: (value) {
                  if (value == null) {
                    return 'Please select a value';
                  }
                  return null;
                }, builder: (FormFieldState<String> state) {
                  return Container(
                    child: Column(children: <Widget>[
                      TextField(
                        onChanged: (value) {
                          setState(() {
                            _searchTerm = value;
                          });
                          _getOptions(value);
                        },
                        decoration: InputDecoration(
                          border: InputBorder.none,
                          hintText: 'Search',
                          errorText: state.hasError ? state.errorText : null,
                        ),
                      ),
                      _isLoading
                          ? CircularProgressIndicator()
                          : Expanded(
                              child: ListView.builder(
                                itemCount: _options.length,
                                itemBuilder: (BuildContext context, int index) {
                                  final option = _options[index];
                                  return ListTile(
                                    title: Text(option['name']),
                                    onTap: () {
                                      setState(() {
                                        _selectedValue = option['name'];
                                        state.didChange(option['name']);
                                      });
                                    },
                                  );
                                },
                              ),
                            )
                    ]),
                  );
                })
              ]),
        ),
      ),
    );
  }
}
