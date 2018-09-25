<?php

namespace App\Http\Controllers\Api\Internal\Programs\MasterScale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PriceType;
use App\Product;
use App\FileType;
use DB;

class BuildingsLoadController extends Controller
{
    
    /**
     * Этажность учреждения (1 - 30)
     * 
     * @var Integer
     */
    protected $floorCount;
    
    /**
     * Тип учреждения по таблице 6.11 СП31-110-2003 для определения К1 для расчета нагрузки питающих линий
     * 
     * 1 - Предприятия торговли и общественного питания, гостиницы
     * 2 - Общеобразовательные школы, специальные учебные заведения, профтехучилища
     * 3 - Детские ясли-сады
     * 4 - Ателье, комбинаты бытового обслуживания, химчистки с прачечными самообслуживания, парикмахерские
     * 5 - Организации и учреждения управления, финансирования и кредитования, проектные и конструкторские организации
     * 
     * @var Integer
     */
    protected $institutionType_6_11;
    
    /**
     * Тип учреждения по таблице 6.5 СП31-110-2003 для определения К_с.о для расчета Рр освещения
     * 
     * 1 - Гостиницы, спальные корпуса и административные помещения санаториев, домов отдыха, пансионатов, турбаз, оздоровительных лагерей
     * 2 - Предприятия общественного питания, детские ясли-сады, учебно-производственные мастерские профтехучилищ
     * 3 - Организации и учреждения управления, учреждения финансирования, кредитования и государственного страхования, общеобразовательные школы, специальные учебные заведения, учебные здания профтехучилищ, предприятия бытового обслуживания, торговли, парикмахерские
     * 4 - Проектные, конструкторские организации, научно-исследовательские институты
     * 5 - Актовые залы, конференц-залы (освещение зала и президиума), спортзалы
     * 6 - Клубы и дома культуры
     * 7 - Кинотеатры
     * 
     * @var Integer
     */
    protected $institutionType_6_5;
    
    /** 
     * Массив с пользовательскими данными по потребителю нагрузки
     * 
     * @var Array[]
     * 
     * @var Integer Array[]['consumerTypeIndex'] - порядковый номер потребителя из постановки
     * @var Boolean Array[]['fireInvolved'] - участвует при пожаре (false - нет, true - да)
     * @var Boolean Array[]['kCEditing'] - указать коэффициент спроса вручную (false - нет, true - да)
     * @var Float Array[]['Np'] - количество потребителей данного типа
     * @var Float Array[]['Py'] - Py
     * @var Float Array[]['Qy'] - Qy
     * @var Float Array[]['Kc'] - коэффициент спроса Kc
     * @var Float Array[]['Pp'] - Pp
     * @var Float Array[]['Qp'] - Qp
     * @var Float Array[]['cosf'] - cosf
     * @var Float Array[]['tgf'] - tgf
     * @var Float Array[]['Sp'] - Sp
     * @var Float Array[]['Ip'] - Ip
     * 
     */
    protected $loadTypeData;

