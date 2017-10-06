<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZeLoad
{
    private $_context = array();
    private $_loadedModel = array();
    private $_ctrl = null;
    public $ctrl = null;
    private $_modelLoaded = array();
    private $_libraryLoaded = array();
    private $_helperLoaded = array();

    public function setCtrl($ctrl)
    {
        $this->_ctrl = &$ctrl;
        $this->ctrl = $this->_ctrl;
    }


    public function setContext($context)
    {
        $this->_context = $context;
    }


    private function getFileFromFolderNotCaseSensitive($folderURI, $fileName)
    {
        $fileName = trim(strtolower($fileName));
        if ($folder = @opendir($folderURI)) {
            while (false !== ($folderItem = readdir($folder))) {
                if ($folderItem != '.' && $folderItem != '..') {
                    if (strtolower($folderItem) == $fileName) {
                        return $folderItem;
                    }
                }
            }
        }
        return false;
    }


    public function view($viewTemplate, $arrData = array(), $outputView = false)
    {
        // search view in modulePath
        if (isset($this->_context["modulePath"]) && $this->_context["modulePath"] != '') {
            $cheminFichier = false;

            if (is_file($this->_context["modulePath"] . '/views/' . $viewTemplate . ".php")) {
                $cheminFichier = $this->_context["modulePath"] . '/views/' . $viewTemplate . ".php";
            } else {
                $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                    $this->_context["modulePath"] . '/views/',
                    $viewTemplate . '.php'
                );
                if ($cheminFichier) {
                    $cheminFichier = $this->_context["modulePath"] . '/views/' . $cheminFichier;
                }
            }

            if ($cheminFichier) {
                $view = new ZeView();
                return $view->getView($cheminFichier, $arrData, $outputView);
            }
        }

        // search view in globalPath
        $cheminFichier = false;
        if (is_file(BASEPATH . 'views/' . $viewTemplate . ".php")) {
            $cheminFichier = BASEPATH . 'views/' . $viewTemplate . ".php";
        } else {
            $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                BASEPATH . 'views/',
                $viewTemplate . '.php'
            );
            if ($cheminFichier) {
                $cheminFichier = BASEPATH . 'views/' . $cheminFichier;
            }
        }

        if ($cheminFichier) {
            $view = new ZeView();
            return $view->getView($cheminFichier, $arrData, $outputView);
        }
    }


    public function model($className, $shortName = '', $externalModule = null)
    {
        if (trim($shortName) == "") {
            $shortName = $className;
        }

        // TODO : gestion des erreurs de chargement de module (chemin inconnu et class non définie)


        if(class_exists($className)){
            $className::$_load = $this;
            $this->_ctrl->$shortName = new $className();
            return;
        }
        elseif (!isset($this->_ctrl->$shortName)) {
            if ($externalModule) {
                // search model in modulePath
                $externalModule = MODULEPATH . $externalModule;

                $cheminFichier = false;

                if (is_file($externalModule . '/models/' . $className . '.php')) {
                    $cheminFichier = $externalModule . '/models/' . $className . '.php';
                } else {
                    $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                        $externalModule . '/models/',
                        $className . '.php'
                    );
                    if ($cheminFichier) {
                        $cheminFichier = $externalModule . '/models/' . $cheminFichier;
                    }
                }

                if ($cheminFichier) {
                    if (!in_array($cheminFichier, $this->_modelLoaded)) {
                        $this->_modelLoaded[] = $cheminFichier;
                        include_once $cheminFichier;
                    }
                    $className::$_load = $this;
                    $this->_ctrl->$shortName = new $className();
                    return;
                }
            } else {
                // search model in modulePath
                if (isset($this->_context["modulePath"]) && $this->_context["modulePath"] != '') {
                    $cheminFichier = false;

                    if (is_file($this->_context["modulePath"] . '/models/' . $className . '.php')) {
                        $cheminFichier = $this->_context["modulePath"] . '/models/' . $className . '.php';
                    } else {
                        $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                            $this->_context["modulePath"] . '/models/',
                            $className . '.php'
                        );
                        if ($cheminFichier) {
                            $cheminFichier = $this->_context["modulePath"] . '/models/' . $cheminFichier;
                        }
                    }


                    if ($cheminFichier) {
                        if (!in_array($cheminFichier, $this->_modelLoaded)) {
                            $this->_modelLoaded[] = $cheminFichier;
                            include_once $cheminFichier;
                        }
                        $className::$_load = $this;
                        $this->_ctrl->$shortName = new $className();
                        return;
                    }
                }


                // search view in globalPath
                $cheminFichier = false;
                if (is_file(BASEPATH . 'models/' . $className . '.php')) {
                    $cheminFichier = BASEPATH . 'models/' . $className . '.php';
                } else {
                    $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                        BASEPATH . 'models/',
                        $className . '.php'
                    );
                    if ($cheminFichier) {
                        $cheminFichier = BASEPATH . 'models/' . $cheminFichier;
                    }
                }

                if ($cheminFichier) {
                    if (!in_array($cheminFichier, $this->_modelLoaded)) {
                        $this->_modelLoaded[] = $cheminFichier;
                        include_once $cheminFichier;
                    }
                    $className::$_load = $this;
                    $this->_ctrl->$shortName = new $className();
                    return;
                }
            }
        }
    }


    public function library($className, $shortName = '', $externalModule = null)
    {
        if (trim($shortName) == "") {
            $shortName = $className;
        }

        // TODO : gestion des erreurs de chargement de librairies (chemin inconnu et class non définie)


        if (!isset($this->_ctrl->$shortName)) {
            if ($externalModule) {
                // search library in modulePath
                $externalModule = MODULEPATH . $externalModule;

                $cheminFichier = false;
                if (is_file($externalModule . '/libraries/' . $className . '.php')) {
                    $cheminFichier = $externalModule . '/libraries/' . $className . '.php';
                } else {
                    $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                        $externalModule . '/libraries/',
                        $className . '.php'
                    );
                    if ($cheminFichier) {
                        $cheminFichier = $externalModule . '/libraries/' . $cheminFichier;
                    }
                }

                if ($cheminFichier) {
                    if (!in_array($cheminFichier, $this->_libraryLoaded)) {
                        $this->_libraryLoaded[] = $cheminFichier;
                        include_once $cheminFichier;
                    }
                    $this->_ctrl->$shortName = new $className();
                    return;
                }
            } else {
                // search model in modulePath
                if (isset($this->_context["modulePath"]) && $this->_context["modulePath"] != '') {
                    $cheminFichier = false;
                    if (is_file($this->_context["modulePath"] . '/libraries/' . $className . '.php')) {
                        $cheminFichier = $this->_context["modulePath"] . '/libraries/' . $className . '.php';
                    } else {
                        $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                            $this->_context["modulePath"] . '/libraries/',
                            $className . '.php'
                        );
                        if ($cheminFichier) {
                            $cheminFichier = $this->_context["modulePath"] . '/libraries/' . $cheminFichier;
                        }
                    }

                    if ($cheminFichier) {
                        if (!in_array($cheminFichier, $this->_libraryLoaded)) {
                            $this->_libraryLoaded[] = $cheminFichier;
                            include_once $cheminFichier;
                        }
                        $this->_ctrl->$shortName = new $className();
                        return;
                    }
                }


                // search in globalPath
                $cheminFichier = false;
                if (is_file(BASEPATH . 'libraries/' . $className . '.php')) {
                    $cheminFichier = BASEPATH . 'libraries/' . $className . '.php';
                } else {
                    $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                        BASEPATH . 'libraries/',
                        $className . '.php'
                    );
                    if ($cheminFichier) {
                        $cheminFichier = BASEPATH . 'libraries/' . $cheminFichier;
                    }
                }

                if ($cheminFichier) {
                    if (!in_array($cheminFichier, $this->_libraryLoaded)) {
                        $this->_libraryLoaded[] = $cheminFichier;
                        include_once $cheminFichier;
                    }
                    $this->_ctrl->$shortName = new $className();
                    return;
                }

            }
        }
    }

    public function helper($className, $externalModule = null)
    {
        $shortName = $className;

        // TODO : gestion des erreurs de chargement de helper (chemin inconnu et class non définie)


        if ($externalModule) {
            // search helper in modulePath
            $externalModule = MODULEPATH . $externalModule;

            $cheminFichier = false;
            if (is_file($externalModule . '/helpers/' . $className . '.php')) {
                $cheminFichier = $externalModule . '/helpers/' . $className . '.php';
            } else {
                $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                    $externalModule . '/helpers/',
                    $className . '.php'
                );
                if ($cheminFichier) {
                    $cheminFichier = $externalModule . '/helpers/' . $cheminFichier;
                }
            }
            if ($cheminFichier) {
                if (!in_array($cheminFichier, $this->_helperLoaded)) {
                    $this->_helperLoaded[] = $cheminFichier;
                    include_once $cheminFichier;
                }
                return;
            }
        } else {
            // search model in modulePath
            if (isset($this->_context["modulePath"]) && $this->_context["modulePath"] != '') {
                $cheminFichier = false;
                if (is_file($this->_context["modulePath"] . '/helpers/' . $className . '.php')) {
                    $cheminFichier = $this->_context["modulePath"] . '/helpers/' . $className . '.php';
                } else {
                    $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                        $this->_context["modulePath"] . '/helpers/',
                        $className . '.php'
                    );
                    if ($cheminFichier) {
                        $cheminFichier = $this->_context["modulePath"] . '/helpers/' . $cheminFichier;
                    }
                }

                if ($cheminFichier) {
                    if (!in_array($cheminFichier, $this->_helperLoaded)) {
                        $this->_helperLoaded[] = $cheminFichier;
                        include_once $cheminFichier;
                    }
                    return;
                }
            }


            // search in globalPath
            $cheminFichier = false;
            if (is_file(BASEPATH . 'helpers/' . $className . '.php')) {
                $cheminFichier = BASEPATH . 'helpers/' . $className . '.php';
            } else {
                $cheminFichier = $this->getFileFromFolderNotCaseSensitive(
                    BASEPATH . 'helpers/',
                    $className . '.php'
                );
                if ($cheminFichier) {
                    $cheminFichier = BASEPATH . 'helpers/' . $cheminFichier;
                }
            }

            if ($cheminFichier) {
                if (!in_array($cheminFichier, $this->_helperLoaded)) {
                    $this->_helperLoaded[] = $cheminFichier;
                    include_once $cheminFichier;
                }
                return;
            }

        }
    }
}

