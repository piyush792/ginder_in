<?php
    class SearchComponent extends Component {

        var $controller = null;

        function initialize(&$controller)
        {
            $this->controller = $controller;
        }

        function getConditions()
        {
            $conditions = array();
            $data= empty($this->controller->params['named']) ? $this->controller->params['url'] : $this->controller->params['named'] ;
            $this->controller->{$this->controller->modelClass}->schema();

            foreach($data as $key=>$value)
            {
                if(strpos($key,"#") > 0 && $value != "")
                {
                  $hashArr = split("#",$key);
                  $conditions[$hashArr[0]. "." .$hashArr[1] . " LIKE"] = "%".trim($value)."%";
                }
                else
                {
                    if(isset($this->controller->{$this->controller->modelClass}->_schema[$key]) && $value != "")
                    {
                        switch($this->controller->{$this->controller->modelClass}->_schema[$key]['type']){
                            case "string":
                            $conditions[$this->controller->modelClass . "." .$key . " LIKE"] = "%".trim($value)."%";
                            break;
                            case "integer":
                            $conditions[$this->controller->modelClass . "." .$key] =  $value;
                            break;
                            case "datetime":
                            if(isset($value) && $value != ""){
                                $from = date("Y-m-d", strtotime($value));
                                $conditions["substring(".$this->controller->modelClass.".".$key.",1,10) ="] = trim($from);
                            }
                        }
                    }

                }

            }
            return $conditions;

        }


    }
?>