<?php

function diffArrays(array $oldRegions, array $newRegions): array
{
    return [
        'not_enough_regions' => array_diff($oldRegions, $newRegions),
        'new_regions' => array_diff($newRegions, $oldRegions),
    ];
}
