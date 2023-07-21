<?php

return [
    'hash' => exec('git log --pretty="%h" -n1 HEAD'),
];
