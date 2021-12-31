<?php

namespace MohamedReda\DDD\Helper\Make\Types;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use MohamedReda\DDD\Helper\Make\Array;
use MohamedReda\DDD\Helper\Make\Maker;
use MohamedReda\DDD\Helper\Naming;
use MohamedReda\DDD\Helper\Path;

class Provider extends Maker
{
    /**
     * Options to be available once Command-Type is called
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


    public function service(array $values): bool
    {
        $domain = Naming::class($values['domain']);
        $file = Naming::class($values['name']);
        $name   = Naming::class($values['name']);

        $placeholders = [
            '{{DOMAIN}}' => $domain,
            '{{$name}}'   => $name,
        ];
        $destination = Path::toDomain($domain,'Providers');

        $content = Str::of($this->getStub('provider'))->replace(array_keys($placeholders),array_values($placeholders));


        $this->save($destination, $file, 'php', $content);


        $domainServiceProviderPath = Path::toDomain($values['domain'],'Providers');

        $content = File::get(Path::build($domainServiceProviderPath,'DomainServiceProvider.php'));

        $domainServiceProviderContent = Str::of($content)->replace(
            "###PROVIDERS###",
            "###PROVIDERS###\n\t\t{$name}::class,"
        );

        $this->save($domainServiceProviderPath,'DomainServiceProvider','php',$domainServiceProviderContent);

        return true;
    }
}
