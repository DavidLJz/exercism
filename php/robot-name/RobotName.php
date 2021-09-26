<?php

declare(strict_types=1);

class Robot
{
    protected $name = '';
    protected static $past_names = [];

    protected function generateName() :string
    {
        do {
            $name = [];

            $name[] = chr( rand(65, 90) );
            $name[] = chr( rand(65, 90) );
            $name[] = str_pad((string) rand(0,999), 3, (string) rand(0,9));

            $name = join('', $name);

        } 

        // based on zembrowski's solution
        while ( in_array($name, self::$past_names) );

        return $name;
    }

    public function getName(): string
    {
        if ( empty($this->name) ) {
            $this->name = $this->generateName();
            self::$past_names[] = $this->name;
        }

        return $this->name;
    }

    public function reset(): void
    {
        $this->name = '';
    }
}
