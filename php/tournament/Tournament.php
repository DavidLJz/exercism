<?php

declare(strict_types=1);

class Tournament
{
    public function __construct()
    {
    }

    public function tally(string $scores='')
    {
        $output = 'Team                           | MP |  W |  D |  L |  P';

        if ( !$scores ) return $output;

        $matchStrings = explode('\n', trim($scores));

        if ( !$matchStrings ) return $output;

        $teamsData = [];

        foreach ($matchStrings as $matchStr) {
            $matchArr = array_filter(explode(';', $matchStr));

            if ( count($matchArr) < 3 ) continue;

            $teams = [
                $matchArr[0], $matchArr[1]
            ];

            $result = $matchArr[2];

            foreach ($teams as $n => $team) {
                if ( $n === 0 ) {
                    $win_condition = 'win';
                } else {
                    $win_condition = 'loss';
                }

                $win = 0;
                $draw = 0;
                $loss = 0;

                if ( $result === $win_condition ) {
                    $win = 1;
                } elseif ($result === 'draw') {
                    $draw = 1;
                } else {
                    $loss = 1;
                }

                $points = 0;

                if ( $win ) {
                    $points = 3;
                } elseif ($draw) {
                    $points = 1;
                }

                if ( empty($teamsData[ $team ]) ) {
                    $teamsData[ $team ] = [
                        'MP' => 1,
                        'W' => $win,
                        'D' => $draw,
                        'L' => $loss,
                        'P' => $points
                    ];
                }

                else {
                    $teamsData[ $team ]['MP']++;
                    $teamsData[ $team ]['W'] += $win;
                    $teamsData[ $team ]['D'] += $draw;
                    $teamsData[ $team ]['L'] += $loss;
                    $teamsData[ $team ]['P'] += $points;
                }
            }
        }

        ksort($teamsData);

        $pointsCol = array_column($teamsData, 'P');

        array_multisort($pointsCol, SORT_DESC, $teamsData);

        $output .= '\n';

        $n = 0;
        $count = count($teamsData) - 1;

        foreach ( $teamsData as $team => $teamData ) {
            $teamData = array_map('strval', $teamData);

            $line = str_pad($team, 31) . '|';

            foreach ( $teamData as $k => $val ) {
                $line .= str_pad(strval($val), 3, ' ', STR_PAD_LEFT);

                if ($k !== 'P') {
                    $line .= ' |';
                }
            }

            $output .= $line . ( $n !== $count ? '\n' : '') ;

            $n++;
        }

        return $output;
    }
}