    /**
     * Конструктор
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->floorCount = $request->floor_count;
        $this->institutionType_6_11 = $request->institution_type_6_11;
        $this->institutionType_6_5 = $request->institution_type_6_5;
        $this->loadTypeData = $request->load_type_data;
    }

    public function calc()
    {
        foreach ($this->loadTypeData as $key => $consumer) {
            $Np = $consumer['Np'];  //Количество потребителей
            $Py = $consumer['Py'] <= 0 ? 0.01 : $consumer['Py'];    //Мощность потребителя 
            $Kc = 0;    //Коэффициент спроса            
            $cosf = $consumer['cosf'];  //cosf
        
            if(!$consumer['kCEditing']){
                switch($consumer['consumerTypeIndex']){
                    case 0:     //Вентиляц. обор. (двиг.>30кВт) 
                        $Py = $Py <= 30.0 ? 30.1 : $Py;
                        $Kc = $this->getKcByTab_6_9($Np, $Py, null);
                        break;
                    case 1:     //Вентиляц. обор.
                        $Py = $Py > 30.0 ? 30.0 : $Py;
                        $Kc = $this->getKcByTab_6_9($Np, null, null);
                        break;
                    case 2:     //Дымоудаление
                        $Kc = 1.0;
                        break;
                    case 3:     //Кондиционер
                        $Py = $Py > 30.0 ? 30.0 : $Py;
                        $weight = $this->getWeightForTab_6_9(3);
                        $Kc = $this->getKcByTab_6_9($Np, null, $weight);
                        break;
                    case 4:     //Кондиционер > 30кВт
                        $Py = $Py <= 30.0 ? 30.1 : $Py;
                        $Kc = $this->getKcByTab_6_9($Np, $Py, null);
                        break;
                    case 5:     //Лифт
                        $Kc = $this->getKcByTab_6_4($Np, $this->floorCount);
                        break;
                    case 6:     //Мед. кабинет
                        $Kc = $this->getKcByTab_6_7($Np, 15);
                        break;
                    case 7:     //Мед. обор. тепловое
                        $Kc = $this->getKcByTab_2_1($Np);
                        break;
                    case 8:     //Мед.обор.стационарное
                        $Kc = $this->getKcByTab_2_2($Np);
                        break;
                    case 9:     //Нагревательное сантех. обор.
                        $Kc = $this->getKcByTab_6_9($Np,null,null);
                        break;
                    case 10:    //Насосное обор. (двиг.>30кВт)
                        $Py = $Py > 30.0 ? 30.0 : $Py;
                        $Kc = $this->getKcByTab_6_9($Np, null, null);
                        break;
                    case 11:    //Насосное обор.
                        $Py = $Py <= 30.0 ? 30.1 : $Py;
                        $Kc = $this->getKcByTab_6_9($Np, $Py, null);
                        break;
                    case 12:    //Оборудование уборочное
                        $Kc = 0;
                        break;
                    case 13:    //ОЗДС
                        $Kc = 1.0;
                        break;
                    case 14:    //Освещение аварийное
                        $Kc = 1.0;
                        break;
                    case 15:    //Освещение
                        $Kc = $this->getKcByTab_6_5($Py * $Np, $this->institutionType_6_5);
                        break;
                    case 16:    //Пищеблок (двиг. обор.)
                        $Kc = $this->getKcByTab_6_8($Np);
                        break;
                    case 17:    //Пищеблок (теп. обор.)
                        $Kc = $this->getKcByTab_6_8($Np);
                        break;
                    case 18:    //Пожарный клапан
                        $Kc = 1.0;
                        break;
                    case 19:    //Пожарный насос
                        $Kc = 0.5;
                        break;
                    case 20:    //Посудомоеч. маш. (гор.вода)
                        $Kc = $this->getKcByTab_6_10_Hot($Np);
                        break;
                    case 21:    //Посудомоеч. маш. (хол.вода)
                        $Kc = $this->getKcByTab_6_10_Cold($Np);
                        break;
                    case 22:    //Прачечная (двиг. обор.)
                        $Kc = $this->getKcByTab_6_7($Np, 16);
                        break;
                    case 23:    //Прачечная (теп. обор.)
                        $Kc = $this->getKcByTab_6_7($Np, 16);
                        break;
                    case 24:    //Рентген
                        $Kc = 1.0;
                        break;
                    case 25:    //Розетки бытовые
                        if(in_array($this->institutionType_6_11,[1,4])) 
                             $Kc = 0.2;
                        else $Kc = 0.1;
                        break;
                    case 26:    //Розетки компьютерные
                        if($Np <= 8) $Kc = 0.9;
                        else if($Np >= 20) $Kc = 0.8;
                        else $Kc = $this->interpolation(8,0.9,$Np,20,0.8);
                        break;
                    case 27:    //Рукосушитель
                        $Kc = $this->getKcByTab_6_7($Np, 17);
                        break;
                    case 28:    //Слаботоч. сист.
                        $Kc = 0.1;
                        break;
                    case 29:    //Станок
                        $Kc = $this->getKcByTab_6_7($Np, 11);
                        break;
                    case 30:    //Станок (теп. обор.)
                        $Kc = $this->getKcByTab_6_7($Np, 11);
                        break;
                    case 31:    //Сценич. звук
                        $Kc = $this->getKcByTab_6_7($Np, 8);
                        break;
                    case 32:    //Сценич. мех.
                        $Kc = $this->getKcByTab_6_7($Np, 8);
                        break;
                    case 33:    //Сценич. свет
                        $Kc = $this->getKcByTab_6_7($Np, 8);
                        break;
                    case 34:    //Учеб. мастерская
                        $Kc = $this->getKcByTab_6_7($Np, 14);
                        break;
                    case 35:    //Учеб.мастерская (теп. обор.)
                        $Kc = $this->getKcByTab_6_7($Np, 14);
                        break;
                    case 36:    //Учебное обор.
                        $Kc = $this->getKcByTab_6_7($Np, 13);
                        break;
                    case 37:    //Учебное обор.(теп. обор.)
                        $Kc = $this->getKcByTab_6_7($Np, 13);
                        break;
                    case 38:    //Флюорограф
                        $Kc = 0.1;
                        break;
                    case 39:    //Холодильное обор.
                        $Py = $Py > 30.0 ? 30.0 : $Py;
                        $weight = $this->getWeightForTab_6_9(39);
                        $Kc = $this->getKcByTab_6_9($Np, null, $weight);
                        break;
                    case 40:    //Холодильное обор.>30кВт
                        $Py = $Py <= 30.0 ? 30.1 : $Py;
                        $Kc = $this->getKcByTab_6_9($Np, $Py, null);
                        break;
                    case 41:    //Квартира (прир. газ)
                        $Pp = $this->getKcByTab_6_1($Np, 1);
						$Kc = $Pp / $Py;
                        break;
                    case 42:    //Квартира (сжиж. газ)
                        $Pp = $this->getKcByTab_6_1($Np, 2);
						$Kc = $Pp / $Py;
                        break;
                    case 43:    //Квартира (эл. плита)
                        $Pp = $this->getKcByTab_6_1($Np, 3);
						$Kc = $Pp / $Py;
                        break;
                    case 44:    //Дачный домик
                        $Pp = $this->getKcByTab_6_1($Np, 4);
						$Kc = $Pp / $Py;
                        break;
                    case 45:    //ИТП
                        $Kc = 0.1;
                        break;
                    default: 
                        break;
                }
            } else {
                $Kc = $consumer['Kc'];
            }

            $tgf = tan(acos($cosf));
            $Qy = $Py * $tgf;
            $Pp = $Py * $Kc;
            $Qp = $Qy * $Kc;
            $Sp = sqrt($Py*$Py + $Qy*$Qy) * $Kc;
            $Ip = $Sp / sqrt(3.0)*0.38;
            
            $consumer['Np'] = round($Np,2);
            $consumer['Py'] = round($Py,2);
            $consumer['cosf'] = round($cosf,2);
            $consumer['Kc'] = round($Kc,2);
            $consumer['tgf'] = round($tgf,2);
            $consumer['Qy'] = round($Qy,2);
            $consumer['Pp'] = round($Pp,2);
            $consumer['Qp'] = round($Qp,2);
            $consumer['Sp'] = round($Sp,2);
            $consumer['Ip'] = round($Ip,2);

            $this->loadTypeData[$key] = $consumer;
        }
        
        $PpOsvSil = null;			$PpOsvHol = null;			$PpOsv = null;
        $PpHol = null;				$Pp = null;					$K = null;
        $K1 = null;					$KCrash = null;			    $KFire = null;
        $PyCrash = null;			$PyFire = null;			    $QyCrash = null;
        $QyFire = null;			    $PpCrash = null;			$PpFire = null;
        $PpSmokeFireEquip = null;   $PpFireInvolv = null;		$Qp = null;
        $QpHol = null;				$QpSmokeFireEquip = null;   $QpFireInvolv = null;
        $tgfCrash = null;			$tgfFire = null;			$cosfCrash = null;
        $cosfFire = null;			$SpCrash = null;			$SpFire = null;
        $IpCrash = null;			$IpFire = null;			/**/
        
        foreach ($this->loadTypeData as $consumer) {
            switch($consumer['consumerTypeIndex']){
                case 14 or 15:
                    $PpOsv += $consumer['Pp'];
                case 3 or 4:
                    $PpHol += $consumer['Pp'];
                    $QpHol += $consumer['Qp'];
                case 2 or 18 or 19:
                    $PpSmokeFireEquip += $consumer['Pp'];
                    $QpSmokeFireEquip += $consumer['Qp'];
            }
            if($consumer['fireInvolved']){
                $PpFireInvolv += $consumer['Pp'];
                $QpFireInvolv += $consumer['Qp'];
            }
            $Pp += $consumer['Pp'];
            $Qp += $consumer['Qp'];
            $PyCrash += $consumer['Py'];
            $QyCrash += $consumer['Qy'];
        }
        
