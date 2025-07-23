<?php
class ReportController {
    private ReportModel $model;

    public function __construct(ReportModel $model) {
        $this->model = $model;
    }

    public function generateReport(string $reportType, string $format, $param = null): void {
        try {
            switch ($reportType) {
                case 'all_users':
                    $data = $this->model->getAllUsers();
                    $filename = "all_users_" . date('Ymd_His');
                    break;

                case 'all_workshops':
                    $data = $this->model->getAllWorkshops();
                    $filename = "all_workshops_" . date('Ymd_His');
                    break;

                case 'users_with_workshops':
                    $data = $this->model->getUsersWithWorkshops();
                    $filename = "users_with_workshops_" . date('Ymd_His');
                    break;

                case 'workshops_with_users':
                    $data = $this->model->getWorkshopsWithUsers();
                    $filename = "workshops_with_users_" . date('Ymd_His');
                    break;

                case 'workshops_by_user':
                    if (!is_string($param) || empty($param)) {
                        throw new InvalidArgumentException("Username required as non-empty string.");
                    }
                    $data = $this->model->getWorkshopsByUser($param);
                    $safeParam = preg_replace('/[^a-zA-Z0-9_-]/', '_', $param);
                    $filename = "workshops_by_user_{$safeParam}_" . date('Ymd_His');
                    break;

                case 'users_by_workshop':
                    if (!is_string($param) || empty($param)) {
                        throw new InvalidArgumentException("Workshop title required as non-empty string.");
                    }
                    $data = $this->model->getUsersByWorkshop($param);
                    $safeParam = preg_replace('/[^a-zA-Z0-9_-]/', '_', $param);
                    $filename = "users_by_workshop_{$safeParam}_" . date('Ymd_His');
                    break;

                default:
                    throw new InvalidArgumentException("Invalid report type.");
            }

            if ($format === 'json') {
                header('Content-Type: application/json');
                header("Content-Disposition: attachment; filename=\"{$filename}.json\"");
                echo json_encode($data, JSON_PRETTY_PRINT);

            } elseif ($format === 'xml') {
                header('Content-Type: application/xml');
                header("Content-Disposition: attachment; filename=\"{$filename}.xml\"");

                $xml = new SimpleXMLElement('<report/>');
                $this->arrayToXml($data, $xml);
                echo $xml->asXML();

            } else {
                throw new InvalidArgumentException("Unsupported format.");
            }

        } catch (InvalidArgumentException $e) {
            $this->sendErrorResponse(400, $e->getMessage());

        } catch (NotFoundException $e) {
            $this->sendErrorResponse(404, $e->getMessage());

        } catch (Exception $e) {
            $this->sendErrorResponse(500, "Internal server error: " . $e->getMessage());
        }
    }

    private function sendErrorResponse(int $statusCode, string $message): void {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => $message,
        ]);
        exit;
    }

    private function arrayToXml(array $data, SimpleXMLElement &$xml): void {
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = "item{$key}";
            }
            if (is_array($value)) {
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars((string)$value));
            }
        }
    }
}
