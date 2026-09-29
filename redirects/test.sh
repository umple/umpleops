#!/bin/bash
# Serves mapping.php with PHP's built-in server and checks each line of cases.txt:
# host, path, expected Location.
cd "$(dirname "$0")"
php -S 127.0.0.1:8199 mapping.php >/dev/null 2>&1 &
server=$!
trap 'kill $server' EXIT
sleep 1

failed=0
while read -r host path expected; do
  got=$(curl -s -o /dev/null -w '%{redirect_url}' -H "Host: $host" "http://127.0.0.1:8199$path" | sed 's#^http://127.0.0.1:8199##')
  if [ "$got" != "$expected" ]; then
    echo "FAIL $host$path: expected $expected, got $got"
    failed=1
  fi
done < cases.txt

[ $failed = 0 ] && echo "All cases pass"
exit $failed
