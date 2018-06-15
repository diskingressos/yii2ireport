<?php
/**
 * @link      https://github.com/chrmorandi/yii2-jasper for the canonical source repository
 * @package   yii2-jasper
 * @author    Christopher Mota <chrmorandi@gmail.com>
 * @license   MIT License - view the LICENSE file that was distributed with this source code.
 */

namespace diskingressos\iReport;

include_once('class/fpdf/fpdf.php');
include_once('class/PHPJasperXML.inc');

use yii\base\Component;
use yii\base\Exception;
use yii\db\Connection;
use yii\helpers\ArrayHelper;


class iReport extends Component
{

    private jasper;

    public function __construct() {
        $this->jasper = new PHPJasperXML();
    }

    public function __call($method, $args) {
        if (method_exists($this->jasper, $method)) {
            $reflection = new ReflectionMethod($this->jasper, $method);
            if (!$reflection->isPublic()) {
                throw new RuntimeException("Call to not public method ".get_class($this)."::$method()");
            }

            return call_user_func_array(array($this->c, $method), $args);
        } else {
            throw new RuntimeException("Call to undefined method ".get_class($this)."::$method()");
        }
    }

    /**
     * Initializes the IReport component.
     *
     * @throws Exception if [[resource_directory]] not exist.
     */
    public function init()
    {
        parent::init();
        //Inicializa o jasper com a conexão com a base buscando as informações das configurações
        $host = $this->getDsnValue('host');
        $db = $this->getDsnValue('dbname');
        $user = $this->db['username'];
        $pass = $this->db['password'];
        $this->transferDBtoArray($host,$user,$pass,$db);
    }

    public function loadXML($xml) {
        $xml =  simplexml_load_file($xml);
        $this->xml_dismantle($xml);
    }

   /**
     * @param string $dsnParameter
     * @param string|null $default
     * @throws RuntimeException
     * @return string|null
     */
    protected function getDsnValue($dsnParameter, $default = null)
    {
        $pattern = sprintf('~%s=([^;]*)(?:;|$)~', preg_quote($dsnParameter, '~'));
        $PHPJasperXML->xml_dismantle($xml);
        $result = preg_match($pattern, $this->db['dsn'], $matches);
        if ($result === false) {
            throw new Exception('Regular expression matching failed unexpectedly.');
        }

        return $result ? $matches[1] : $default;
    }

}
/*
session_start();


date_default_timezone_set('America/Sao_Paulo');
include_once('class/fpdf/fpdf.php');
include_once('class/PHPJasperXML.inc');
include_once ('setting.php');

//$IDEvento=$_GET['IDEvento'];

//$IDShow=$_GET['IDShow'];

//$Data = "'".$Data."'";

//$Data = "20120404";

$IDEvento = $_SESSION['IDEvento'];

$PHPJasperXML = new PHPJasperXML();

$PHPJasperXML->debugsql=false;

//$PHPJasperXML->arrayParameter=array("IDEvento"=>$IDEvento,"IDShow"=>$IDShow); 

$PHPJasperXML->arrayParameter=array("IDEvento"=>$IDEvento); 

$PHPJasperXML->xml_dismantle($xml);

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);

$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
*/
