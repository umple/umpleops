#!/bin/bash
# Serves mapping.php with PHP's built-in server and checks each line of cases.txt:
# host, path, expected Location as curl resolves it (relative to the test server).
cd "$(dirname "$0")" || exit 1
port=${PORT:-8199}
base="http://127.0.0.1:$port"

php -S 127.0.0.1:$port mapping.php >/dev/null 2>&1 &
server=$!
trap 'kill $server 2>/dev/null' EXIT

# Wait until mapping.php answers with a redirect. If php exits instead (e.g. the port
# is taken), stop rather than test whatever else is listening there.
for i in $(seq 50); do
  kill -0 $server 2>/dev/null || { echo "php could not serve on port $port"; exit 1; }
  [ -n "$(curl -s --max-time 1 -o /dev/null -w '%{redirect_url}' -H 'Host: umple.org' "$base/")" ] && break
  sleep 0.1
done

count=0
failed=0
while read -r host path expected || [ -n "$host" ]; do
  count=$((count + 1))
  if ! got=$(curl -s --max-time 5 -o /dev/null -w '%{redirect_url}' -H "Host: $host" "$base$path"); then
    echo "FAIL $host$path: request failed"
    failed=1
    continue
  fi
  got=${got#$base}
  if [ "$got" != "$expected" ]; then
    echo "FAIL $host$path: expected $expected, got $got"
    failed=1
  fi
done < cases.txt

kill -0 $server 2>/dev/null || { echo "php stopped during the run"; exit 1; }
[ $count -gt 0 ] || { echo "no cases ran"; exit 1; }
[ $failed = 0 ] && echo "All $count cases pass"
exit $failed
