<?php
namespace HjsonResponse;

use InvalidArgumentException;
use Exception;

class HjsonResponse
{
    protected $http_code = 200;
    protected $error_code = 0;
    protected $data;

    public function __toString()
    {
        $this->toResponse($this->data, $this->getHttpCode());
    }

    /**
     * http 标准.
     */
    public function setHttpCode(int $http_code)
    {
        $this->http_code = $http_code;

        return $this;
    }

    /**
     * 自定义错误码
     */
    public function setErrorCode(int $error_code)
    {
        $this->error_code = $error_code;

        return $this;
    }

    public function getHttpCode()
    {
        return $this->http_code;
    }

    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * 下行处理.
     *
     * @param mix $ret
     * @param int $http_code 标准http码
     */
    public function toResponse($data, $http_code = null, $errno = null)
    {
        if ($http_code && $http_code < 200) {
            throw new InvalidArgumentException('下行返回http_code不能小于200');
        }
        $response_data = [
            'errno' => $errno ?? $this->getErrorCode(),
            'message' => '',
            'data' => [],
        ];

        if (is_array($data) && $this->isArrayDataHashType($data)) {
            $response_data['data'] = $data;
        } elseif ($data instanceof Exception) {
            $response_data['errno'] = $data->getCode() ?: 5000;
            $response_data['message'] = $data->getMessage();
            $http_code = $http_code ?? 500;
        } elseif (is_string($data)) {
            $response_data['message'] = $data;
        }
        $http_code = $http_code ?? $this->getHttpCode();

        return response()->json($response_data, $http_code);
    }

    /**
     * 下行数据是否为纯数组
     *
     * @param array $data
     * @return bool
     */
    protected function isArrayDataHashType(array $data)
    {
        if (array_values($data) === $data) {
            throw new \Exception('下行数据格式不能为纯数组');
        }

        return true;
    }
}
