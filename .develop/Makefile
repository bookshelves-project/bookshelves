.PHONY : clean aab apk apk-split ios

# Detect operating system in Makefile.
# Author: He Tao
# Date: 2015-05-30

OSFLAG 				:=
EXT 				:=
ifeq ($(OS),Windows_NT)
	OSFLAG = windows
	EXT = ps1
else
	UNAME_S := $(shell uname -s)
	ifeq ($(UNAME_S),Linux)
		OSFLAG = linux
		EXT = sh
	endif
	UNAME_S := $(shell uname -s)
	ifeq ($(UNAME_S),Linux)
		OSFLAG = linux
		EXT = sh
	endif
	ifeq ($(UNAME_S),Darwin)
		OSFLAG = osx
		EXT = sh
	endif
endif

all:
ifeq ($(OSFLAG),osx)
	$(MAKE) ios
else
	$(MAKE) aab
endif

clean:
	flutter clean
ifeq ($(OSFLAG),windows)
	pwsh ./bin/clean.$(EXT)
else ifeq ($(TARGET_CPU),osx)
	rm -f *.aab
	rm -f *.apk
	rm -Rf ios/Pods
	rm -Rf ios/.symlinks
	rm -Rf ios:Flutter/Flutter.framework
	rm -Rf ios/Flutter/Flutter.podspec
	rm -f ios/Podfile.lock
	flutter pub get 
	cd ios; \
	pod update; \
	cd ../;
else
	rm -f *.aab
	rm -f *.apk
endif

aab: clean
	flutter build appbundle --release
ifeq ($(OSFLAG),windows)
	pwsh ./bin/app-bundle.$(EXT)
else
	cp build/app/outputs/bundle/release/app-release.aab
endif
	@echo app-release.aab is available at repository root!

apk: clean
	flutter build apk
ifeq ($(OSFLAG),windows)
	pwsh ./bin/apk.$(EXT)
else
	cp build/app/outputs/flutter-apk/app-release.apk
endif
	@echo app-release.apk is available at repository root!

apk-split: clean
	flutter build apk --split-per-abi
ifeq ($(OSFLAG),windows)
	pwsh ./bin/apk-split.$(EXT)
else
	cp build/app/outputs/flutter-apk/app-armeabi-v7a-release.apk
endif
	@echo app-armeabi-v7a-release.apk is available at repository root!

ios: clean
	flutter build ios

json:
	flutter pub run build_runner watch --delete-conflicting-outputs

icon:
	flutter pub run flutter_launcher_icons:main

splash:
	flutter pub run flutter_native_splash:create
