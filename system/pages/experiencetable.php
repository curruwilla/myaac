<?php

defined('MYAAC') or die('Direct access not allowed!');
$title = 'Experience Table';

$experience = [];
$columns = $config['experiencetable_columns'];
for ($i = 0; $i < $columns; $i++) {
    for ($level = $i * $config['experiencetable_rows'] + 1; $level < $i * $config['experiencetable_rows'] + ($config['experiencetable_rows'] + 1); $level++) {
        $experience[$level] = OTS_Toolbox::experienceForLevel($level);
        $experience[$level] = number_format($experience[$level], 0, ',', ',');
    }
}

$twig->display('experience_table.html.twig', [
    'experience' => $experience,
]);
