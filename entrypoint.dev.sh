#!/bin/bash

if [ ! -d "vendor" ]; then
  composer i
fi

exec "$@"
