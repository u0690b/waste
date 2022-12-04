import 'package:flutter/material.dart';

class AppDropdownInput<T> extends StatelessWidget {
  final String hintText;
  final List<T> options;
  final T? value;
  final String Function(T) getLabel;
  final void Function(T?)? onChanged;
  final String? Function(T?)? validator;

  final bool enabled;
  const AppDropdownInput({
    super.key,
    this.hintText = 'Please select an Option',
    this.options = const [],
    required this.getLabel,
    this.value,
    this.onChanged,
    this.validator,
    this.enabled = true,
  });

  @override
  Widget build(BuildContext context) {
    return FormField<T>(
      enabled: enabled,
      validator: validator,
      builder: (FormFieldState<T> state) {
        return InputDecorator(
          decoration: InputDecoration(
            contentPadding:
                const EdgeInsets.symmetric(horizontal: 20.0, vertical: 15.0),
            labelText: hintText,
            border:
                OutlineInputBorder(borderRadius: BorderRadius.circular(5.0)),
          ),
          isEmpty: value == null || value == '',
          child: !enabled
              ? Text(value != null ? getLabel(value as T) : '')
              : DropdownButtonHideUnderline(
                  child: DropdownButton<T>(
                    value: value,
                    isDense: true,
                    onChanged: onChanged,
                    items: options.map((T value) {
                      return DropdownMenuItem<T>(
                        value: value,
                        child: Text(getLabel(value)),
                      );
                    }).toList(),
                  ),
                ),
        );
      },
    );
  }
}
