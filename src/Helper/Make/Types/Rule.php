<?php

namespace MohamedReda\DDD\Helper\Make\Types;

use MohamedReda\DDD\Helper\FileCreator;
use MohamedReda\DDD\Helper\Make\Maker;
use MohamedReda\DDD\Helper\NamespaceCreator;
use MohamedReda\DDD\Helper\Naming;
use MohamedReda\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Rule extends Maker
{
    /**
     * Options to be available once Command-Type is cllade
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
    ];

    /**
     * Return options that should be treated as choices 
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
    ];

    /**
     * Fill all placeholders in the stub file
     *
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $name = Naming::class($values['name']);
        
        $placeholders = [ 
            '{{NAME}}' => $name,
            '{{DOMAIN}}' => $values['domain'],
        ];  

        $className = $name.'Rule';

        $destination = Path::toDomain($values['domain'],'Http','Rules');

        $content = Str::of($this->getStub('rule'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$className,'php',$content);

        return true;
    }
}
