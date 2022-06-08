#!/bin/sh
set -e

make build-backend-dev

exec "$@"