        $PpOsvSil = ($Pp - $PpOsv) == 0 ? 0: ($PpOsv / ($Pp - $PpOsv)) * 100.0;
        $PpOsvHol = ($PpHol == 0) ? 0: ($PpOsv / $PpHol) * 100.0;
        $K = $this->getKcByTab_6_11_K($PpOsvSil, $PpHol, $this->institutionType_6_11);
        $K1 = $this->getKcByTab_6_11_K1($PpOsvHol);
        $PyFire = $PyCrash;
        $QyFire = $QyCrash;
        $PpCrash = $K * $Pp - $PpSmokeFireEquip + $K1 * $PpHol;
        $PpFire = $K * $PpFireInvolv;
        $KCrash = ($PyCrash == 0) ? 0 : $PpCrash / $PyCrash;
        $KFire = ($PyFire == 0) ? 0 : $PpFire / $PyFire;
        $QpCrash = $K * $Qp - $QpSmokeFireEquip + $K1 * $QpHol;
        $QpFire = $K * $QpFireInvolv;
        $tgfCrash = ($PpCrash == 0) ? 0 : $QpCrash / $PpCrash;
        $tgfFire = ($PpFire == 0) ? 0 : $QpFire / $PpFire;
        $cosfCrash = cos(atan($tgfCrash));
        $cosfFire = cos(atan($tgfFire));
        $SpCrash = sqrt($PpCrash * $PpCrash + $QpCrash * $QpCrash);
        $SpFire = sqrt($PpFire * $PpFire + $QpFire * $QpFire);
        $IpCrash = $SpCrash / (sqrt(3) * 0.38);
        $IpFire = $SpFire / (sqrt(3) * 0.38);
        return response()->json([
                'params' => 
                    ['loadTypeData' => $this->loadTypeData],
                'ppOsvSil' => round($PpOsvSil,2),
                'ppOsvHol' => round($PpOsvHol,2),
                'k' => round($K,2),
                'k1' => round($K1,2),
                'pyCrash' => round($PyCrash,2),
                'qyCrash' => round($QyCrash,2),
                'kCrash' => round($KCrash,2),
                'ppCrash' => round($PpCrash,2),
                'qpCrash' => round($QpCrash,2),
                'cosfCrash' => round($cosfCrash,2),
                'tgfCrash' => round($tgfCrash,2),
                'spCrash' => round($SpCrash,2),
                'ipCrash' => round($IpCrash,2),
                'pyFire' => round($PyFire,2),
                'qyFire' => round($QyFire,2),
                'kFire' => round($KFire,2),
                'ppFire' => round($PpFire,2),
                'qpFire' => round($QpFire,2),
                'cosfFire' => round($cosfFire,2),
                'tgfFire' => round($tgfFire,2),
                'spFire' => round($SpFire,2),
                'ipFire' => round($IpFire,2)
            ]             
        );
    }

    /**
     * Интерполяция
     *
     * @param Float $aMin- минимальное значение множества a
     * @param Float $bMin - минимальное значение множества b
     * @param Float $aMax - максимальное значение множества a
     * @param Float $bMax - максимальное значение множества b
     * @param Float $a - известное значение из множества a
     * @return Float $b - соответствующее a значение из множества b
     * 
     */
    protected function interpolation(   $aMin = null,
                                        $bMin = null,
                                        $a    = null,
                                        $aMax = null,
                                        $bMax = null ){
        if( $aMin === null ||
            $bMin === null || 
            $a    === null || 
            $aMax === null || 
            $bMax === null )
            return null;
        else
            return $bMin-(($bMin-$bMax)/($aMax-$aMin))*($a-$aMin);
    }

    /**
     * Возвращает коффициент спроса по таблице 6.9
     *
     * @param Integer $Np - количество потребителей
     * @param Float $Py - мощность потребителя
     * @param Float $weight - вес
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_6_9($Np = null, $Py = null, $weight = null){
        if($Np === null) return null;
        if($Py === null && $weight === null){            
            if($Np >= 0 && $Np <= 2)
                return 1;
            if($Np > 2 && $Np <= 3)
                return $this->interpolation(2,1,$Np,3,0.9);
            if($Np > 3 && $Np <= 5)
                return $this->interpolation(3,0.9,$Np,5,0.8);
            if($Np > 5 && $Np <= 8)
                return $this->interpolation(5,0.8,$Np,8,0.75);
            if($Np > 8 && $Np <= 10)
                return $this->interpolation(8,0.75,$Np,10,0.7);
            if($Np > 10 && $Np <= 15)
                return $this->interpolation(10,0.7,$Np,15,0.65);
            if($Np > 15 && $Np <= 20)
                return $this->interpolation(15,0.65,$Np,20,0.65);
            if($Np > 20 && $Np <= 30)
                return $this->interpolation(20,0.65,$Np,30,0.6);
            if($Np > 30 && $Np <= 50)
                return $this->interpolation(30,0.6,$Np,50,0.55);
            if($Np > 50 && $Np <= 100)
                return $this->interpolation(50,0.55,$Np,100,0.55);
            if($Np > 100 && $Np <= 200)
                return $this->interpolation(100,0.55,$Np,200,0.5);
            if($Np > 200)
                return 0.5;
        }else if($Py !== null && $weight === null){
            if($Np >= 0 && $Np <= 2)
                return 0.8;
            if($Np > 2 && $Np <= 3)
                return $this->interpolation(2,0.8,$Np,3,0.75);
            if($Np > 3 && $Np <= 5)
                return $this->interpolation(3,0.75,$Np,5,0.7);
            if($Np > 5 && $Np <= 8)
                return $this->interpolation(5,0.7,$Np,8,0.7);
            if($Np > 8 && $Np <= 10)
                return $this->interpolation(8,0.7,$Np,10,0.7);
            if($Np > 10 && $Np <= 15)
                return $this->interpolation(10,0.7,$Np,15,0.7);
            if($Np > 15 && $Np <= 20)
                return $this->interpolation(15,0.7,$Np,20,0.7);
            if($Np > 20 && $Np <= 30)
                return $this->interpolation(20,0.7,$Np,30,0.7);
            if($Np > 30 && $Np <= 50)
                return $this->interpolation(30,0.7,$Np,50,0.7);
            if($Np > 50 && $Np <= 100)
                return $this->interpolation(50,0.7,$Np,100,0.7);
            if($Np > 100 && $Np <= 200)
                return $this->interpolation(100,0.7,$Np,200,0.7);
            if($Np > 200)
                return 0.7;
        }else if($Py === null && $weight !== null){
            if($Np >= 0 && $Np <= 2){
                if($weight >= 100.0)
                    return 1.0;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,1.0,$weight,84.0,0.75);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.75,$weight,74.0,0.7);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.7,$weight,49.0,0.65);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.65,$weight,24.0,0.6);
                if($weight < 24.0)
                    return 0.6;
            }
            if($Np > 2 && $Np <= 3){
                if($weight >= 100.0)
                    return 0.9;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.9,$weight,84.0,0.75);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.75,$weight,74.0,0.7);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.7,$weight,49.0,0.65);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.65,$weight,24.0,0.6);
                if($weight < 24.0)
                    return 0.6;
            }
            if($Np > 3 && $Np <= 5){
                if($weight >= 100.0)
                    return 0.8;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.8,$weight,84.0,0.75);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.75,$weight,74.0,0.7);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.7,$weight,49.0,0.65);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.65,$weight,24.0,0.6);
                if($weight < 24.0)
                    return 0.6;
            }
            if($Np > 5 && $Np <= 8){
                if($weight >= 100.0)
                    return 0.75;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.75,$weight,84.0,0.7);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.7,$weight,74.0,0.65);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.65,$weight,49.0,0.6);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.6,$weight,24.0,0.6);
                if($weight < 24.0)
                    return 0.6;
            }
            if($Np > 8 && $Np <= 10){
                if($weight >= 100.0)
                    return 0.7;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.7,$weight,84.0,0.65);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.65,$weight,74.0,0.65);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.65,$weight,49.0,0.6);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.6,$weight,24.0,0.55);
                if($weight < 24.0)
                    return 0.55;
            }
            if(Np > 10 && Np <= 15){
                if($weight >= 100.0)
                    return 0.65;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.65,$weight,84.0,0.6);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.6,$weight,74.0,0.6);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.6,$weight,49.0,0.55);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.55,$weight,24.0,0.5);
                if($weight < 24.0)
                    return 0.5;
            }
            if($Np > 15 && $Np <= 20){
                if($weight >= 100.0)
                    return 0.65;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.65,$weight,84.0,0.6);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.6,$weight,74.0,0.6);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.6,$weight,49.0,0.5);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.5,$weight,24.0,0.5);
                if($weight < 24.0)
                    return 0.5;
            }
            if($Np > 20 && $Np <= 30){
                if($weight >= 100.0)
                    return 0.6;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.6,$weight,84.0,0.6);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.6,$weight,74.0,0.55);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.55,$weight,49.0,0.5);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.5,$weight,24.0,0.5);
                if($weight < 24.0)
                    return 0.5;
            }
            if($Np > 30 && $Np <= 50){
                if($weight >= 100.0)
                    return 0.55;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.55,$weight,84.0,0.55);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.55,$weight,74.0,0.5);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.5,$weight,49.0,0.5);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.5,$weight,24.0,0.5);
                if($weight < 24.0)
                    return 0.5;
            }
            if($Np > 50 && $Np <= 100){
                if($weight >= 100.0)
                    return 0.55;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.55,$weight,84.0,0.55);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.55,$weight,74.0,0.5);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.5,$weight,49.0,0.45);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.45,$weight,24.0,0.45);
                if($weight < 24.0)
                    return 0.45;
            }
            if($Np > 100 && $Np <= 200){
                if($weight >= 100.0)
                    return 0.5;
                if($weight < 100.0 && $weight >= 84.0)
                    return $this->interpolation(100.0,0.5,$weight,84.0,0.5);
                if($weight < 84.0 && $weight >= 74.0)
                    return $this->interpolation(84.0,0.5,$weight,74.0,0.45);
                if($weight < 74.0 && $weight >= 49.0)
                    return $this->interpolation(74.0,0.45,$weight,49.0,0.45);
                if($weight < 49.0 && $weight >= 24.0)
                    return $this->interpolation(49.0,0.45,$weight,24.0,0.4);
                if($weight < 24.0)
                    return 0.4;
            }
            if($Np > 200){
                if($weight >= 100.0)
                    return 0.5;
                if($weight < 100.0 && $weight >= 84.0)
                    return 0.5;
                if($weight < 84.0 && $weight >= 74.0)
                    return 0.45;
                if($weight < 74.0 && $weight >= 49.0)
                    return 0.45;
                if($weight < 49.0 && $weight >= 24.0)
                    return 0.4;
                if($weight < 24.0)
                    return 0.4;
            }																		
        } /* else if($Py !== null && $weight !== null){ } */
        return null;
    }

    /**
     * Возвращает вес для расчета коффициента спроса по таблице 6.9
     *
     * @param Integer $consumerTypeIndex - порядковый номер потребителя из постановки
     * @return Float $weight - вес
     * 
     */
    function getWeightForTab_6_9($consumerTypeIndex = null){
        if($consumerTypeIndex === null) return null;
        $PySumm = null;
        $Py = null;
        foreach ($this->loadTypeData as $consumer) {
            $currConsNum = $consumer['consumerTypeIndex'];
            if(in_array($currConsNum,[14,15,41,42,43,44,45]))
                $PySumm += $consumer['Py'];
            if($consumerTypeIndex == $currConsNum)
                $Py = $consumer['Py'];
        }
        if(($PySumm - $Py) == 0) return null;
        return 100.0 * $Py / ($PySumm - $Py);

    }

    /**
     * Возвращает коффициент спроса по таблице 6.4
     *
     * @param Integer $Np - количество потребителей
     * @param Float $floorCount - этажность учреждения
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_6_4($Np = null, $floorCount = null){
        if($Np === null || $floorCount === null)
            return null;
        if($floorCount <= 12) {
            if($Np >= 0 && $Np <= 2) return 0.8;
            if($Np > 2 && $Np <= 3) return $this->interpolation(2,0.8,$Np,3,0.8);
            if($Np > 3 && $Np <= 4) return $this->interpolation(3,0.8,$Np,4,0.7);
            if($Np > 4 && $Np <= 5) return $this->interpolation(5,0.7,$Np,8,0.7);
            if($Np > 5 && $Np <= 6) return $this->interpolation(8,0.7,$Np,10,0.65);
            if($Np > 6 && $Np <= 10) return $this->interpolation(10,0.65,$Np,15,0.5);
            if($Np > 10 && $Np <= 20) return $this->interpolation(10,0.5,$Np,20,0.4);
            if($Np > 20 && $Np <= 25) return $this->interpolation(20,0.4,$Np,30,0.35);
            if($Np > 25) return 0.35;
        } else if($floorCount > 12) {
            if($Np >= 0 && $Np <= 2) return 0.9;
            if($Np > 2 && $Np <= 3) return $this->interpolation(2,0.9,$Np,3,0.9);
            if($Np > 3 && $Np <= 4) return $this->interpolation(3,0.9,$Np,4,0.8);
            if($Np > 4 && $Np <= 5) return $this->interpolation(5,0.8,$Np,8,0.8);
            if($Np > 5 && $Np <= 6) return $this->interpolation(8,0.8,$Np,10,0.75);
            if($Np > 6 && $Np <= 10) return $this->interpolation(10,0.75,$Np,15,0.6);
            if($Np > 10 && $Np <= 20) return $this->interpolation(10,0.6,$Np,20,0.5);
            if($Np > 20 && $Np <= 25) return $this->interpolation(20,0.5,$Np,30,0.4);
            if($Np > 25) return 0.4;
        }
    }


    /**
     * Возвращает коффициент спроса по таблице 6.7
     *
     * @param Integer $Np - количество потребителей
     * @param Integer $rowNum - номер строки в таблице
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_6_7($Np = null, $rowNum = null){
        if($Np === null || $rowNum === null)
            return null;
        if(!in_array($rowNum,[8,9,11,12,13,14,15,16,17]))
            return null;        
        if($Np >= 0 && $Np <= 3)
            switch($rowNum){
                case 8: return 0.5;
                case 11: return 0.5;
                case 13: return 0.4;
                case 14: return 0.5;
                case 15: return 0.6;
                case 16: return 0.7;
                case 17: return 0.4;
                default: return null;
            }
        if($Np > 3 && $Np <= 5)
            switch($rowNum){
                case 8:  return $this->interpolation(3,0.5,$Np,5,0.2);
                case 11: return $this->interpolation(3,0.5,$Np,5,0.2);
                case 13: return $this->interpolation(3,0.4,$Np,5,0.15);
                case 14: return $this->interpolation(3,0.5,$Np,5,0.2);
                case 15: return $this->interpolation(3,0.6,$Np,5,0.3);
                case 16: return $this->interpolation(3,0.7,$Np,5,0.5);
                case 17: return $this->interpolation(3,0.4,$Np,5,0.15);
                default: return null;
            }
        if($Np > 5)
            switch($rowNum){
                case 8: return 0.2;
                case 11: return 0.2;
                case 13: return 0.15;
                case 14: return 0.2;
                case 15: return 0.3;
                case 16: return 0.5;
                case 17: return 0.15;
                default: return null;
            }
        return null;
    }


    /**
     * Возвращает коффициент спроса по таблице 2.1
     *
     * @param Integer $Np - количество потребителей
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_2_1($Np = null){
        if($Np === null)
            return null;
        if($Np >= 0 && $Np <= 3) return 0.95;
        if($Np > 3 && $Np <= 5) return $this->interpolation(3,0.95,$Np,5,0.9);
        if($Np > 5 && $Np <= 8) return $this->interpolation(5,0.9,$Np,8,0.8);
        if($Np > 8 && $Np <= 10) return $this->interpolation(8,0.8,$Np,10,0.7);
        if($Np > 10 && $Np <= 20) return $this->interpolation(10,0.7,$Np,20,0.65);
        if($Np > 20 && $Np <= 30) return $this->interpolation(20,0.65,$Np,30,0.6);
        if($Np > 30 && $Np <= 40) return $this->interpolation(30,0.6,$Np,40,0.55);
        if($Np > 40) return 0.55;
    }


    /**
     * Возвращает коффициент спроса по таблице 2.2
     *
     * @param Integer $Np - количество потребителей
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_2_2($Np = null){
        if($Np === null)
            return null;
        if($Np >= 0 && $Np <= 3) return 0.6;
        if($Np > 3 && $Np <= 5) return $this->interpolation(3,0.6,$Np,5,0.5);
        if($Np > 5 && $Np <= 8) return $this->interpolation(5,0.5,$Np,8,0.45);
        if($Np > 8 && $Np <= 10) return $this->interpolation(8,0.45,$Np,10,0.4);
        if($Np > 10 && $Np <= 20) return $this->interpolation(10,0.4,$Np,20,0.35);
        if($Np > 20 && $Np <= 30) return $this->interpolation(20,0.35,$Np,30,0.3);
        if($Np > 30 && $Np <= 40) return $this->interpolation(30,0.3,$Np,40,0.25);
        if($Np > 40) return 0.25;
    }


    /**
     * Возвращает коффициент спроса по таблице 6.5
     *
     * @param Integer $Py - мощность потребителя (сумма по количеству)
     * @param Integer $rowNum - номер строки в таблице
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_6_5($Py = null, $rowNum = null){
        if($Py === null || $rowNum === null)
            return null;
        if($rowNum == 1){
            if($Py >= 0 && $Py <= 5)
                return 1;
            if($Py > 5 && $Py <= 10)
                return $this->interpolation(5,1,$Py,10,0.8);
            if($Py > 10 && $Py <= 15)
                return $this->interpolation(10,0.8,$Py,15,0.7);
            if($Py > 15 && $Py <= 25)
                return $this->interpolation(15,0.7,$Py,25,0.6);
            if($Py > 25 && $Py <= 50)
                return $this->interpolation(25,0.6,$Py,50,0.5);
            if($Py > 50 && $Py <= 100)
                return $this->interpolation(50,0.5,$Py,100,0.4);
            if($Py > 100 && $Py <= 200)
                return $this->interpolation(100,0.4,$Py,200,0.35);
            if($Py > 200 && $Py <= 400)
                return $this->interpolation(200,0.35,$Py,400,0.3);
            if($Py > 400 && $Py <= 500)
                return $this->interpolation(400,0.3,$Py,500,0.3);
            if($Py > 500)
                return 0.3;
        }
        if($rowNum == 2){
            if($Py >= 0 && $Py <= 5)
                return 1;
            if($Py > 5 && $Py <= 10)
                return $this->interpolation(5,1,$Py,10,0.9);
            if($Py > 10 && $Py <= 15)
                return $this->interpolation(10,0.9,$Py,15,0.85);
            if($Py > 15 && $Py <= 25)
                return $this->interpolation(15,0.85,$Py,25,0.8);
            if($Py > 25 && $Py <= 50)
                return $this->interpolation(25,0.8,$Py,50,0.75);
            if($Py > 50 && $Py <= 100)
                return $this->interpolation(50,0.75,$Py,100,0.7);
            if($Py > 100 && $Py <= 200)
                return $this->interpolation(100,0.7,$Py,200,0.65);
            if($Py > 200 && $Py <= 400)
                return $this->interpolation(200,0.65,$Py,400,0.6);
            if($Py > 400 && $Py <= 500)
                return $this->interpolation(400,0.6,$Py,500,0.5);
            if($Py > 500)
                return 0.5;
        }
        if($rowNum == 3){
            if($Py >= 0 && $Py <= 5)
                return 1;
            if($Py > 5 && $Py <= 10)
                return $this->interpolation(5,1,$Py,10,0.95);
            if($Py > 10 && $Py <= 15)
                return $this->interpolation(10,0.95,$Py,15,0.9);
            if($Py > 15 && $Py <= 25)
                return $this->interpolation(15,0.9,$Py,25,0.85);
            if($Py > 25 && $Py <= 50)
                return $this->interpolation(25,0.85,$Py,50,0.8);
            if($Py > 50 && $Py <= 100)
                return $this->interpolation(50,0.8,$Py,100,0.75);
            if($Py > 100 && $Py <= 200)
                return $this->interpolation(100,0.75,$Py,200,0.7);
            if($Py > 200 && $Py <= 400)
                return $this->interpolation(200,0.7,$Py,400,0.65);
            if($Py > 400 && $Py <= 500)
                return $this->interpolation(400,0.65,$Py,500,0.6);
            if($Py > 500)
                return 0.6;
        }
        if($rowNum == 4){
            if($Py >= 0 && $Py <= 5)
                return 1;
            if($Py > 5 && $Py <= 10)
                return $this->interpolation(5,1,$Py,10,1);
            if($Py > 10 && $Py <= 15)
                return $this->interpolation(10,1,$Py,15,0.95);
            if($Py > 15 && $Py <= 25)
                return $this->interpolation(15,0.95,$Py,25,0.9);
            if($Py > 25 && $Py <= 50)
                return $this->interpolation(25,0.9,$Py,50,0.85);
            if($Py > 50 && $Py <= 100)
                return $this->interpolation(50,0.85,$Py,100,0.8);
            if($Py > 100 && $Py <= 200)
                return $this->interpolation(100,0.8,$Py,200,0.75);
            if($Py > 200 && $Py <= 400)
                return $this->interpolation(200,0.75,$Py,400,0.7);
            if($Py > 400 && $Py <= 500)
                return $this->interpolation(400,0.7,$Py,500,0.65);
            if($Py > 500)
                return 0.65;
        }
        if($rowNum == 5){
            if($Py >= 0 && $Py <= 5)
                return 1;
            if($Py > 5 && $Py <= 10)
                return $this->interpolation(5,1,$Py,10,1);
            if($Py > 10 && $Py <= 15)
                return $this->interpolation(10,1,$Py,15,1);
            if($Py > 15 && $Py <= 25)
                return $this->interpolation(15,1,$Py,25,1);
            if($Py > 25 && $Py <= 50)
                return $this->interpolation(25,1,$Py,50,1);
            if($Py > 50 && $Py <= 100)
                return $this->interpolation(50,1,$Py,100,1);
            if($Py > 100 && $Py <= 200)
                return $this->interpolation(100,1,$Py,200,1);
            if($Py > 200 && $Py <= 400)
                return $this->interpolation(200,1,$Py,400,1);
            if($Py > 400 && $Py <= 500)
                return $this->interpolation(400,1,$Py,500,1);
            if($Py > 500)
                return 1;
        }
        if($rowNum == 6){
            if($Py >= 0 && $Py <= 5)
                return 1;
            if($Py > 5 && $Py <= 10)
                return $this->interpolation(5,1,$Py,10,0.9);
            if($Py > 10 && $Py <= 15)
                return $this->interpolation(10,0.9,$Py,15,0.8);
            if($Py > 15 && $Py <= 25)
                return $this->interpolation(15,0.8,$Py,25,0.75);
            if($Py > 25 && $Py <= 50)
                return $this->interpolation(25,0.75,$Py,50,0.7);
            if($Py > 50 && $Py <= 100)
                return $this->interpolation(50,0.7,$Py,100,0.65);
            if($Py > 100 && $Py <= 200)
                return $this->interpolation(100,0.65,$Py,200,0.55);
            if($Py > 200 && $Py <= 400)
                return $this->interpolation(200,0.55,$Py,400,0.6);
            if($Py > 400 && $Py <= 500)
                return $this->interpolation(400,0.6,$Py,500,0.6);
            if($Py > 500)
                return 0.6;
        }
        if($rowNum == 7){
            if($Py >= 0 && $Py <= 5)
                return 1;
            if($Py > 5 && $Py <= 10)
                return $this->interpolation(5,1,$Py,10,0.9);
            if($Py > 10 && $Py <= 15)
                return $this->interpolation(10,0.9,$Py,15,0.8);
            if($Py > 15 && $Py <= 25)
                return $this->interpolation(15,0.8,$Py,25,0.7);
            if($Py > 25 && $Py <= 50)
                return $this->interpolation(25,0.7,$Py,50,0.65);
            if($Py > 50 && $Py <= 100)
                return $this->interpolation(50,0.65,$Py,100,0.6);
            if($Py > 100 && $Py <= 200)
                return $this->interpolation(100,0.6,$Py,200,0.5);
            if($Py > 200 && $Py <= 400)
                return $this->interpolation(200,0.5,$Py,400,0.5);
            if($Py > 400 && $Py <= 500)
                return $this->interpolation(400,0.5,$Py,500,0.5);
            if($Py > 500)
                return 0.5;
        }
    }

    /**
     * Возвращает коффициент спроса по таблице 6.8
     *
     * @param Integer $Np - количество потребителей
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_6_8($Np = null){
        if($Np === null)
            return null;
        if($Np >= 0 && $Np <= 2)
            return 0.9;
        if($Np > 2 && $Np <= 3)
            return $this->interpolation(2,0.9,$Np,3,0.85);
        if($Np > 3 && $Np <= 5)
            return $this->interpolation(3,0.85,$Np,5,0.75);
        if($Np > 5 && $Np <= 8)
            return $this->interpolation(5,0.75,$Np,8,0.65);
        if($Np > 8 && $Np <= 10)
            return $this->interpolation(8,0.65,$Np,10,0.6);
        if($Np > 10 && $Np <= 15)
            return $this->interpolation(10,0.6,$Np,15,0.5);
        if($Np > 15 && $Np <= 20)
            return $this->interpolation(15,0.5,$Np,20,0.45);
        if($Np > 20 && $Np <= 30)
            return $this->interpolation(20,0.45,$Np,30,0.4);
        if($Np > 30 && $Np <= 60)
            return $this->interpolation(30,0.4,$Np,60,0.3);
        if($Np > 60 && $Np <= 100)
            return $this->interpolation(60,0.3,$Np,100,0.3);
        if($Np > 100 && $Np <= 120)
            return $this->interpolation(100,0.3,$Np,120,0.25);
        if($Np > 120)
            return 0.25;
    }
    
    /**
     * Возвращает коффициент спроса по таблице 6.10 для холодной воды
     *
     * @param Integer $Np - количество потребителей
     * @return Float $Kc - коэффициент спроса 
     * 
     */
    function getKcByTab_6_10_Cold($Np = null){
        if($Np === null)
            return null;
        if($Np >= 0 && $Np <= 1)
            return 1;
        if($Np > 1 && $Np <= 2)
            return $this->interpolation(1,1,$Np,2,0.9);
        if($Np > 2 && $Np <= 3)
            return $this->interpolation(2,0.9,$Np,3,0.85);
        if($Np > 3)
            return 0.85;
    }
    
    /**
     * Возвращает коффициент спроса по таблице 6.10 для холодной воды
     *
     * @param Integer $Np - количество потребителей
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_6_10_Hot($Np = null){
        if($Np === null)
            return null;
        if($Np >= 0 && $Np <= 1)
            return 0.65;
        if($Np > 1 && $Np <= 2)
            return $this->interpolation(1,0.65,$Np,2,0.6);
        if($Np > 2 && $Np <= 3)
            return $this->interpolation(2,0.6,$Np,3,0.55);
        if($Np > 3)
            return 0.55;


    }

    /**
     * Возвращает коффициент спроса по таблице 6.1
     *
     * @param Integer $Np - количество потребителей
     * @param Integer $rowNum - номер строки в таблице
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_6_1($Np = null, $rowNum = null){
        if($Np === null || $rowNum === null)
            return null;
        if(!in_array($rowNum,[1,2,3,4]))
            return null;        
        if($rowNum == 1){
            if($Np >= 0 && $Np <= 5)
                return 4.5;
            if($Np > 5 && $Np <= 6)
                return $this->interpolation(5,4.5,$Np,6,2.8);
            if($Np > 6 && $Np <= 9)
                return $this->interpolation(6,2.8,$Np,9,2.3);
            if($Np > 9 && $Np <= 12)
                return $this->interpolation(9,2.3,$Np,12,2);
            if($Np > 12 && $Np <= 15)
                return $this->interpolation(12,2,$Np,15,1.8);
            if($Np > 15 && $Np <= 18)
                return $this->interpolation(15,1.8,$Np,18,1.65);
            if($Np > 18 && $Np <= 24)
                return $this->interpolation(18,1.65,$Np,24,1.4);
            if($Np > 24 && $Np <= 40)
                return $this->interpolation(24,1.4,$Np,40,1.2);
            if($Np > 40 && $Np <= 60)
                return $this->interpolation(40,1.2,$Np,60,1.05);
            if($Np > 60 && $Np <= 100)
                return $this->interpolation(60,1.05,$Np,100,0.85);
            if($Np > 100 && $Np <= 200)
                return $this->interpolation(100,0.85,$Np,200,0.77);
            if($Np > 200 && $Np <= 400)
                return $this->interpolation(200,0.77,$Np,400,0.71);
            if($Np > 400 && $Np <= 600)
                return $this->interpolation(400,0.71,$Np,600,0.69);
            if($Np > 600 && $Np <= 1000)
                return $this->interpolation(600,0.69,$Np,1000,0.67);
            if($Np > 1000)
                return 0.67;
        }
        if($rowNum == 2){
            if($Np >= 0 && $Np <= 5)
                return 6;
            if($Np > 5 && $Np <= 6)
                return $this->interpolation(5,6,$Np,6,3.4);
            if($Np > 6 && $Np <= 9)
                return $this->interpolation(6,3.4,$Np,9,2.9);
            if($Np > 9 && $Np <= 12)
                return $this->interpolation(9,2.9,$Np,12,2.5);
            if($Np > 12 && $Np <= 15)
                return $this->interpolation(12,2.5,$Np,15,2.2);
            if($Np > 15 && $Np <= 18)
                return $this->interpolation(15,2.2,$Np,18,2);
            if($Np > 18 && $Np <= 24)
                return $this->interpolation(18,2,$Np,24,1.8);
            if($Np > 24 && $Np <= 40)
                return $this->interpolation(24,1.8,$Np,40,1.4);
            if($Np > 40 && $Np <= 60)
                return $this->interpolation(40,1.4,$Np,60,1.3);
            if($Np > 60 && $Np <= 100)
                return $this->interpolation(60,1.3,$Np,100,1.08);
            if($Np > 100 && $Np <= 200)
                return $this->interpolation(100,1.08,$Np,200,1);
            if($Np > 200 && $Np <= 400)
                return $this->interpolation(200,1,$Np,400,0.92);
            if($Np > 400 && $Np <= 600)
                return $this->interpolation(400,0.92,$Np,600,0.84);
            if($Np > 600 && $Np <= 1000)
                return $this->interpolation(600,0.84,$Np,1000,0.76);
            if($Np > 1000)
                return 0.76;
        }
        if($rowNum == 3){
            if($Np >= 0 && $Np <= 5)
                return 10;
            if($Np > 5 && $Np <= 6)
                return $this->interpolation(5,10,$Np,6,5.1);
            if($Np > 6 && $Np <= 9)
                return $this->interpolation(6,5.1,$Np,9,3.8);
            if($Np > 9 && $Np <= 12)
                return $this->interpolation(9,3.8,$Np,12,3.2);
            if($Np > 12 && $Np <= 15)
                return $this->interpolation(12,3.2,$Np,15,2.8);
            if($Np > 15 && $Np <= 18)
                return $this->interpolation(15,2.8,$Np,18,2.6);
            if($Np > 18 && $Np <= 24)
                return $this->interpolation(18,2.6,$Np,24,2.2);
            if($Np > 24 && $Np <= 40)
                return $this->interpolation(24,2.2,$Np,40,1.95);
            if($Np > 40 && $Np <= 60)
                return $this->interpolation(40,1.95,$Np,60,1.7);
            if($Np > 60 && $Np <= 100)
                return $this->interpolation(60,1.7,$Np,100,1.5);
            if($Np > 100 && $Np <= 200)
                return $this->interpolation(100,1.5,$Np,200,1.36);
            if($Np > 200 && $Np <= 400)
                return $this->interpolation(200,1.36,$Np,400,1.27);
            if($Np > 400 && $Np <= 600)
                return $this->interpolation(400,1.27,$Np,600,1.23);
            if($Np > 600 && $Np <= 1000)
                return $this->interpolation(600,1.23,$Np,1000,1.19);
            if($Np > 1000)
                return 1.19;
        }
        if($rowNum == 4){
            if($Np >= 0 && $Np <= 5)
                return 4;
            if($Np > 5 && $Np <= 6)
                return $this->interpolation(5,4,$Np,6,2.3);
            if($Np > 6 && $Np <= 9)
                return $this->interpolation(6,2.3,$Np,9,1.7);
            if($Np > 9 && $Np <= 12)
                return $this->interpolation(9,1.7,$Np,12,1.4);
            if($Np > 12 && $Np <= 15)
                return $this->interpolation(12,1.4,$Np,15,1.2);
            if($Np > 15 && $Np <= 18)
                return $this->interpolation(15,1.2,$Np,18,1.1);
            if($Np > 18 && $Np <= 24)
                return $this->interpolation(18,1.1,$Np,24,0.9);
            if($Np > 24 && $Np <= 40)
                return $this->interpolation(24,0.9,$Np,40,0.76);
            if($Np > 40 && $Np <= 60)
                return $this->interpolation(40,0.76,$Np,60,0.69);
            if($Np > 60 && $Np <= 100)
                return $this->interpolation(60,0.69,$Np,100,0.61);
            if($Np > 100 && $Np <= 200)
                return $this->interpolation(100,0.61,$Np,200,0.58);
            if($Np > 200 && $Np <= 400)
                return $this->interpolation(200,0.58,$Np,400,0.54);
            if($Np > 400 && $Np <= 600)
                return $this->interpolation(400,0.54,$Np,600,0.51);
            if($Np > 600 && $Np <= 1000)
                return $this->interpolation(600,0.51,$Np,1000,0.46);
            if($Np > 1000)
                return 0.46;
        }
    }

    /**
     * Возвращает коффициент спроса по таблице 6.11 для K
     *
     * @param Float $PpOsvSil - PpOsvSil
     * @param Float $PpHol - PpHol
     * @param Integer $rowNum - номер строки в таблице
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_6_11_K($PpOsvSil = null, $PpHol = null , $rowNum = null){
        if($PpOsvSil === null || $PpHol === null || $rowNum === null)
            return null;
        if(!in_array($rowNum,[1,2,3,4,5]))
            return null;
        if( $PpHol == 0 ){
            if( $rowNum == 1 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return $this->interpolation(20,0.9,$PpOsvSil,75,0.85);
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return $this->interpolation(75,0.85,$PpOsvSil,140,0.9);
                if( $PpOsvSil >= 140 && $PpOsvSil <= 250 )
                    return 0.9;
                if( $PpOsvSil > 250 )
                    return 1.0;
            }
            if( $rowNum == 2 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return $this->interpolation(20,0.95,$PpOsvSil,75,0.9);
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return $this->interpolation(75,0.9,$PpOsvSil,140,0.95);
                if( $PpOsvSil >= 140 && $PpOsvSil <= 250 )
                    return 0.95;
                if( $PpOsvSil > 250 )
                    return 1.0;
            }
            if( $rowNum == 3 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return $this->interpolation(20,0.85,$PpOsvSil,75,0.8);
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return $this->interpolation(75,0.8,$PpOsvSil,140,0.85);
                if( $PpOsvSil >= 140 && $PpOsvSil <= 250 )
                    return 0.85;
                if( $PpOsvSil > 250 )
                    return 1.0;
            }
            if( $rowNum == 4 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return $this->interpolation(20,0.85,$PpOsvSil,75,0.75);
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return $this->interpolation(75,0.75,$PpOsvSil,140,0.85);
                if( $PpOsvSil >= 140 && $PpOsvSil <= 250 )
                    return 0.85;
                if( $PpOsvSil > 250 )
                    return 1.0;
            }
            if( $rowNum == 5 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return $this->interpolation(20,0.95,$PpOsvSil,75,0.9);
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return $this->interpolation(75,0.9,$PpOsvSil,140,0.95);
                if( $PpOsvSil >= 140 && $PpOsvSil <= 250 )
                    return 0.95;
                if( $PpOsvSil > 250 )
                    return 1.0;
            }
        } else {
            if( $rowNum == 1 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return 0.85;
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return 0.75;
                if( $PpOsvSil >= 140 && $PpOsvSil < 250 )
                    return 0.85;
                if( $PpOsvSil >= 250 )
                    return 1;
            }
            if( $rowNum == 2 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return 0.95;
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return 0.9;
                if( $PpOsvSil >= 140 && $PpOsvSil < 250 )
                    return 0.95;
                if( $PpOsvSil >= 250 )
                    return 1;
            }
            if( $rowNum == 3 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return 0.85;
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return 0.8;
                if( $PpOsvSil >= 140 && $PpOsvSil < 250 )
                    return 0.85;
                if( $PpOsvSil >= 250 )
                    return 1;
            }
            if( $rowNum == 4 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return 0.85;
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return 0.75;
                if( $PpOsvSil >= 140 && $PpOsvSil < 250 )
                    return 0.85;
                if( $PpOsvSil >= 250 )
                    return 1;
            }
            if( $rowNum == 5 ){
                if( $PpOsvSil >= 0 && $PpOsvSil < 20 )
                    return 1;
                if( $PpOsvSil >= 20 && $PpOsvSil < 75 )
                    return 0.85;
                if( $PpOsvSil >= 75 && $PpOsvSil < 140 )
                    return 0.75;
                if( $PpOsvSil >= 140 && $PpOsvSil < 250 )
                    return 0.85;
                if( $PpOsvSil >= 250 )
                    return 1;
            }
        }
    }   
    
    
    /**
     * Возвращает коффициент спроса по таблице 6.11 для K
     *
     * @param Float $PpOsvHol - PpOsvHol
     * @return Float $Kc - коэффициент спроса
     * 
     */
    function getKcByTab_6_11_K1($PpOsvHol = null){
        if($PpOsvHol === null)
            return null;
        if( $PpOsvHol >= 0 && $PpOsvHol < 15 )
            return 1;
        if( $PpOsvHol >= 15 && $PpOsvHol < 20 )
            return $this->interpolation(15,1,$PpOsvHol,20,0.8);
        if( $PpOsvHol >= 20 && $PpOsvHol < 50 )
            return $this->interpolation(75,0.8,$PpOsvHol,140,0.6);
        if( $PpOsvHol >= 50 && $PpOsvHol < 100 )
            return $this->interpolation(75,0.6,$PpOsvHol,140,0.4);
        if( $PpOsvHol >= 100 && $PpOsvHol < 150 )
            return $this->interpolation(75,0.4,$PpOsvHol,140,0.2);
        if( $PpOsvHol >= 150 )
            return 0.2;

    }   
}
