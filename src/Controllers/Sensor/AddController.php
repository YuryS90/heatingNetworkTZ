<?php

namespace Controllers\Sensor;

use Common\ControllerTrait;
use Psr\Http\Message\ResponseInterface;

class AddController
{
    use ControllerTrait;

    /**
     * @return ResponseInterface
     */
    public function run(): ResponseInterface
    {
        // Сохраняем массив данных, который пришёл из маршрута "Отправить данные"
        $request = $this->getBody();

        // Сохраняем значения данных в v1 и v2, и обрабатываем
        $v1 = $request['sensorOne'] ?? null;
        $v2 = $request['sensorTwo'];

        if (empty($v1)) {
            $v1 = 'данные отсутствуют';
        }

        if (empty($v2)) {
            $v2 = 'данные отсутствуют';
        }

        // Если данные с датчиков пришли
        if ($v1 !== 'данные отсутствуют' && $v2 !== 'данные отсутствуют') {

            // Получаем массив данных из БД
            $table = $this->db->getDataSensor();

            // Если таблица пустая, то не делаем расчёты, а просто добавляем
            if (empty($table)) {
                $this->db->query("INSERT INTO `sensor` (`V1`, `V2`) VALUES ('$v1', '$v2')");
            }

            // Если таблица не пустая
            if (!empty($table)) {

                // Получаем последний элемент (предыдущий)
                $oldData = end($table);

                // Если у предыдущего нет данных "данные отсутствуют", то не рассчитываем
                if ($oldData['V1'] !== "данные отсутствуют" && $oldData['V2'] !== "данные отсутствуют") {
                    // Подготовка к расчёту
                    $oldV1 = (double)$oldData['V1'];
                    $oldV2 = (double)$oldData['V2'];
                    $v1 = (double)$v1;
                    $v2 = (double)$v2;

                    // Расчёт погрешности
                    $interestError = round(((($v1 - $oldV1) - ($v2 - $oldV2)) / ($v1 - $oldV1)) * 100, 2);

                    // Добавление новых данный в БД
                    $this->db->query("INSERT INTO `sensor` (`V1`, `V2`, `interest`) VALUES ('$v1', '$v2', '$interestError')");
                } else {
                    $this->db->query("INSERT INTO `sensor` (`V1`, `V2`) VALUES ('$v1', '$v2')");
                }
            }

        } else {
            // При условии, если "данные отсутствуют"
            $this->db->query("INSERT INTO `sensor` (`V1`, `V2`) VALUES ('$v1', '$v2')");
        }

        // Перенаправление
        $view = $this->twig->render('show.twig', [
            'table' => $table,
        ]);

        $this->write($view);

        return $this->response;
    }
}