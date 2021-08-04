<?php

    /*   MangosWeb  Main class.
     *   @Main author: Peec
     *   @Edited by: -
     *   @Called with: $MW = new mangosweb();
     */

    class mangosweb{

        // Holds config from the XML file. Class based.
        public $getConfig;
        // Holds DB configuration.
        public $getDbInfo = array();
        
        // Holds paths.
        public $path_configxml = "config/config.xml";
        public $path_protectedconf = "config/config-protected.php";
        
        // Holds content output.
        public $content_output;

        /**  @Job: Construct mangosweb
          *  @params: (Not needed)$path_configxml  ( The path to config.xml )   -   (Not needed) $path_protectedconf (Path to config-protected.php)
          *
          */
        public function mangosweb($path_configxml=false,$path_protectedconf=false){
            if ($path_configxml)$this->path_configxml = $path_configxml;
            if ($path_protectedconf)$this->path_protectedconf = $path_protectedconf;
           $this->parse_configxml();
           
        }


        private function parse_configxml(){
            include($this->path_protectedconf);
            $this->getConfig = simplexml_load_file($this->path_configxml);
            $this->getDbInfo = $realmd;
        }
        public function save_new_configs(){
            file_put_contents($this->path_configxml, $this->getConfig->asXML());
            return true;
        }
        public function add_temp_confs($xml_conf=array()){
            if ($xml_conf){
                $REWRITE = false;
                foreach($xml_conf as $self => $val){
                    if ($this->getConfig->temp->$self == '' && $val != ''){
                        if (array_key_exists($self, $this->getConfig->temp)){
                            $this->getConfig->temp->$self = $val;
                        }else{
                            $this->getConfig->temp->addChild($self, $val);
                        }
                        $REWRITE = true;
                    }
                }
                if ($REWRITE){
                    $this->save_new_configs();
                }
            }


            return true;
        }
        
        
        
        
        public function add_output($op){
            $this->content_output .= $op;
        }

    }
?>
