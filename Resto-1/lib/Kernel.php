<?php
//
//
//class Kernel
//{
//
//    private $viewData;
//
//    public function loadClass($class)
//    {
//        if (substr($class, -10) == "Controller")
//        {
//            $fileName = "app/controller/$class.php";
//        }
//        elseif (substr($class, -5) == "Model")
//        {
//            $fileName = "app/models/$class.php";
//
//        }
//        else
//        {
//            $fileName = "app/class/$class.php";
//        }
//
//        if (file_exists($fileName))
//        {
//            include $fileName;
//        }
//        else
//        {
//            throw new ErrorException("Impossible de trouver la classe \" $class\" dans  \" $fileName\" ");
//        }
//
//    }
//
//    public function __construct()
//    {
//        spl_autoload_register([$this, "loadClass"]);
//        $this->viewData = [];
//    }
//
//
//    public function run()
//    {
//
//        if (isset($_SERVER["PATH_INFO"]))
//        {
//            $requestPath = $_SERVER["PATH_INFO"];
//
//        }
//        else
//        {
//            $requestPath = "/";
//        }
//        /* var_dump($_SERVER);*/
//
//        $router = Router::getInstance();
//
//        $router->getRoute($requestPath);
//        $requestRoute = $router->getRoute($requestPath);
//
//        $controllerName = $requestRoute["controller"] . "Controller";
//
//        $controller = new $controllerName();
//
//        $methodeName = $requestRoute["method"] . "Action";
//        if (method_exists($controller, $methodeName))
//        {
//            /*$controller->$methodeName();*/
//            $this->viewData = array_merge($this->viewData, (array)$controller->$methodeName());
//            $this->renderResponse();
//
//        }
//        else
//        {
//            throw new ErrorException("Impossible de trouver la methode \" $methodeName\" dans  \" $controllerName\" ");
//        }
//
//    }
//
//    public function renderResponse()
//    {
//        extract($this->viewData, EXTR_OVERWRITE);
//
//
//        if (isset($template))
//        {
//            $templatePath = "www/views";
//            $templatePath .= "/" . $template['folder'];
//            $templatePath .= "/" . $template["file"];
//            $templatePath .= "View.phtml";
//
//            include "www/views/layout.phtml";
//        }
//        elseif (isset($redirect))
//        {
//            if (gettype($redirect) == "string")
//            {
//                $redirectionUrl = Router::getInstance()->generateUrl($redirect);
//            }
//            else
//            {
//                $redirectionUrl = Router::getInstance()->generateUrl($redirect["routeName"]);
//                $args = $redirect["args"];
//                if (count($args) > 0)
//                {
//                    $redirectionUrl .= "?";
//                }
//                foreach ($args as $argName => $argValue)
//                {
//                    $redirectionUrl .= "$argName=$argValue&";
//                }
//
//                $redirectionUrl = substr($redirectionUrl, 0, -1);
//            }
//
//            header("Location:$redirectionUrl");
//            die();
//        }
//        elseif (isset($jsonResponse))
//        {
//            echo json_encode($jsonResponse);
//            die();
//        }
//        else
//        {
//            throw  new ErrorException("format de réponse non reconnu");
//        }
//    }
//}
//



class Kernel
{
    private $viewData ;

    public function __construct()
    {
        spl_autoload_register([$this,"loadClass"]);
        $this->viewData = [] ;
    }

    public function loadClass($class)
    {
        if(substr($class,  -10) == "Controller")
        {
            $filename = "app/controllers/$class.php";
        }
        elseif(substr($class,  -5) == "Model")
        {
            $filename = "app/models/$class.php";
        }
        else
        {
            $filename = "app/class/$class.php";
        }

        if(file_exists($filename))
        {
            include  $filename;
        }
        else
        {
            throw new ErrorException("Impossible de trouver la class \"$class\" dans \"$filename\" .£");
        }
    }

    public function run()
    {
        if (isset($_SERVER["PATH_INFO"]))
        {
            $requestPath = $_SERVER["PATH_INFO"];
        }
        else
        {
            $requestPath ="/";
        }
        $router = Router::getInstance() ;
        //appeler la function
        $requestRoute = $router->getRoute($requestPath);
        //controller cle de la route,
        $controllerName = $requestRoute["controller"]."Controller";
        //fond the method
        $controller = new $controllerName();

        $methodName = $requestRoute["method"]."Action" ;
        if(method_exists($controller, $methodName))
        {
            $this->viewData = array_merge(
                $this->viewData,
                (array)$controller->$methodName()
            ) ;
            $this->renderResponse() ;
        }
        else
        {
            throw new ErrorException("La méthode \"$methodName\" n'a pue etre trouvée dans le controleur \"$controllerName\"") ;
            //avec ca on a affiché cette = public function mainAction()
        }

    }
    public function renderResponse()
    {
        extract($this->viewData,EXTR_OVERWRITE);
        $router = Router::getInstance() ;

        if (isset($template))
        {
            $templatePath ="www/views";
            $templatePath .="/".$template["folder"];
            $templatePath .="/".$template["file"];
            $templatePath .="View.phtml";
            // exemple de résultat pour $templatePath "www/views/home/mainView.phtml"

            include "www/views/layout.phtml";
        }
        elseif(isset($redirect))
        {
            header("Location:".$router->generateUrl($redirect)) ;
            die() ;
        }
        elseif(isset($jsonResponse))
        {
            echo json_encode($jsonResponse);
            die();
        }
        else
        {
            throw new ErrorException("Format de réponse non reconnue");
        }
    }
}