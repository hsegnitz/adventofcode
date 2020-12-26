<?php

$target = "a0c";
$message = `git log -1 --pretty=%B`;

$message .= "\n";

$sha = "";

$i = 0;
while (0 !== strpos($sha, $target)) {
$m = $message . $i++;

$out = `git commit --amend -m "$m"`;

preg_match('/\[.* ([0-9a-f]{7,})] /', $out, $o);
$sha = $o[1];

echo $sha, " ", $i, "\n";
#    die();
}
