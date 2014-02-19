#!/usr/bin/env bash

sed -i '' "s/your-secret-salt-here/$(cat \/dev\/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)/g" ../application/bootstrap.php
