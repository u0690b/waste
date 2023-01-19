import 'dart:io';

import 'package:flutter/material.dart';
import 'package:video_player/video_player.dart';
import 'package:path_provider/path_provider.dart';

class MyVideoPlayerFile extends StatefulWidget {
  final List<int> file;
  const MyVideoPlayerFile({super.key, required this.file});

  @override
  State<MyVideoPlayerFile> createState() => _MyVideoPlayerFileState();
}

class _MyVideoPlayerFileState extends State<MyVideoPlayerFile> {
  VideoPlayerController? _controller;

  @override
  void initState() {
    super.initState();
    initController();
  }

  initController() async {
    final path = (await getTemporaryDirectory()).path +
        '/${DateTime.now().toIso8601String()}.mp4';
    final _file = File(path);
    _file.writeAsBytes(widget.file);
    _controller = VideoPlayerController.file(_file)
      ..initialize().then((_) {
        _controller!.setLooping(true);
        _controller!.play();
        setState(() {});
      });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(backgroundColor: Colors.black),
      backgroundColor: Colors.black,
      body: Center(
        child: _controller != null && _controller!.value.isInitialized
            ? AspectRatio(
                aspectRatio: _controller!.value.aspectRatio,
                child: VideoPlayer(_controller!),
              )
            : CircularProgressIndicator(),
      ),
      floatingActionButton: _controller == null
          ? null
          : FloatingActionButton(
              onPressed: () {
                setState(() {
                  _controller != null && _controller!.value.isPlaying
                      ? _controller!.pause()
                      : _controller!.play();
                });
              },
              child: Icon(
                _controller!.value.isPlaying ? Icons.pause : Icons.play_arrow,
              ),
            ),
    );
  }

  @override
  void dispose() {
    super.dispose();
    _controller?.dispose();
  }
}
