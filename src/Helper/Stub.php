<?php

namespace MohamedReda\DDD\Helper;

use MohamedReda\DDD\Helper\Make\Types\Controller;
use MohamedReda\DDD\Helper\Make\Types\DatabaseView;
use MohamedReda\DDD\Helper\Make\Types\Datatable;
use MohamedReda\DDD\Helper\Make\Types\Domain;
use MohamedReda\DDD\Helper\Make\Types\Entity;
use MohamedReda\DDD\Helper\Make\Types\Factory;
use MohamedReda\DDD\Helper\Make\Types\Migration;
use MohamedReda\DDD\Helper\Make\Types\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait Stub
{
    /**
     * Retrieve the path to a specific stub
     *
     * @param [type] $name
     * @return string
     */
    public function stubPath():string{

        $directories = ArrayFormatter::trim($this->stub,DIRECTORY_SEPARATOR);
        
        $file = array_pop($directories); 
        
        $path = Path::stub(...$directories).$file;

        return $path;
    }

        /**
     * Retrieve the path to a specific stub
     *
     * @param [type] $name
     * @return string
     */
    public function stubContent():string{

        return File::get($this->stubPath());

    }

    /**
     * Get Stub
     * 
     * @param string $name
     * @return string
     */
    public function getStub($name,$content = true){

        $stubs = config('ddd.stubs');
        if(array_key_exists($name,$stubs)){

            $path = Path::stub().ltrim($stubs[$name],DIRECTORY_SEPARATOR);
            
            return $content === true ? File::get($path) : $path;
        }else{
            throw new \Exception("File Not Found");
            exit();
        }

    }

}
