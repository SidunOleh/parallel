<?php

function parallel(
    array $tasks, 
    callable $callback, 
    int $processes_count
) {
    for (
        $process_numb=0; 
        $process_numb < $processes_count; 
        $process_numb++
    ) { 
        $pid = pcntl_fork();
        
        if ($pid == -1) {
            throw new Exception('Fork error.');
        }

        if ($pid == 0) {
            break;
        }
    }

    if ($pid) {
        for ($i=0; $i < $processes_count; $i++) { 
            pcntl_wait($status);
        }
        return;
    }

    for (
        $i=$process_numb; 
        $i < count($tasks); 
        $i=$i+$processes_count
    ) { 
        $callback($tasks[$i]);
    }
    die;
}
