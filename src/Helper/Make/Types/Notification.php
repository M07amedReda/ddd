<?php

namespace MohamedReda\DDD\Helper\Make\Types;

use MohamedReda\DDD\Helper\FileCreator;
use MohamedReda\DDD\Helper\Make\Maker;
use MohamedReda\DDD\Helper\NamespaceCreator;
use MohamedReda\DDD\Helper\Naming;
use MohamedReda\DDD\Helper\Path;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Notification extends Maker
{
    /**
     * Options to be available once Command-Type is called
     *
     * @return Array
     */
    public $options = [
        'name',
        'domain',
        'command_http_general',
    ];

    /**
     * Return options that should be treated as choices 
     *
     * @return Array
     */
    public $allowChoices = [
        'domain',
        'command_http_general',
    ];

    /**
     * Fill all placeholders in the stub file
     *
     * @param array $values
     * @return boolean
     */
    public function service(Array $values = []):bool{

        $name = Naming::class($values['name']);
        
        $placeholders = [ 
            '{{DOMAIN}}' => $values['domain'],
            '{{NAME}}' => $name,
            '{{TYPE}}' => $values['command_http_general'],
        ];

        $className = $name.'Notification';

        $destination = Path::toDomain($values['domain'],'Notifications',$values['command_http_general']);

        $content = Str::of($this->getStub('notification'))
                        ->replace(array_keys($placeholders),array_values($placeholders));

        $this->save($destination,$className,'php',$content);

        return true;
    }
}
