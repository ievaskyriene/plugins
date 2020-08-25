<?php

class App {
   
    private $routeDir;
    private $viewDir;
    private $resourseDir;

    public function __construct(){
        $this->routeDir = plugin_dir_path(__FILE__).'routes'; 
        $this->viewDir = plugin_dir_path(__FILE__).'views'; 
        $this->resourseDir = plugin_dir_path(__FILE__).'resources'; 
    }
    
    static public function start(){
        return new self;
    }


    public function __get($dir)
    {
        switch($dir){
            case "routeDir":
                return $this->routeDir; 
                break;
            case "viewDir":
                return $this->routeDir;
                break;
            case "resourseDir":
                return $this->resourseDir;
                break;
            default:
                throw new Exception("Property $dir does not exist.");
                break;
        }
    }

    // public function __get($route)
    // {
    //   if ($route == 'routeDir'){
    //       return $this->routeDir;
    //   }
    // }

    // 3 variantas
    // public function getViewDir()
    // {
    //     return $this->viewDir;
    // }

    // public function getRouteDir()
    // {
    //     return $this->routeDir;
    // }
}