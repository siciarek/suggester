#!/usr/bin/env sh
SRC_DIR="`pwd`"
cd "`dirname "$0"`"
cd "../vendor/phalcon/devtools"
BIN_TARGET="`pwd`/phalcon.php"
cd "$SRC_DIR"
"$BIN_TARGET" "$@"
